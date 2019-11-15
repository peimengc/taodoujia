<?php

namespace App\Http\Controllers;

use App\Models\DouTopTaskInfo;
use App\Models\TbkOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        if (!$request->has('date')) {
            $request->offsetSet('date', 1);
        }
        $this->request = $request;
    }

    public function index(Request $request)
    {
        //订单按小时分组统计
        $order = TbkOrder::query()
            ->select(
                DB::raw('COUNT(id) as order_count'),
                DB::raw('SUM(pub_share_pre_fee) as order_fee')
            )
            ->date($this->request->get('date'))
            ->where('tk_status', '!=', TbkOrder::ORDER_CLOSE_STATUS)
            ->first();
        //消耗按小时分组统计并关联订单统计
        $task = DouTopTaskInfo::query()
            ->select(
                DB::raw('SUM(cost) as task_cost')
            )
            ->date($this->request->get('date'))
            ->first();

        $homeMinBoxData = [
            [
                'name'  => '有效佣金(' . $order->order_count . ')',
                'value' => $order->order_fee ?? 0,
            ],
            [
                'name'  => 'DOU+消耗',
                'value' => $task->task_cost ?? 0,
            ],
            [
                'name'  => '淘豆荚净利',
                'value' => ($order->order_fee - $task->task_cost) ?? 0,
            ],
            [
                'name'  => '淘豆荚ROI',
                'value' => $task->task_cost > 0 ? round($order->order_fee / $task->task_cost,2) : '--',
            ],
        ];

        return view('home', compact('homeMinBoxData'));
    }
}
