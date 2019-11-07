<div class="form-group">
    <label for="url">主页链接：</label>
    <input type="text" id="url" class="form-control @error('url') is-invalid @enderror" name="url" value="{{ old('url',$douAccount->share_url) }}">
    @error('url')
    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
    @enderror
</div>
<div class="form-group">
    <label for="phone">手机号：</label>
    <input type="text" id="phone" class="form-control  @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone',$douAccount->phone) }}">
    @error('phone')
    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
    @enderror
</div>
<div class="form-group">
    <label for="adzone_id">推广位ID：</label>
    <input type="text" id="adzone_id" class="form-control @error('adzone_id') is-invalid @enderror" name="adzone_id" value="{{ old('adzone_id',$douAccount->adzone_id) }}">
    @error('adzone_id')
    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
    @enderror
</div>