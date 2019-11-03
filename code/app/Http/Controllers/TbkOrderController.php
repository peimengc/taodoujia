<?php

namespace App\Http\Controllers;

use App\Models\TbkAuthorize;
use App\Models\TbkOrder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class TbkOrderController extends Controller
{
    public function index(Request $request)
    {
        $tbkOrders = TbkOrder::query()
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
            ->paginate()->appends($request->all());

        $tbkAuthorizes = TbkAuthorize::query()->get(['id', 'tb_user_nick']);

        return view('tbkOrders.index', compact('tbkOrders', 'tbkAuthorizes'));
    }
}
