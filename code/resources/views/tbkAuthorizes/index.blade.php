@extends('layouts.app')

@section('content')
    <div class="container bg-white py-3">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="border-bottom">
                    <div class="float-right">
                        <a class="btn btn-primary" href="{{ route('tbkAuthorizes.create') }}" >新增授权</a>
                    </div>
                    <h4>联盟授权</h4>
                    <span>联盟授权</span>
                </div>
            </div>
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-hover table-data">
                        <thead>
                        <tr>
                            <th>编号</th>
                            <th>昵称/ID</th>
                            <th>到期时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($tbkAuthorizes as $authorize)
                            <tr>
                                <td>{{ $authorize->id }}</td>
                                <td>
                                    <div class="d-inline-block">
                                        {{ $authorize->tb_user_nick }}
                                        <div class="font1 c-dgray">{{ $authorize->tb_user_id }}</div>
                                    </div>
                                </td>
                                <td>{{ $authorize->expire_time }}</td>
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
