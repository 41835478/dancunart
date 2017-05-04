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
            'name' => 'admin',
            'nick' => '超级管理员',
            'pwd'  => 'a8516ab986c1479ce5efc0ca10a37129',
            'salt'  => 'a8516ab986c1479ce5efc0ca10a37129',
            'last_login_ip' => '127.0.0.1',
            'status' => '1',
            'role_id' => '1',
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s'),
        ]);
    }
}
