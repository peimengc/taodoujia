<?php

namespace App\Http\Controllers;

use App\Helpers\Tbk\TbkOrderHelper;
use App\Models\TbkAuthorize;
use App\Models\TbkOrder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class TbkOrderController extends Controller
{
    public function index(Request $request)
    {
        $tbkOrders = TbkOrder::query()
            ->with(['douaccount'])
            ->when($request->query('item_title'), function (Builder $builder, $item_title) {
                if (is_numeric($item_title)) {
                    $builder->where('item_id', $item_title);
                } else {
                    $builder->where('item_title', 'like', '%' . $item_title . '%');
                }
            })
            ->when($request->query('authorize_id'), function (Builder $builder, $authorize_id) {
                $builder->where('authorize_id', $authorize_id);
            })
            ->when($request->query('tk_status'), function (Builder $builder, $tk_status) {
                $builder->where('tk_status', $tk_status);
            })
            ->orderBy('tk_paid_time', 'desc')
            ->paginate()->appends($request->all());

        $tbkAuthorizes = TbkAuthorize::query()->get(['id', 'tb_user_nick']);

        return view('tbkOrders.index', compact('tbkOrders', 'tbkAuthorizes'));
    }

    public function getHistory(Request $request)
    {
        dispatch(function () {
            $orderHelper = new TbkOrderHelper();
            $tbkAuth = TbkAuthorize::query()->first();
            if ($tbkAuth) {
                $orderHelper->getHistoryOrder($tbkAuth->access_token, now()->addDays(-30)->toDateString());
            }
        });
        return back()->with([
            'alert' => [
                'type' => 'info',
                'content' => '正在获取30天到现在的数据,大概需要10分钟左右'
            ]
        ]);
    }
}
