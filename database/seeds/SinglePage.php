<?php

use Illuminate\Database\Seeder;

class SinglePage extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('single_page')->insert([
            'page_name' => '拍卖学堂',
            'content' =>'223<b>2223</b><br/>',
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s'),
        ]);
        DB::table('single_page')->insert([
            'page_name' => '拍卖支付方式',
            'content' =>'223<b>2223</b><br/>',
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s'),
        ]);
        DB::table('single_page')->insert([
            'page_name' => '配送方式',
            'content' =>'223<b>2223</b><br/>',
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s'),
        ]);
        DB::table('single_page')->insert([
            'page_name' => '如何注册',
            'content' =>'223<b>如何注册</b><br/>',
            'parent_id'=>1,
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s'),
        ]);
        DB::table('single_page')->insert([
            'page_name' => '如何提现',
            'content' =>'223<b>如何提现</b><br/>',
            'parent_id'=>1,
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s'),
        ]);
    }
}
