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
        'duration',
        'delivery_start_time',
    ];

    protected $dates = [
        'create_time',
    ];

    const TASK_DELIVERY_STATE = 1;
    const TASK_REVIEW_STATE = 2;
    const TASK_FAIL_STATE = 12;
    const TASK_COMPLETE_STATE = 14;

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
}
