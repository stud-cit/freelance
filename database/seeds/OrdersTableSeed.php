<?php

use Illuminate\Database\Seeder;

class OrdersTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('orders')->insert([
            'title' => 'shop',
            'description' => 'new online shop',
            'status' => 'in progress',
            'id_customer' => 1,
            'id_worker' => 1,
        ]);
    }
}
