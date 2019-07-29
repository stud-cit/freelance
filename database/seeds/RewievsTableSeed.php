<?php

use Illuminate\Database\Seeder;

class RewievsTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rewievs')->insert([
            'text' => 'great job',
            'rating' => '100',
            'id_customer' => 1,
            'id_worker' => 1,
        ]);
    }
}
