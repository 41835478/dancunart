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

        Schema::create('user_accountset',function(Blueprint $table){
            $table->bigIncrements('id')->comment('自增id');
            $table->bigInteger('uid')->comment('用户id');
            $table->boolean('flag')->comment('0:支付宝，1：银行卡');
            $table->string('alipay_account',20)->comment('账号');
            $table->string('alipay_realname',10)->comment('真实姓名');
            $table->string('bank_payee',10)->comment('开户人');
            $table->string('bank_name',20)->comment('开户银行');
            $table->string('accountnumber',20)->comment('卡号');
            $table->string('province',10)->comment('省份');
            $table->string('city',10)->comment('城市');
            $table->string('branchname',10)->comment('支行名称');
            $table->boolean('status')->comment('是否默认')->default(0);
            $table->timestamps();
        });

        Schema::create('user_address',function(Blueprint $table){
            $table->bigIncrements('id')->comment('自增id');
            $table->bigInteger('uid')->comment('用户id');
            $table->string('province',10)->comment('省份');
            $table->string('city',10)->comment('城市');
            $table->string('area',10)->comment('区域');
            $table->string('detail',10)->comment('详细');
            $table->string('consignor',10)->comment('收货人');
            $table->string('mob',15)->comment('电话');
            $table->string('remark')->comment('备注');
            $table->boolean('status')->comment('是否默认')->default(0);
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
        Schema::drop('user_accountset');
        Schema::drop('user_address');
    }
}
