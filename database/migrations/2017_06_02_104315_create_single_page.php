<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSinglePage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('single_page',function(Blueprint $table){
            $table->increments('id')->comment('自增id');
            $table->string('page_name')->comment('名称');
            $table->Integer('parent_id')->comment('父级id')->default(0);
            $table->text('content')->comment('内容');
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
        Schema::drop('single_page');
    }
}
