<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArtwork extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('art_artwork', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('自增id');
            $table->string('name',80)->comment('拍品名称');
            $table->string('img_thumb',100)->comment('拍品缩略图片');
            $table->string('img',100)->comment('拍品图片');
            $table->string('video',100)->comment('拍品视频地址');
            $table->string('artist')->comment('相关艺术家');
            $table->text('desc')->comment('艺术品描述');
            $table->text('content')->comment('艺术品详述');
            $table->mediumInteger('start_price')->comment('起拍价');
            $table->mediumInteger('each_increase')->comment('加价幅度');
            $table->char('delay_seconds',5)->comment('延时周期,单位分钟');
            $table->mediumInteger('reserve_price')->comment('保留价');
            $table->mediumInteger('margin')->comment('保证金');
            $table->mediumInteger('buy_num')->comment('出价次数');
            $table->dateTime('start_time')->comment('开始时间');
            $table->dateTime('end_time')->comment('结束时间');
            $table->string('art_class')->comment('艺术品分类');
            $table->boolean('status')->comment('1上架展示，0下架')->default(1);
            $table->timestamps();
        });

        Schema::create('art_artwork_class', function (Blueprint $table) {
            $table->increments('id')->comment('自增id');
            $table->string('class_name',80)->comment('艺术品分类名称');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('art_artwork');
        Schema::drop('art_artwork_class');
    }
}
