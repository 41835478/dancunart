<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article', function (Blueprint $table) {
            $table->increments('id')->comment('自增id');
            $table->string('title',80)->comment('文章标题');
            $table->string('keywords',120)->comment('文章关键词');
            $table->string('description')->comment('文章描述');
            $table->integer('article_class')->comment('文章分类');
            $table->text('content')->comment('文章内容');
            $table->integer('view_count')->comment('初始预览')->default(0);
            $table->char('flag',1)->comment('文章状态 0普通状态，1头条')->default(0);
            $table->boolean('status')->comment('1上架展示，0下架')->default(1);
            $table->timestamps();
        });

        Schema::create('article_class', function (Blueprint $table) {
            $table->increments('id')->comment('自增id');
            $table->string('class_name',80)->comment('文章分类');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('article');
        Schema::drop('article_class');
    }
}
