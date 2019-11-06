<?php

namespace App\Helpers\Dou;

use App\Models\DouTopTask;
use GuzzleHttp\Client;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class DouTopTaskProductIdGetHelper
{

    protected $url = 'https://api-hl.amemv.com/aweme/v2/shop/promotion/?version_code=8.1.0&pass-region=1&pass-route=1&js_sdk_version=1.17.4.3&app_name=aweme&vid=53601C0B-AA28-4270-BE99-CC45410FE646&app_version=8.1.0&device_id=66493333807&channel=App%20Store&mcc_mnc=46002&aid=1128&screen_width=1125&openudid=e6012c91eff5a4fd33c0b617979c4e498eab218f&os_api=18&ac=WIFI&os_version=13.0&device_platform=iphone&build_number=81017&device_type=iPhone10,3&iid=87445999129&idfa=51CA298D-F332-4976-8668-DBE8A28A699B&sec_author_id=MS4wLjABAAAA8h9X7OQ0800M42pkNNO6yYq4JwC0eYUSls7Y8hazV5M&author_id=14570499127&aweme_id=';
    protected $douTopTasks;

    public function __construct(Collection $douTopTasks)
    {
        $this->douTopTasks = $douTopTasks;
    }

    public function execute()
    {
        $client = new Client();

        $this->douTopTasks->each(function (DouTopTask $douTopTask) use ($client) {

            $resp = $client->request('GET', $this->url . $douTopTask->aweme_id, [
                'verify' => false
            ])->getBody()->getContents();

            $resp = json_decode($resp, 1);

            if (!$this->responseValidate($resp)){
                return ;
            }

            DouTopTask::addProduct($douTopTask->aweme_id, $resp);
        });

    }

    protected function responseValidate($resp)
    {
        if (Arr::get($resp, 'status_code') !== 0) {
            Log::warning('抖音投放任务商品ID获取失败', $resp);
            return false;
        }
        return true;
    }
}
