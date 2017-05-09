<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArtist extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artist', function (Blueprint $table) {
            $table->increments('id')->comment('自增id');
            $table->string('name',80)->comment('艺术家名称');
            $table->string('nick',80)->comment('艺术家昵称')->defalut('');
            $table->string('avatar',100)->comment('艺术家图片');
            $table->string('avatar_thumb',100)->comment('艺术家图片缩略图');
            $table->text('desc')->comment('艺术家简介');
            $table->text('blog')->comment('艺术家自行编辑博客');
            $table->mediumInteger('artwork_count')->comment('艺术品数量')->default(0);
            $table->boolean('status')->comment('1上架展示，0下架')->default(1);
            $table->string('art_class')->comment('艺术分类');
            $table->timestamps();
        });

        Schema::create('artist_class', function (Blueprint $table) {
            $table->increments('id')->comment('自增id');
            $table->string('class_name',80)->comment('艺术分类名称');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('artist');
        Schema::drop('artist_class');
    }
}
