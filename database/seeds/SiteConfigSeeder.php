<?php

use Illuminate\Database\Seeder;

class SiteConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('site_config')->insert(['role'=>'兑换规则123456']);
        DB::table('site_friendlink')->insert([
            'link_name'=>'百度',
            'link_img'=>'',
            'link_url'=>'http://www.baidu.com',
            'rank'=>'1',
            'status'=>0,
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s'),
        ]);
    }
}
