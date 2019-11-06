<?php


namespace App\Helpers\Dou;


use App\Models\DouTopTask;
use GuzzleHttp\Client;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class DouTopTaskGetHelper
{
    protected $url;
    protected $client;
    protected $cookie;

    public function __construct()
    {
        $this->url = config('douyin.get_task.url');
        $this->cookie = config('douyin.get_task.cookie');
        $this->client = new Client();
    }

    protected function getTask($endTime = null)
    {
        //初始化数据
        $data = [];
        //默认结束时间
        $endTime = $endTime ?? date('Y-m-d 00:00:00');
        //默认页
        $page = 1;
        //获取数据
        do {
            $contents = $this->client->request('GET', $this->url . $page, [
                'verify' => false,
                'headers' => [
                    'Cookie' => $this->cookie
                ]
            ])->getBody()->getContents();

            $resp = json_decode($contents, 1);

            if (Arr::get($resp, 'status_code') !== 0) {
                Log::warning('抖音投放任务列表获取失败', $resp);
                return;
            }
            $list = Arr::get($resp, 'ad_list', []);
            //分页数据合并
            $data = array_merge($data, $list);
            //获取最小时间
            $minCreateTime = collect($list)->map(function($item){
                return [
                    'create_time' => strtotime(Arr::get($item,'create_time'))
                ];
            })->min('create_time');
            //下一页
            $page++;

        } while (Arr::get($resp, 'has_more') && $minCreateTime && ($minCreateTime > strtotime($endTime)));

        //保存
        DouTopTask::saveByApi($data);
    }

    public function getNewTask(string $endTime = null)
    {
        $this->getTask($endTime);
    }
}
