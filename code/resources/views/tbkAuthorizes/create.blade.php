@extends('layouts.app')

@section('content')
    <div class="container bg-white py-3">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="border-bottom">
                    <h4>新增联盟授权</h4>
                    <span>新增联盟授权</span>
                </div>
            </div>
            <div class="col-md-8">
                <form class="mt-4" action="{{ route('tbkAuthorizes.store') }}" method="post">
                    <div class="form-group">
                        <label for="auth_json">Authorize JSON：</label>
                        <textarea class="form-control" name="auth_json" id="auth_json" cols="30" rows="5"></textarea>
                    </div>
                    @csrf
                    <button type="submit" class="btn btn-primary">提交</button>
                </form>
            </div>
        </div>
    </div>
@endsection
