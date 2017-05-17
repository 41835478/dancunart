<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiteConfig extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_config', function (Blueprint $table) {
            $table->increments('id')->comment('id');
            $table->string('role')->comment('竞拍规则');
        });

        Schema::create('site_friendlink', function (Blueprint $table) {
            $table->increments('id')->comment('id');
            $table->string('link_name')->comment('友链名称');
            $table->string('link_img')->comment('友链图片');
            $table->string('link_url')->comment('友链网址');
            $table->string('rank')->comment('友链权重');
            $table->boolean('status')->comment('1正常，0冻结')->default(1);
            $table->timestamps();
        });

        Schema::create('site_CSR', function (Blueprint $table) {
            $table->increments('id')->comment('id');
            $table->string('name')->comment('客服名称');
            $table->string('qq')->comment('客服qq');
            $table->string('mob')->comment('客服电话');
            $table->string('rank')->comment('客服权重');
            $table->boolean('status')->comment('1正常，0冻结')->default(1);
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
        Schema::drop('site_config');
        Schema::drop('site_friendlink');
        Schema::drop('site_CSR');
    }
}
