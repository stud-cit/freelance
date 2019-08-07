<?php

use Illuminate\Database\Seeder;

class ProposalsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('proposals')->insert([
            'text' => 'I\'ll make fast & cheap',
            'price' => '1',
            'time' => '1 day',
            'id_order' => 1,
            'id_worker' => 1,
        ]);
    }
}
