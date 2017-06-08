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

        DB::table('user')->insert([
            'account' => 'charis',
            'pwd'  => 'eyJpdiI6IjRQVXJaS1FSaGRBVU5QaGFzY0g2SEE9PSIsInZhbHVlIjoiaXF6Q3owNzRtSjBSb25XUWtzYWlTdz09IiwibWFjIjoiOTc3NTQzYzk5NWQzNmE4NWI3ZmU0OGU0Mjc5YmQ2ZjNmZWY2YzIyNDM1MDI3MDEyNzA4MmMxYTE3NTljNmQwNiJ9',
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

        DB::table('user_accountset')->insert([
            'uid' => '1',
            'flag'=> '1',
            'bank_payee' => '张三',
            'bank_name'=> '中国邮政',
            'accountnumber'=>'6555555555555555',
            'province'=>'陕西',
            'city'=>'西安',
            'branchname'=>'电子二路支行',
            'status' => '1',
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s'),
        ]);

        DB::table('user_address')->insert([
            'uid' => '1',
            'province'=> '陕西',
            'city' => '西安',
            'area'=>'雁塔区',
            'detail'=> '锦业路',
            'consignor'=>'张三',
            'mob'=>'13111111111',
            'remark'=>'备注',
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s'),
        ]);
    }
}
