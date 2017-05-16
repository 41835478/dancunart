<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user')->insert([
            'account' => 'user1',
            'pwd'  => 'eyJpdiI6IkNRdm9zanVuYURDRkxWVGRUUE5LRlE9PSIsInZhbHVlIjoiS3Q5WnlZZDhFQ0Z6a2RydHVyQ1lRdz09IiwibWFjIjoiMDY1Y2YwZGY5NTU2MjNiYWUyMzA3MDMyZTE0ZmI0YzA4YmU0NmI2NTU1YWM4ODE1ZmE4YzlhNzgwMzkxMzdkNyJ9',
            'nick' => 'charis',
            'email' => '22@qq.com',
            'mob'=>'13111111111',
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s'),
        ]);

        DB::table('user_log')->insert([
            'uid' => '1',
            'action' => '新增用户',
            'admin_id' => '1',
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s'),
        ]);
    }
}
