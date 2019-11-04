@extends('layouts.app')

@inject('douTopTaskModel','App\Models\DouTopTask')

@section('content')
    <div class="container bg-white py-3">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="border-bottom">
                    <h4>DOU+投放任务</h4>
                    <span>DOU+投放任务列表 <u class="c-blue">{{ $douTopTasks->total() }}</u></span>
                </div>
            </div>
            {{--search--}}
            <div class="col-md-12 my-3">
                <form>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="sr-only" for="tk_status">所有订单状态</label>
                                <select class="form-control" id="tk_status" name="state">
                                    <option value="">所有订单状态</option>
                                    @foreach($douTopTaskModel->stateArr as $k => $v)
                                        <option value="{{ $k }}"
                                                @if($k == request('state')) selected @endif>{{ $v }}</option>
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
                            <th>账号</th>
                            <th>状态</th>
                            <th>金额</th>
                            <th>消耗</th>
                            <th>投放时间</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($douTopTasks as $task)
                            <tr>
                                <td>{{ $task->id }}</td>
                                <td>{{ $task->aweme_author_id }}</td>
                                <td>{{ $task->state_cn }}</td>
                                <td>{{ $task->budget }}</td>
                                <td>{{ $task->cost }}</td>
                                <td>{{ $task->create_time }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div>
                {{ $douTopTasks->links() }}
            </div>
        </div>
    </div>
@endsection
