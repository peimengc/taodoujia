@extends('layouts.app')

@inject('tbkOrderModel','App\Models\TbkOrder')

@section('content')
    <div class="container bg-white py-3">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="border-bottom">
                    <div class="float-right">
                        <a href="{{ route('douAccounts.create') }}" class="btn btn-primary">添加账号</a>
                    </div>
                    <h4>投放账号</h4>
                    <span>投放账号 <u class="c-blue">{{ $douAccounts->total() }}</u></span>
                </div>
            </div>
            {{--search--}}
            <div class="col-md-12 my-3">
                <form>
                    <div class="row">

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
                            <th>账号</th>
                            <th>广告位ID</th>
                            <th>手机号</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($douAccounts as $account)
                            <tr>
                                <td>{{ $account->id }}</td>
                                @include('douAccounts._td')
                                <td>{{ $account->adzone_id }}</td>
                                <td>{{ $account->phone }}</td>
                                <td>
                                    <a href="{{ route('douAccounts.edit',$account) }}">编辑</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div>
                {{ $douAccounts->links() }}
            </div>
        </div>
    </div>
@endsection
