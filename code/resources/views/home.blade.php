@extends('layouts.app')

@section('content')
    <div class="container bg-white py-3">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="border-bottom">
                    <div class="float-right">
                        <button type="submit" class="btn btn-primary">提交</button>
                    </div>
                    <h4>所有订单</h4>
                    <span>联盟订单 / 所有订单</span>
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
                            <th>佣金</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>123</td>
                            <td>
                                <div class="thum-box">
                                    <img src="https://p9-dy.byteimg.com/aweme/720x720/2deb40007833c5b3a6615.jpeg"
                                         alt="">
                                    <div class="ml-1 d-inline-block align-middle">
                                        <div>
                                            <a class="font10" href="">开大宝</a>
                                            <div class="font08 c-dgray">11111</div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>11111111111</td>
                            <td>11111111111</td>
                            <td>11111111111</td>
                            <td></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
