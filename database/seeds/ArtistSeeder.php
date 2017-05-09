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
        DB::table('artist_class')->insert(['class_name'=>'山水']);
        DB::table('artist_class')->insert(['class_name'=>'国画']);
        DB::table('artist_class')->insert(['class_name'=>'人物']);
        DB::table('artist_class')->insert(['class_name'=>'水墨']);
    }
}
