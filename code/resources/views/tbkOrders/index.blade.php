@extends('layouts.app')

@inject('tbkOrderModel','App\Models\TbkOrder')

@section('content')
    <div class="container bg-white py-3">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="border-bottom">
                    <h4>联盟订单</h4>
                    <span>联盟订单 <u class="c-blue">{{ $tbkOrders->total() }}</u></span>
                </div>
            </div>
            {{--search--}}
            <div class="col-md-12 my-3">
                <form>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="sr-only" for="item_title">商品编号/名称</label>
                                <input type="text" class="form-control" name="item_title" id="item_title"
                                       placeholder="商品编号/名称" value="{{ request('item_title') }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="sr-only" for="tbkauth">全部抖音账号</label>
                                <select class="form-control" id="tbkauth" name="account_id">
                                    <option value="">全部抖音账号</option>
                                    @foreach($douAccounts as $douAccount)
                                        <option value="{{ $douAccount->id }}"
                                                @if($douAccount->id == request('account_id')) selected @endif>{{ $douAccount->nick }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="sr-only" for="tbkauth">全部联盟授权账号</label>
                                <select class="form-control" id="tbkauth" name="authorize_id">
                                    <option value="">全部授权账号</option>
                                    @foreach($tbkAuthorizes as $tbkAuth)
                                        <option value="{{ $tbkAuth->id }}"
                                                @if($tbkAuth->id == request('authorize_id')) selected @endif>{{ $tbkAuth->tb_user_nick }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="sr-only" for="tk_status">所有订单状态</label>
                                <select class="form-control" id="tk_status" name="tk_status">
                                    <option value="">所有订单状态</option>
                                    @foreach($tbkOrderModel->tkStatusArr as $k => $v)
                                        <option value="{{ $k }}"
                                                @if($k == request('tk_status')) selected @endif>{{ $v }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="btn-group">
                                <button type="submit" class="btn btn-primary">提交</button>
                                <a class="btn btn-secondary" href="{{ url()->current() }}">返回</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            {{--teable--}}
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-hover table-data">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>商品</th>
                            <th>出单账号</th>
                            <th>状态</th>
                            <th>价格</th>
                            <th>预估 / 结算</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($tbkOrders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>
                                    <div class="thum-box">
                                        <img src="{{ $order->item_img }}"
                                             alt="商品图片">
                                        <div class="ml-1 d-inline-block align-middle">
                                            <div>
                                                <a target="_blank" href="{{ $order->item_link }}">{{ $order->item_title }}</a>
                                                <div class="font08 c-dgray">
                                                    <span>商品编号：{{ $order->item_id }}</span>
                                                    <span>付款时间：{{ $order->tk_paid_time }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $order->douaccount->nick }}</td>
                                <td>{{ $order->tk_status_cn }}</td>
                                <td>{{ $order->item_price }} / {{ $order->alipay_total_price }}</td>
                                <td>{{ $order->pub_share_pre_fee }} / {{ $order->total_commission_fee }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div>
                {{ $tbkOrders->links() }}
            </div>
        </div>
    </div>
@endsection
