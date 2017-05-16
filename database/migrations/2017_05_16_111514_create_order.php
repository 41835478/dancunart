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
        //充值订单
        Schema::create('order_recharge',function(Blueprint $table){
            $table->bigIncrements('id')->comment('自增id');
            $table->string('order_id',20)->comment('订单号');
            $table->bigInteger('uid')->comment('用户id');
            $table->boolean('status')->comment('0：未支付，1:已支付')->default(0);
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
        Schema::drop('order_recharge');
        Schema::drop('order_auction');
        Schema::drop('order_withdraw');
    }
}
