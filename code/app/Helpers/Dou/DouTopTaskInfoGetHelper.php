<?php


namespace App\Helpers\Dou;


use App\Models\DouTopTask;
use App\Models\DouTopTaskInfo;
use GuzzleHttp\Client;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class DouTopTaskInfoGetHelper
{
    protected $url = 'https://aweme-hl.snssdk.com/aweme/v2/douplus/ad/?version_code=8.1.0&pass-region=1&pass-route=1&js_sdk_version=1.17.4.3&app_name=aweme&vid=53601C0B-AA28-4270-BE99-CC45410FE646&app_version=8.1.0&device_id=66493333807&channel=App%20Store&mcc_mnc=46002&aid=1128&screen_width=1125&openudid=e6012c91eff5a4fd33c0b617979c4e498eab218f&os_api=18&ac=WIFI&os_version=13.0&device_platform=iphone&build_number=81017&device_type=iPhone10,3&iid=87445999129&idfa=51CA298D-F332-4976-8668-DBE8A28A699B&request_tag_from=h5&task_id=';
    protected $cookie;
    protected $doupluses;
    protected $douTopTaskInfoAttrs = [];
    protected $date;

    public function __construct(Collection $doupluses)
    {
        $this->doupluses = $doupluses;
        $this->cookie = config('douyin.get_task.cookie');
        $this->date = now()->toDateTimeString();
    }

    public function execute()
    {
        $client = new Client();
        $this->doupluses->each(function (DouTopTask $douTopTask) use ($client) {
            $resp = $client->request('GET', $this->url . $douTopTask->task_id, [
                'verify' => false,
                'headers' => [
                    'Cookie' => $this->cookie
                ]
            ])->getBody()->getContents();

            $resp = json_decode($resp, 1);

            if (!$this->responseValidate($resp, $douTopTask)) {
                return;
            }

            $cost = Arr::get($resp, 'ad_stat.cost', 0) - $douTopTask->cost;

            if ($cost > 0) {
                $this->douTopTaskInfoAttrs[] = [
                    'task_id' => $douTopTask->id,
                    'state' => Arr::get($resp, 'state'),
                    'cost' => Arr::get($resp, 'ad_stat.cost') - $douTopTask->cost,
                    'created_at' => $this->date,
                    'updated_at' => $this->date,
                ];
            }

            $douTopTask->addCost($resp);
        });

        DouTopTaskInfo::query()->insert($this->douTopTaskInfoAttrs);

        return $this;
    }

    protected function responseValidate($resp, DouTopTask $douTopTask)
    {
        if (Arr::get($resp, 'status_code') !== 0) {
            Log::warning('抖音投放任务消耗详情获取失败', ['douTopTask' => $douTopTask->toArray(), 'resp' => $resp]);
            return false;
        }
        return true;
    }
}
