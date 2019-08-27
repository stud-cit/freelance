<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

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
            'price' => '1 $',
            'time' => '123 год.',
            'status' => 'new',
            'id_customer' => 2,
            'id_worker' => null,
            'created_at' => Carbon::now(),
        ]);
    }
}
