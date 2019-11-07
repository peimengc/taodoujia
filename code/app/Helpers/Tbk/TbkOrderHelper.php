<?php


namespace App\Helpers\Tbk;


use App\Events\TbkAuthorizeExpired;
use App\Models\TbkOrder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class TbkOrderHelper
{
    protected $topClient;
    protected $time;

    public function __construct()
    {
        require_once base_path('extends/taobaoke/TopSdk.php');

        $topClient = new \TopClient(config('taobaoke.appkey'), config('taobaoke.secret'));
        $topClient->format = 'json';
        $this->topClient = $topClient;
        $this->time = config('taobaoke.time');
    }

    protected function orderDetailsGetRequest($token, array $params = [])
    {
        $req = new \TbkScOrderDetailsGetRequest;
        //查询时间类型，1：按照订单淘客创建时间查询，2:按照订单淘客付款时间查询，3:按照订单淘客结算时间查询
        $req->setQueryType(Arr::get($params, 'query_type', 2));
        //位点，除第一页之外，都需要传递；前端原样返回。
        $req->setPositionIndex(Arr::get($params, 'position_index'));
        //页大小，默认20，1~100
        $req->setPageSize(Arr::get($params, 'page_size', 100));
        //推广者角色类型,2:二方，3:三方，不传，表示所有角色
        if ($member_type = Arr::get($params, 'member_type')) {
            $req->setMemberType($member_type);
        }
        //淘客订单状态，12-付款，13-关闭，14-确认收货，3-结算成功;不传，表示所有状态
        if ($tk_status = Arr::get($params, 'tk_status')) {
            $req->setTkStatus($tk_status);
        }

        //订单查询结束时间，中间时间段日常要求不超过3个小时，但如618、双11、年货节等大促期间预估时间段不可超过20分钟，超过会提示错误
        $req->setEndTime(Arr::get($params, 'end_time'));
        //订单查询开始时间
        $req->setStartTime(Arr::get($params, 'start_time'));

        //跳转类型，当向前或者向后翻页必须提供,-1: 向前翻页,1：向后翻页
        $req->setJumpType(Arr::get($params, 'jump_type', 1));
        //第几页，默认1，1~100
        $req->setPageNo(Arr::get($params, 'page_no', 1));
        //场景订单场景类型，1:常规订单，2:渠道订单，3:会员运营订单，默认为1
        $req->setOrderScene(Arr::get($params, 'order_scene', 1));

        $resp = $this->topClient->execute($req, $token);
        //请求正常
        if ($re = Arr::get($resp, 'data')) {
            return $re;
        }
        //日志记录
        Log::warning('淘宝联盟订单获取失败', ['response' => $resp]);
        //更改数据库状态
        if (Arr::get($resp, 'code') === 27) {
            event(new TbkAuthorizeExpired($token));
        }

        return [];
    }

    public function getNewOrder($token, $params = [])
    {
        //初始化时间
        $params = array_merge([
            'end_time' => date('Y-m-d H:i:s'),
            'start_time' => date('Y-m-d H:i:s', time() - $this->time),
        ], $params);

        $data = [];

        do {

            $resp = $this->orderDetailsGetRequest($token, $params);

            $data = array_merge($data, Arr::get($resp, 'results.publisher_order_dto', []));

            //分页数据
            $params['page_no'] = Arr::get($resp, 'page_no') + 1;
            $params['position_index'] = Arr::get($resp, 'position_index');

        } while (Arr::get($resp, 'has_next'));

        //写入数据库
        TbkOrder::saveByApi($data, $token);
    }

    //获取历史订单
    public function getHistoryOrder($token, $star_date, $end_date = null)
    {
        //时间改为时间戳
        $star_timestamp = strtotime($star_date);
        $end_timestamp = $end_date ? strtotime($end_date) : time();
        //时间差
        $time = in_array(date('m'), ['06', '11', '12']) ? 1200 : 10800;
        //缩小时间差
        $dectime = $time - 10;
        //循环调用
        for ($i = $end_timestamp; $i >= $star_timestamp; $i -= $dectime) {
            $this->getNewOrder($token, [
                'end_time' => date('Y-m-d H:i:s', $i),
                'start_time' => date('Y-m-d H:i:s', $i - $time),
            ]);
        }
    }

}
