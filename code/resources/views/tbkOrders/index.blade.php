@extends('layouts.app')

@section('content')
    <div class="container bg-white py-3">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="border-bottom">
                    <h4>联盟订单</h4>
                    <span>联盟订单</span>
                </div>
            </div>
            <div class="col-md-12 my-3">
                <form>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="sr-only" for="exampleInputEmail3">Email address</label>
                                <input type="email" class="form-control" id="exampleInputEmail3" placeholder="Email">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="sr-only" for="select">Email address</label>
                                <select class="form-control" id="select">
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="btn-group">
                                <button type="submit" class="btn btn-primary">提交</button>
                                <button type="submit" class="btn btn-default">返回</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-hover table-data">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>商品</th>
                            <th>状态</th>
                            <th>价格</th>
                            <th>预估 / 结算</th>
                            <th>操作</th>
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
                                                <a class="font10"
                                                   href="{{ $order->item_link }}">{{ $order->item_title }}</a>
                                                <div class="font08 c-dgray">付款时间：{{ $order->tk_paid_time }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $order->tk_status }}</td>
                                <td>{{ $order->item_price }} / {{ $order->alipay_total_price }}</td>
                                <td>{{ $order->pub_share_pre_fee }} / {{ $order->total_commission_fee }}</td>
                                <td>

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
