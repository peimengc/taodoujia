<td>
    <div class="thum-box">
        <img src="{{ $account->avatar_url }}"
             alt="头像">
        <div class="ml-1 d-inline-block align-middle">
            <div>
                <a target="_blank"
                   href="{{ $account->share_url }}">{{ $account->nick }}</a>
                <div class="font08 c-dgray">
                    <span>抖音号：{{ $account->username }}</span>
                </div>
            </div>
        </div>
    </div>
</td>
