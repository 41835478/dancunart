<?php

use Illuminate\Database\Seeder;

class ArtWorkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('art_artwork_class')->insert(['class_name'=>'中国绘画']);
        DB::table('art_artwork_class')->insert(['class_name'=>'书法篆刻']);
        DB::table('art_artwork_class')->insert(['class_name'=>'字画','parent_id'=>1]);
        DB::table('art_artwork_class')->insert(['class_name'=>'书法','parent_id'=>1]);
        DB::table('art_artwork_class')->insert(['class_name'=>'楷书','parent_id'=>2]);
        DB::table('art_artwork_class')->insert(['class_name'=>'行书','parent_id'=>2]);
        DB::table('art_artwork_class')->insert(['class_name'=>'隶书','parent_id'=>2]);

        DB::table('art_artwork')->insert([
            'name'=>'象山晚春',
            'img_thumb'=>'',
            'img'=>'',
            'video'=>'',
            'artist'=>'1',
            'desc'=>'桂林山水甲天下',
            'content'=>'<p>桂林<br /><b>柳州</b></p>',
            'start_price'=>'100000',
            'each_increase'=>'10000',
            'delay_seconds'=>5,
            'reserve_price'=>'20000',
            'margin'=>'15000',
            'buy_num'=>0,
            'now_price'=>0,
            'start_time'=>date('Y-m-d H:i:s'),
            'end_time'=>date('Y-m-d H:i:s'),
            'artwork_class'=>'3,4'
        ]);
    }
}