@extends('layouts.app')

@section('content')
    <div class="container py-3 home">
        <div class="row justify-content-center">
            <div class="col-md-12 mb-3">
                <div class="py-2 bg-white">
                    <a href="?date=1"
                       class="btn @if(request('date',1)==1) btn-info @else btn-secondary @endif mx-2">今日</a>
                    <a href="?date=2"
                       class="btn @if(request('date')==2) btn-info @else btn-secondary @endif mx-2">昨日</a>
                    <a href="?date=3"
                       class="btn @if(request('date')==3) btn-info @else btn-secondary @endif mx-2">七日</a>
                    <a href="?date=4"
                       class="btn @if(request('date')==4) btn-info @else btn-secondary @endif mx-2">本月</a>
                </div>
            </div>
            @foreach($homeMinBoxData as $data)
            <div class="col-md-3 min-box">
                <div>
                    <h2>{{ $data['value'] }}</h2>
                    <span class="c-dgray font10">{{ $data['name'] }}</span>
                </div>
            </div>
                @endforeach
        </div>
    </div>
@endsection
@push('css')
    <style>
        .home .min-box > div {
            background-color: #fff;
            text-align: center;
            padding: 1rem 0;
        }
    </style>
@endpush
