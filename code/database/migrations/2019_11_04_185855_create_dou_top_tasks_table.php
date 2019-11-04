<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDouTopTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dou_top_tasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('task_id')->unique()->comment('热门消耗唯一ID');
            $table->string('state')->index()->nullable()->comment('状态');
            $table->string('product_id')->index()->nullable()->comment('商品id');
            $table->string('aweme_id')->index()->nullable()->comment('视频id,用于获取商品id');
            $table->string('aweme_author_id')->index()->nullable()->comment('视频作者id');
            $table->string('cost')->nullable()->comment('本条消耗');
            $table->timestamp('create_time')->nullable()->comment('创建时间');
            $table->string('budget')->nullable()->comment('投放金额');
            $table->string('duration')->nullable()->comment('投放时长，小时');
            $table->string('delivery_start_time')->nullable()->comment('开始投放时间');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dou_top_tasks');
    }
}
