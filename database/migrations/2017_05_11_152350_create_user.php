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
            $table->string('user_cash',15)->comment('用户可用余额');
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
    }
}
