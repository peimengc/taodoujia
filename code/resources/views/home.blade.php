@extends('layouts.app')

@section('content')
    <div class="container bg-white py-3">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="border-bottom">
                    <div class="float-right">
                        <button type="submit" class="btn btn-primary">提交</button>
                    </div>
                    <h4>联盟订单</h4>
                    <span>111</span>
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
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>选中</th>
                            <th>编号</th>
                            <th>商品</th>
                            <th>状态</th>
                            <th>价格</th>
                            <th>佣金</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" value="">
                                    </label>
                                </div>
                            </td>
                            <td>11111111111</td>
                            <td>11111111111</td>
                            <td>11111111111</td>
                            <td>11111111111</td>
                            <td>11111111111</td>
                            <td>11111111111</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
