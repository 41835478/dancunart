<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdmin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin', function (Blueprint $table) {
            $table->increments('id')->comment('自增id');
            $table->string('name',80)->comment('用户账号');
            $table->string('nick',80)->comment('用户昵称');
            $table->string('pwd')->comment('用户密码');
            $table->mediumInteger('login_count')->comment('登录次数')->default(0);
            $table->string('last_login_ip',15)->comment('ip')->default('127.0.0.1');
            $table->boolean('status')->comment('正常使用')->default(1);
            $table->integer('role_id')->comment('角色id');
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
        Schema::drop('admin');
    }
}
