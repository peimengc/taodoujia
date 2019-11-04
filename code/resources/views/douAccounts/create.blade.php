@extends('layouts.app')

@section('content')
    <div class="container bg-white py-3">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="border-bottom">
                    <h4>新增带货账号</h4>
                    <span>新增带货账号</span>
                </div>
            </div>
            <div class="col-md-8">
                <form class="mt-4" method="post" action="{{ route('douAccounts.store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="url">主页链接：</label>
                        <input type="text" id="url" class="form-control @error('url') is-invalid @enderror" name="url">
                        @error('url')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="phone">手机号：</label>
                        <input type="text" id="phone" class="form-control  @error('phone') is-invalid @enderror" name="phone">
                        @error('phone')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="adzone_id">推广位ID：</label>
                        <input type="text" id="adzone_id" class="form-control @error('adzone_id') is-invalid @enderror" name="adzone_id">
                        @error('adzone_id')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection
