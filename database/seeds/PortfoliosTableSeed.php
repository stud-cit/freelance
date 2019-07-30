<?php

use Illuminate\Database\Seeder;

class PortfoliosTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('portfolios')->insert([
            'img' => '',
            'description' => 'my portfolio',
            'id_user' => 1,
        ]);
    }
}
