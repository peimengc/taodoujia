<?php

namespace App\Http\Controllers;

use App\Models\TbkAuthorize;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class TbkAuthorizeController extends Controller
{
    public function index(Request $request)
    {
        $tbkAuthorizes = TbkAuthorize::query()->paginate();

        return view('tbkAuthorizes.index', compact('tbkAuthorizes'));
    }

    public function create()
    {
        return view('tbkAuthorizes.create');
    }

    public function store(Request $request)
    {
        //转数组
        $auth_arr = json_decode($request->input('auth_json'), 1);
        //预定义
        $attr = [
            'auth_json' => $auth_arr
        ];

        $attr['expire_time'] = date('Y-m-d H:i:s', Arr::get($auth_arr, 'expire_time') / 1000);
        $attr['tb_user_nick'] = Arr::get($auth_arr, 'taobao_user_nick');
        $attr['tb_user_id'] = Arr::get($auth_arr, 'taobao_user_id');
        $attr['access_token'] = Arr::get($auth_arr, 'access_token');

        TbkAuthorize::query()->updateOrCreate(Arr::only($attr, 'tb_user_id'), $attr);

        return redirect()->route('tbkAuthorizes.index')->with([
            'alert' => [
                'type' => 'success',
                'content' => '联盟授权新增成功'
            ]
        ]);
    }
}
