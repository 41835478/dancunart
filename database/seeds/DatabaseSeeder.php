<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(ArtistSeeder::class);
        $this->call(ArtWorkSeeder::class);
        $this->call(SiteConfigSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(OrderSeeder::class);
        $this->call(SinglePage::class);
    }
}
