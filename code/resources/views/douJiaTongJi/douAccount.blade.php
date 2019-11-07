@extends('layouts.app')

@section('content')
    <div class="container bg-white py-3">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="border-bottom">
                    <h4>账号统计</h4>
                    <span>淘豆荚账号统计</span>
                </div>
            </div>
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-hover table-data">
                        <thead>
                        <tr>
                            <th>账号</th>
                            <th>消耗</th>
                            <th>佣金</th>
                            <th>订单</th>
                            <th>净利</th>
                            <th>产出比</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $account)
                            <tr>
                                <td>{{ $account->nick }}</td>
                                <td>{{ $account->task_cost }}</td>
                                <td>{{ $account->order_fee }}</td>
                                <td>{{ $account->order_count }}</td>
                                <td>{{ $account->profit }}</td>
                                <td>{{ $account->profitp }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
