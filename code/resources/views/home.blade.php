@extends('layouts.app')

@section('content')
    <div class="container py-3 home">
        <div class="row justify-content-center">
            <div class="col-md-3 min-box">
                <div>
                    <h1>1</h1>
                    <span class="c-dgray font10">111</span>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('css')
    <style>
        .home .min-box>div{
            background-color: #fff;
            text-align: center;
            padding: 1rem 0;
        }
    </style>
@endpush
