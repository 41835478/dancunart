<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //交易总表
        Schema::create('order',function(Blueprint $table){
            $table->bigIncrements('id')->comment('自增id');
            $table->string('order_id',20)->comment('订单号');
            $table->bigInteger('artwork_id')->comment('拍品id')->default(0);
            $table->bigInteger('uid')->comment('用户id');
            $table->Integer('pay_money')->comment('支付金额');
            $table->string('pay_way',10)->comment('支付方式');
            $table->boolean('flag')->comment('0：充值，1:付尾款')->default(0);
            $table->boolean('status')->comment('0：未支付，1:已支付')->default(0);
            $table->char('send_flag')->comment('0：未发送，1:已发送，2：已签收')->default(0);
            $table->bigInteger('address_id')->comment('地址编号')->default(0);
            $table->string('express_no',20)->comment('快递单号')->default('');
            $table->timestamps();
        });

        //竞拍订单（日志）
        Schema::create('order_auction',function(Blueprint $table){
            $table->bigIncrements('id')->comment('自增id');
            $table->bigInteger('uid')->comment('用户id');
            $table->bigInteger('artwork_id')->comment('拍品id');
            $table->Integer('old_price')->comment('拍之前价格');
            $table->Integer('price_increase')->comment('本次加价');
            $table->timestamps();
        });

        //提现订单（日志）
        Schema::create('order_withdraw',function(Blueprint $table){
            $table->bigIncrements('id')->comment('自增id');
            $table->bigInteger('uid')->comment('用户id');
            $table->Integer('old_cash')->comment('提现前身上钱');
            $table->Integer('withdraw_price')->comment('本次提现金额');
            $table->char('status',1)->comment('0：未处理，1:已处理,2:驳回')->default(0);
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
        Schema::drop('order');
        Schema::drop('order_auction');
        Schema::drop('order_withdraw');
    }
}
