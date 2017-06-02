<?php

use Illuminate\Database\Seeder;

class ArtistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('art_artist_class')->insert(['class_name'=>'山水']);
        DB::table('art_artist_class')->insert(['class_name'=>'国画']);
        DB::table('art_artist_class')->insert(['class_name'=>'人物']);
        DB::table('art_artist_class')->insert(['class_name'=>'水墨']);

        DB::table('art_artist')->insert([
            'name'=>'齐白石',
            'nick'=>'齐齐',
            'desc'=>'描述',
            'artwork_count'=>2,
            'blog'=>'带html<p>asdfsdf</p><a href="#">fff</a>',
            'art_class'=>'1,3'
        ]);
    }
}
