<?php

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admin')->insert([
            'name' => 'a',
            'nick' => '超级管理员',
            'pwd'  => 'eyJpdiI6IkNRdm9zanVuYURDRkxWVGRUUE5LRlE9PSIsInZhbHVlIjoiS3Q5WnlZZDhFQ0Z6a2RydHVyQ1lRdz09IiwibWFjIjoiMDY1Y2YwZGY5NTU2MjNiYWUyMzA3MDMyZTE0ZmI0YzA4YmU0NmI2NTU1YWM4ODE1ZmE4YzlhNzgwMzkxMzdkNyJ9',
            'last_login_ip' => '127.0.0.1',
            'role_id' => '1',
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s'),
        ]);
    }
}
