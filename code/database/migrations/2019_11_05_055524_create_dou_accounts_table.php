<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDouAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dou_accounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user_id')->unique()->comment('平台 账号id');
            $table->string('phone')->unique()->nullable()->comment('手机号');
            $table->text('share_url')->comment('主页链接');
            $table->string('avatar_url')->nullable()->comment('头像链接');
            $table->string('nick')->nullable()->index()->comment('昵称');
            $table->string('username')->nullable()->index()->comment('账号');
            $table->string('adzone_id')->nullable()->unique()->comment('推广位id');
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
        Schema::dropIfExists('dou_accounts');
    }
}
