<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class TbkOrder extends Model
{
    protected $fillable = [
        'account_id',
        'authorize_id',
        'tb_paid_time',
        'tk_paid_time',
        'pay_price',
        'pub_share_fee',
        'trade_id',
        'tk_order_role',
        'tk_earning_time',
        'adzone_id',
        'pub_share_rate',
        'refund_tag',
        'subsidy_rate',
        'tk_total_rate',
        'item_category_name',
        'seller_nick',
        'pub_id',
        'alimama_rate',
        'subsidy_type',
        'item_img',
        'pub_share_pre_fee',
        'alipay_total_price',
        'item_title',
        'site_name',
        'item_num',
        'subsidy_fee',
        'alimama_share_fee',
        'trade_parent_id',
        'order_type',
        'tk_create_time',
        'flow_source',
        'terminal_type',
        'click_time',
        'tk_status',
        'item_price',
        'item_id',
        'adzone_name',
        'total_commission_rate',
        'item_link',
        'site_id',
        'seller_shop_title',
        'income_rate',
        'total_commission_fee',
        'special_id',
        'relation_id',
    ];

    const ORDER_CLOSE_STATUS = 13;
    const ORDER_OVER_STATUS = 3;
    const ORDER_PAY_STATUS = 12;
    const ORDER_SUC_STATUS = 14;

    //订单状态
    public $tkStatusArr = [
        self::ORDER_OVER_STATUS => '订单结算',
        self::ORDER_PAY_STATUS => '订单付款',
        self::ORDER_CLOSE_STATUS => '订单失效',
        self::ORDER_SUC_STATUS => '订单成功',
    ];

    public function getTkStatusCnAttribute()
    {
        return Arr::get($this->tkStatusArr, $this->tk_status);
    }

    public static function saveByApi(array $data, $token)
    {
        if (empty($data)) {
            return;
        }
        $date = date('Y-m-d H:i:s');

        $atArr = [
            'created_at' => $date,
            'updated_at' => $date,
        ];
        //获取授权id,关联
        $tbkAuthorizeId = TbkAuthorize::query()->where('access_token', $token)->value('id');
        //集合
        $colData = collect($data);
        //获取所有tradeId
        $allTradeIdArr = $colData->pluck('trade_id')->all();
        //查询已存在的
        $existTradeIdArr = static::query()->whereIn('trade_id', $allTradeIdArr)->pluck('trade_id')->all();
        //集合过滤掉已存在的
        $attributes = $colData->filter(function ($item) use ($existTradeIdArr) {
            return !in_array(Arr::get($item, 'trade_id'), $existTradeIdArr);
        })->map(function ($item) use ($tbkAuthorizeId, $atArr) {
            $data = Arr::only($item, (new static)->getFillable());
            $data['authorize_id'] = $tbkAuthorizeId;
            return array_merge($data, $atArr);
        })->all();
        //批量写入
        static::query()->insert($attributes);
    }
}
