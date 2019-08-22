<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

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
            'price' => '1 грн.',
            'time' => '1 day',
            'id_order' => 1,
            'id_worker' => 3,
            'created_at' => Carbon::now(),
        ]);
    }
}
