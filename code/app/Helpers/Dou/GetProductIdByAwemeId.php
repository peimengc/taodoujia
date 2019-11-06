<?php


namespace App\Foundations\Douplus;


use App\Foundations\Traits\HttpRequest;
use App\Models\Douplus;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class GetProductIdByAwemeId
{
    use HttpRequest;

    protected $url = 'https://api-hl.amemv.com/aweme/v2/shop/promotion/?version_code=8.1.0&pass-region=1&pass-route=1&js_sdk_version=1.17.4.3&app_name=aweme&vid=53601C0B-AA28-4270-BE99-CC45410FE646&app_version=8.1.0&device_id=66493333807&channel=App%20Store&mcc_mnc=46002&aid=1128&screen_width=1125&openudid=e6012c91eff5a4fd33c0b617979c4e498eab218f&os_api=18&ac=WIFI&os_version=13.0&device_platform=iphone&build_number=81017&device_type=iPhone10,3&iid=87445999129&idfa=51CA298D-F332-4976-8668-DBE8A28A699B&sec_author_id=MS4wLjABAAAA8h9X7OQ0800M42pkNNO6yYq4JwC0eYUSls7Y8hazV5M&author_id=14570499127&aweme_id=';
    protected $aweme_id;

    public function __construct($aweme_id)
    {
        $this->aweme_id = $aweme_id;
    }

    public function execute()
    {
        $resp = $this->request($this->url . $this->aweme_id, 'GET', [
            'verify' => false
        ])->toArray();

        $this->responseValidate($resp);

        Douplus::addProduct($this->aweme_id, $resp);

        return $this;
    }

    protected function responseValidate($resp)
    {
        if (Arr::get($resp, 'status_code') !== 0) {
            Log::warning('dou+,商品ID获取失败', $resp);
        }
    }
}