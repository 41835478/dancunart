<?php

use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('order_recharge')->insert([
            'order_id'=>'ex1426123458632',
            'uid'=>1,
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s'),
        ]);

        DB::table('order_auction')->insert([
            'uid'=>1,
            'artwork_id'=>1,
            'old_price'=>10000,
            'price_increase'=>5000,
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s'),
        ]);

        DB::table('order_withdraw')->insert([
            'uid'=>1,
            'old_cash'=>10000,
            'withdraw_price'=>1000,
            'status'=>0,
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s'),
        ]);
    }
}
