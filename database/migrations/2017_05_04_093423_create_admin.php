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
            $table->string('name')->comment('用户账号');
            $table->string('nick')->comment('用户昵称');
            $table->string('pwd')->comment('用户密码');
            $table->string('salt')->comment('盐');
            $table->string('last_login_ip')->comment('ip');
            $table->string('status')->comment('正常使用');
            $table->string('role_id')->comment('角色id');
            $table->rememberToken();
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
