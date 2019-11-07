<?php

namespace App\Http\Controllers;

use App\Models\DouTopTaskInfo;
use App\Models\TbkOrder;
use Illuminate\Database\Query\Builder;
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
        $orderQuery = TbkOrder::query()
            ->select(
                DB::raw('DATE_FORMAT(tk_create_time,\'%H:00\') as hour'),
                DB::raw('0 as task_cost'),
                DB::raw('COUNT(id) as order_count'),
                DB::raw('SUM(pub_share_pre_fee) as order_fee')
            )
            ->whereDate('tk_create_time', $this->request->get('date'))
            ->where('tk_status', '!=', TbkOrder::ORDER_CLOSE_STATUS)
            ->groupBy('hour');

        //消耗按小时分组统计并关联订单统计
        $taskInfoQuery = DouTopTaskInfo::query()
            ->select(
                DB::raw('DATE_FORMAT(created_at,\'%H:00\') as hour'),
                DB::raw('SUM(cost) as task_cost'),
                DB::raw('0 as order_count'),
                DB::raw('0 as order_fee')
            )
            ->whereDate('created_at', $this->request->get('date'))
            ->groupBy('hour')
            ->unionAll($orderQuery);

        //投放跟订单union后再group
        $data = DB::query()
            ->select(
               'hour',
                DB::raw('SUM(task_cost) as dou_task_cost'),
                DB::raw('SUM(order_count) as tbk_order_count'),
                DB::raw('SUM(order_fee) as tbk_order_fee')
            )
            ->fromSub($taskInfoQuery,'doutask_tbkorder')
            ->groupBy('hour')
//            ->having('dou_task_cost', '>', 0)
            ->get();

        return view('douJiaTongJi.hour', compact('data'));
    }
}
