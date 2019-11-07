@extends('layouts.app')

@section('content')
    <div class="container bg-white py-3">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="border-bottom">
                    <h4>时段统计</h4>
                    <span>淘豆荚时段统计</span>
                </div>
            </div>
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-hover table-data">
                        <thead>
                        <tr>
                            <th>小时</th>
                            <th>消耗</th>
                            <th>佣金</th>
                            <th>订单</th>
                            <th>净利</th>
                            <th>产出比</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $hour)
                            <tr>
                                <td>{{ $hour->hour }}</td>
                                <td>{{ $hour->dou_task_cost }}</td>
                                <td>{{ $hour->tbk_order_fee }}</td>
                                <td>{{ $hour->tbk_order_count }}</td>
                                <td>{{ $hour->tbk_order_fee-$hour->dou_task_cost }}</td>
                                <td>{{ $hour->tbk_order_fee/$hour->dou_task_cost }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection