<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbkOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbk_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('trade_id')->unique()->comment('订单编号');

            $table->tinyInteger('tk_status')->index()->nullable()->comment('订单状态');

            $table->unsignedBigInteger('account_id')->nullable()->index()->comment('账号ID');
            $table->unsignedBigInteger('authorize_id')->index()->comment('授权ID');

            $table->bigInteger('adzone_id')->index()->comment('广告位ID');

            $table->string('alipay_total_price')->nullable()->comment('付款金额');
            $table->string('pub_share_pre_fee')->nullable()->comment('付款预估收入');
            $table->string('pay_price')->nullable()->comment('确认收货金额');
            $table->string('pub_share_fee')->nullable()->comment('结算预估收入');
            $table->string('total_commission_fee')->nullable()->comment('佣金金额');

            $table->dateTime('click_time')->index()->nullable()->comment('点击时间');
            $table->dateTime('tk_earning_time')->index()->nullable()->comment('佣金支付时间');
            $table->dateTime('tk_create_time')->index()->nullable()->comment('订单创建的时间');
            $table->dateTime('tb_paid_time')->index()->nullable()->comment('付款时间');
            $table->dateTime('tk_paid_time')->index()->nullable()->comment('付款时间');

            $table->unsignedBigInteger('item_id')->index()->comment('商品ID');
            $table->string('item_category_name')->index()->nullable()->comment('商品类目');
            $table->string('item_img')->nullable()->comment('商品图片');
            $table->tinyInteger('item_num')->nullable()->comment('商品数量');
            $table->string('item_price')->nullable()->comment('商品单价');
            $table->string('item_link')->nullable()->comment('商品链接');
            $table->string('item_title')->index()->nullable()->comment('商品标题');

            $table->tinyInteger('tk_order_role')->nullable()->comment('佣金归属者');
            $table->string('pub_share_rate')->nullable()->comment('总佣金占%');
            $table->tinyInteger('refund_tag')->nullable()->comment('是否维权订单');
            $table->string('subsidy_rate')->nullable()->comment('平台补贴%');
            $table->string('tk_total_rate')->nullable()->comment('实际收益%');
            $table->string('seller_nick')->nullable()->comment('掌柜旺旺');
            $table->bigInteger('pub_id')->nullable()->comment('推广者的会员id');
            $table->string('alimama_rate')->nullable()->comment('服务费%');
            $table->string('subsidy_type')->nullable()->comment('平台出资方');

            $table->string('site_name')->nullable()->comment('媒体管理下的对应ID的自定义名称');
            $table->string('subsidy_fee')->nullable()->comment('补贴金额');
            $table->string('alimama_share_fee')->nullable()->comment('技术服务费');
            $table->string('trade_parent_id')->nullable()->comment('淘宝后台订单编号');
            $table->string('order_type')->nullable()->comment('订单所属平台类型');
            $table->string('flow_source')->nullable()->comment('产品类型');
            $table->string('terminal_type')->nullable()->comment('成交平台');
            $table->string('adzone_name')->index()->nullable()->comment('推广位名称');
            $table->string('total_commission_rate')->nullable()->comment('佣金%');
            $table->bigInteger('site_id')->nullable()->comment('媒体管理下的ID');
            $table->string('seller_shop_title')->nullable()->comment('店铺名称');
            $table->string('income_rate')->nullable()->comment('订单结算的佣金比率+平台的补贴比率');
            $table->bigInteger('special_id')->nullable()->comment('会员运营id');
            $table->bigInteger('relation_id')->nullable()->comment('渠道关系id');
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
        Schema::dropIfExists('tbk_orders');
    }
}
