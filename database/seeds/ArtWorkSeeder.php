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
            'img_thumb'=>'uploads/2017/06_02/thumb-17-07-06-59312aba27bf9.jpg',
            'img'=>'uploads/2017/06_02/17-07-06-59312aba27bf9.jpg',
            'video'=>'//vjs.zencdn.net/v/oceans.mp4',
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
            'artwork_class'=>'3,4',
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s'),
        ]);
        DB::table('art_artwork')->insert([
            'name'=>'虾',
            'img_thumb'=>'uploads/2017/06_02/thumb-17-25-01-59312eedf1c86.jpg',
            'img'=>'uploads/2017/06_02/17-25-01-59312eedf1c86.jpg',
            'video'=>'//vo.fod4.com/v/25c17d6eb2/v600.mp4',
            'artist'=>'1',
            'desc'=>'齐白石 虾',
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
            'artwork_class'=>'3,4',
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s'),
        ]);
    }
}