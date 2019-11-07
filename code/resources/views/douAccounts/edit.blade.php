@extends('layouts.app')

@section('content')
    <div class="container bg-white py-3">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="border-bottom">
                    <h4>编辑带货账号</h4>
                    <span>编辑带货账号</span>
                </div>
            </div>
            <div class="col-md-8">
                <form class="mt-4" method="post" action="{{ route('douAccounts.update',$douAccount) }}">
                    @csrf
                    @method('PUT')
                    @include('douAccounts.field')
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection
