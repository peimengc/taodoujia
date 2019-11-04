<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class DouTopTask extends Model
{
    protected $fillable = [
        'task_id',
        'state',
        'product_id',
        'aweme_id',
        'aweme_author_id',
        'cost',
        'create_time',
        'budget',
    ];

    protected $dates = [
        'create_time',
    ];

    const TASK_DELIVERY_STATE = 1;
    const TASK_REVIEW_STATE = 2;
    const TASK_FAIL_STATE = 3;
    const TASK_COMPLETE_STATE = 4;

    //订单状态
    public $stateArr = [
        self::TASK_DELIVERY_STATE => '投放中',
        self::TASK_REVIEW_STATE => '审核中',
        self::TASK_FAIL_STATE => '审核失败',
        self::TASK_COMPLETE_STATE => '投放完成',
    ];

    public function getStateCnAttribute()
    {
        return Arr::get($this->stateArr, $this->state);
    }

    public function douaccount()
    {
        return $this->belongsTo(DouAccount::class, 'aweme_author_id', 'user_id')->withDefault([
            'nick' => '暂未录入'
        ]);
    }

    public static function saveByApi($data)
    {
        if (empty($data)) {
            return;
        }
        $date = date('Y-m-d H:i:s');

        $atArr = [
            'created_at' => $date,
            'updated_at' => $date,
        ];

        $colData = collect($data);
        //获取所有tradeId
        $allTaskIdArr = $colData->pluck('task_id')->all();
        //查询已存在的
        $existTaskIdArr = static::query()->whereIn('task_id', $allTaskIdArr)->pluck('task_id')->all();
        //集合过滤掉已存在的
        $attributes = $colData->filter(function ($item) use ($existTaskIdArr) {
            return !in_array(Arr::get($item, 'task_id'), $existTaskIdArr);
        })->map(function ($item) use ($atArr) {
            return array_merge([
                'task_id' => Arr::get($item, 'task_id'),
                'state' => Arr::get($item, 'state'),
                'aweme_id' => Arr::get($item, 'item_id'),
                'aweme_author_id' => Arr::get($item, 'item_author_id'),
                'create_time' => Arr::get($item, 'create_time'),
                'budget' => Arr::get($item, 'budget_int') / 1000,
            ], $atArr);
        })->all();
        //批量写入
        static::query()->insert($attributes);
    }
}
