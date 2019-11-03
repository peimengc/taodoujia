<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbkAuthorizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbk_authorizes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('active')->default(true)->comment('是否启用');
            $table->string('tb_user_id')->nullable()->unique()->comment('授权账号id');
            $table->string('tb_user_nick')->nullable()->index()->comment('授权账号名称');
            $table->string('access_token')->nullable();
            $table->timestamp('expire_time')->nullable()->comment('失效时间');
            $table->json('auth_json')->nullable()->comment('auth_json');
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
        Schema::dropIfExists('tbk_authorizes');
    }
}
