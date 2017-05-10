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
        DB::table('art_artwork_class')->insert(['class_name'=>'字画']);
        DB::table('art_artwork_class')->insert(['class_name'=>'书法']);
    }
}