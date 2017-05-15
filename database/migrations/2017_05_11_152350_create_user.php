<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('自增id');
            $table->string('account',80)->comment('用户账户');
            $table->string('pwd')->comment('用户密码');
            $table->string('nick',80)->comment('用户名称');
            $table->string('email',50)->comment('用户邮箱');
            $table->string('mob',15)->comment('用户手机');
            $table->string('wechat_openid',32)->comment('绑定微信openid')->default('');
            $table->string('wechat_avatar',80)->comment('微信头像')->default('');
            $table->bigInteger('user_cash')->comment('用户可用余额')->default(0);
            $table->integer('user_exchange_count')->comment('用户充值次数')->default(0);
            $table->integer('user_auction_count')->comment('用户竞拍总数')->default(0);
            $table->integer('user_auction_deal')->comment('用户拍得次数')->default(0);
            $table->integer('user_auction_not_deal')->comment('用户拍得未付款次数')->default(0);
            $table->boolean('status')->comment('0冻结，1正常使用')->default(1);
            $table->timestamps();
        });
        Schema::create('user_attention', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('自增id');
            $table->bigInteger('uid')->comment('用户id');
            $table->integer('aid')->comment('艺术家id/拍卖品')->default(0);
            $table->integer('artwork')->comment('拍品id')->default(0);
            $table->boolean('status')->comment('0艺术品，1艺术家')->default(0);
            $table->timestamps();
        });

        Schema::create('user_log',function(Blueprint $table){
            $table->bigIncrements('id')->comment('自增id');
            $table->bigInteger('uid')->comment('用户id');
            $table->string('action')->comment('艺术家id/拍卖品')->default(0);
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
        Schema::drop('user');
        Schema::drop('user_attention');
        Schema::drop('user_log');
    }
}
