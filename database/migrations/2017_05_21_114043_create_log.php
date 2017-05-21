<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //用户保证金金额变动log
        Schema::create('user_cash_log',function(Blueprint $table){
            $table->bigIncrements('id')->comment('自增id');
            $table->bigInteger('uid')->comment('用户id');
            $table->Integer('pay_money')->comment('支付金额');
            $table->bigInteger('artwork_id')->comment('拍品id')->default(0);
            $table->char('flag',1)->comment('1:线上充值，2：线下充值，3：参拍冻结，4：参拍解冻，4：提现冻结，5：提现扣除，6：提现失败解冻')->default(0);
//            $table->boolean('status')->comment('状态,0失败，1成功')->default(0);
            $table->timestamps();
        });

        //用户人民币交易流水log
        Schema::create('user_flow_log',function(Blueprint $table){
            $table->bigIncrements('id')->comment('自增id');
            $table->bigInteger('uid')->comment('用户id');
            $table->Integer('pay_money')->comment('支付金额');
            $table->string('pay_way',10)->comment('支付方式');

//            $table->boolean('status')->comment('状态,0失败，1成功')->default(0);
            $table->timestamps();
        });

        Schema::create('user_log',function(Blueprint $table){
            $table->bigIncrements('id')->comment('自增id');
            $table->bigInteger('uid')->comment('用户id');
            $table->string('action')->comment('操作行为')->default(0);
            $table->integer('admin_id')->comment('操作者');
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
        Schema::drop('user_log');
        Schema::drop('user_cash_log');
        Schema::drop('user_flow_log');
    }
}
