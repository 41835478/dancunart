<?php

use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('article_class')->insert(['class_name'=>'公司新闻']);
        DB::table('article_class')->insert(['class_name'=>'行业资讯']);

        DB::table('article')->insert([
            'title'=>'第十八届武汉国际友好城市作品展在琴台美术馆开幕',
            'keywords'=>'国际,第十八届',
            'description'=>'汉国际友好城市作品展在琴台汉国际友好城市作品展在琴台汉国际友好城市作品展在琴台汉国际友好城市作品展在琴台',
            'article_class'=>'1,2',
            'content'=>'带html<p>asdfsdf</p><a href="#">fff</a>',
            'view_count'=>110,
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s'),
        ]);

    }
}
