<?php


namespace App\Services;


use App\Models\DouAccount;
use App\Models\TbkOrder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

class TbkOrderService
{
    /**
     * 根据api 存储不存在的订单
     * @param array $data
     * @param $token
     */
    public function saveByApi(array $data, $token)
    {
        if (empty($data)) {
            return;
        }

        //操作时间维护
        $date = date('Y-m-d H:i:s');
        $atArr = [
            'created_at' => $date,
            'updated_at' => $date,
        ];
        //获取授权id,关联
        $tbkAuthorizeId = app(TbkAuthorizeService::class)->getIdByToken($token);
        //获取账号推广位数组
        $douAccountAdzoneIdArr = app(DouAccountService::class)->getAllAdzoneIdKeyIsId();
        //集合
        $colData = collect($data);
        //获取所有tradeId
        $allTradeIdArr = $colData->pluck('trade_id')->all();
        //查询已存在的
        $existTradeIdArr = TbkOrder::query()->whereIn('trade_id', $allTradeIdArr)->pluck('trade_id')->all();
        //集合过滤掉已存在的
        $attributes = $colData->filter(function ($item) use ($existTradeIdArr) {
            return !in_array(Arr::get($item, 'trade_id'), $existTradeIdArr);
        })->map(function ($item) use ($tbkAuthorizeId, $atArr, $douAccountAdzoneIdArr) {
            $data                 = Arr::only($item, app(TbkOrder::class)->getFillable());
            $data['authorize_id'] = $tbkAuthorizeId;
            $data['account_id']   = Arr::get($douAccountAdzoneIdArr, $data['adzone_id']);
            return array_merge($data, $atArr);
        })->all();
        //批量写入
        TbkOrder::query()->insert($attributes);
    }

    /**
     * 订单绑定账号  根据账号推广位绑定账号
     * @param DouAccount $douAccount
     * @return int
     */
    public function bindAccountByAdzoneId(DouAccount $douAccount)
    {
        return TbkOrder::query()
            ->where('adzone_id', $douAccount->adzone_id)
            ->where(function (Builder $builder) {
                $builder->whereNull('account_id')
                    ->orWhere('account_id', '=', 0);
            })
            ->update([
                'account_id' => $douAccount->id
            ]);
    }
}