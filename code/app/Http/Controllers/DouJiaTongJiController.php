<?php

namespace App\Http\Controllers;

use App\Models\DouAccount;
use App\Models\DouplusTaskInc;
use App\Models\DouTopTaskInfo;
use App\Models\TbkOrder;
use Illuminate\Database\Eloquent\Builder;
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
            ->unionAll($orderQuery)
            ->whereDate('created_at', $this->request->get('date'))
            ->groupBy('hour');

        //投放跟订单union后再group
        $data = DB::query()
            ->select(
                'hour',
                DB::raw('SUM(task_cost) as dou_task_cost'),
                DB::raw('SUM(order_count) as tbk_order_count'),
                DB::raw('SUM(order_fee) as tbk_order_fee')
            )
            ->fromSub($taskInfoQuery, 'doutask_tbkorder')
            ->groupBy('hour')
//            ->having('dou_task_cost', '>', 0)
            ->get();

        return view('douJiaTongJi.hour', compact('data'));
    }

    public function douAccount()
    {
        //订单按账号分组统计
        $orderQuery = TbkOrder::query()
            ->select(
                'account_id',
                DB::raw('COUNT(id) as order_count'),
                DB::raw('SUM(pub_share_pre_fee) as order_fee')
            )
            ->whereDate('tk_create_time', $this->request->get('date'))
            ->where('tk_status', '!=', TbkOrder::ORDER_CLOSE_STATUS)
            ->whereNotNull('account_id')
            ->groupBy('account_id');

        $taskInfoQuery = DouTopTaskInfo::query()
            ->select(
                DB::raw('dou_top_tasks.aweme_author_id AS aweme_author_id'),
                DB::raw('SUM(dou_top_task_infos.cost) AS task_cost')
            )
            ->leftJoin('dou_top_tasks', 'dou_top_tasks.task_id', '=', 'dou_top_task_infos.task_id')
            ->whereDate('dou_top_task_infos.created_at', $this->request->get('date'))
            ->groupBy('aweme_author_id');

        //消耗按账号分组统计并关联订单统计
        $data = DouAccount::query()
            ->select(
                'id',
                'nick',
                'username',
                'order_count',
                'order_fee',
                'task_cost',
                DB::raw('order_fee - task_cost as profit'),
                DB::raw('order_fee / task_cost as profitp')
            )
            ->leftJoinSub($orderQuery, 'orders', function ($join) {
                $join->on('dou_accounts.id', '=', 'orders.account_id');
            })
            ->leftJoinSub($taskInfoQuery, 'tasks', function ($join) {
                $join->on('dou_accounts.user_id', '=', 'tasks.aweme_author_id');
            })
            ->where('task_cost', '>', 0)
            ->get();

        return view('douJiaTongJi.douAccount', compact('data'));
    }

}
