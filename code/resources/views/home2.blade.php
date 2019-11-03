@extends('layouts.app')

@section('content')
    <div class="container bg-white py-3">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="border-bottom">
                    <h4>新增授权</h4>
                    <span>联盟订单 / 新增授权</span>
                </div>
            </div>
            <div class="col-md-8">
                <form class="mt-5">
                    <div class="form-group">
                        <label for="authorize">Authorize JSON：</label>
                        <textarea class="form-control" name="authorize" id="authorize" cols="30" rows="5"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection
