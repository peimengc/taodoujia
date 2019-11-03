<?php

namespace App\Http\Controllers;

use App\Models\TbkOrder;
use Illuminate\Http\Request;

class TbkOrderController extends Controller
{
    public function index(Request $request)
    {
        $tbkOrders = TbkOrder::query()->paginate();

        return view('tbkOrders.index', compact('tbkOrders'));
    }
}
