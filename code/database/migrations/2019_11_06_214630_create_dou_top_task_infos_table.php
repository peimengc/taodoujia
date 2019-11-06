<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDouTopTaskInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dou_top_task_infos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('task_id')->index()->comment('任务id');
            $table->string('cost')->comment('消耗增量');
            $table->string('state')->index()->nullable()->comment('状态');
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
        Schema::dropIfExists('dou_top_task_infos');
    }
}
