<?php

use Illuminate\Database\Seeder;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('orders')->insert([
            'title' => 'Shop',
            'description' => 'default stuff shop',
            'price' => 1,
            'time' => '123 hours',
            'status' => 'complete',
            'id_customer' => 1,
            'id_worker' => null,
        ]);
    }
}
