<?php

namespace App\Http\Controllers;

use App\Models\DouTopTaskInfo;
use App\Models\TbkOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DouJiaTongJiController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        if (!$request->has('date')) {
            $request->offsetSet('date', date('Y-m-d'));
        }
        $this->request = $request;
    }

    public function hour()
    {
        //订单按小时分组统计
        $orders = TbkOrder::query()
            ->select(
                DB::raw('DATE_FORMAT(tk_create_time,\'%H:00\') as hour'),
                DB::raw('COUNT(id) as tbk_order_count'),
                DB::raw('SUM(pub_share_pre_fee) as tbk_order_fee'),
                DB::raw('0 as dou_task_cost')
            )
            ->whereDate('tk_create_time', $this->request->get('date'))
            ->where('tk_status', '!=', TbkOrder::ORDER_CLOSE_STATUS)
            ->groupBy('hour');

        //消耗按小时分组统计并关联订单统计
        $data = DouTopTaskInfo::query()
            ->select(
                DB::raw('DATE_FORMAT(created_at,\'%H:00\') as hour'),
                DB::raw('SUM(cost) as dou_task_cost'),
                DB::raw('0 as tbk_order_count'),
                DB::raw('0 as tbk_order_fee')
            )
            ->whereDate('created_at', $this->request->get('date'))
            ->groupBy('hour')
            ->having('dou_task_cost', '>', 0)
            ->union($orders)
            ->get();

        return view('douJiaTongJi.hour', compact('data'));
    }
}
