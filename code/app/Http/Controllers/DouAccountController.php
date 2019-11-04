<?php

namespace App\Http\Controllers;

use App\Helpers\Dou\DouAccountAttrGetHelper;
use App\Models\DouAccount;
use Illuminate\Http\Request;

class DouAccountController extends Controller
{
    public function index(Request $request)
    {
        $douAccounts = DouAccount::query()
            ->paginate()->appends($request->all());

        return view('douAccounts.index',compact('douAccounts'));
    }

    public function create(DouAccount $douAccount)
    {
        return view('douAccounts.create', compact('douAccount'));
    }

    public function store(Request $request, DouAccount $douAccount)
    {
        $request->validate([
            'url' => 'required',
            'phone' => 'required|unique:dou_accounts'
        ], [], [
            'url' => '主页链接',
            'phone' => '手机号'
        ]);

        $attribute = (new DouAccountAttrGetHelper($request->input('url')))->getAttribute();

        $douAccount->fill($attribute + $request->only(['phone', 'adzone_id']))->save();

        return redirect()->route('douAccounts.index');
    }

    public function edit(DouAccount $douAccount)
    {
        return view('douAccounts.edit', compact('douAccount'));
    }

    public function update(Request $request, DouAccount $douAccount)
    {
        $request->validate([
            'phone' => 'required|unique:dou_accounts,phone,' . $douAccount->id
        ], [], [
            'phone' => '手机号'
        ]);

        $douAccount->fill($request->only(['phone', 'adzone_id']))->save();

        return redirect()->route('douAccounts.index');
    }
}
