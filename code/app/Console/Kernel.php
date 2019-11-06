<?php

namespace App\Console;

use App\Helpers\Dou\DouTopTaskGetHelper;
use App\Helpers\Dou\DouTopTaskInfoGetHelper;
use App\Helpers\Dou\DouTopTaskProductIdGetHelper;
use App\Helpers\Tbk\TbkOrderHelper;
use App\Models\DouTopTask;
use App\Models\TbkAuthorize;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //获取淘宝联盟新订单
        $schedule->call(function () {
            dispatch(function () {
                $orderHelper = new TbkOrderHelper();
                $tbkAuth = TbkAuthorize::query()->first();
                if ($tbkAuth){
                    $orderHelper->getNewOrder($tbkAuth->access_token);
                }
            });
        })->everyTenMinutes();

        //获取抖音新投放任务
        $schedule->call(function () {
            dispatch(function () {
                $taskHelper = new DouTopTaskGetHelper();
                $endTime = DouTopTask::getNewTaskCreateTime();
                $taskHelper->getNewTask($endTime);
            });
        })->everyThirtyMinutes();

        //获取抖音新投放任务商品ID
        $schedule->call(function () {
            dispatch(function () {
                $tasks = DouTopTask::getAwemeIdsByProductIdIsNull();
                $helper = new DouTopTaskProductIdGetHelper($tasks);
                $helper->execute();
            });
        })->everyThirtyMinutes();

        //获取抖音新投放任务消耗详情
        $schedule->call(function () {
            dispatch(function () {
                $tasks = DouTopTask::getAllByCostIsNull();
                $helper = new DouTopTaskInfoGetHelper($tasks);
                $helper->execute();
            });
        })->cron('*/55 * * * *');

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
