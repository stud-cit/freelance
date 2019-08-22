<?php

use Illuminate\Database\Seeder;

class ReviewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('reviews')->insert([
            'text' => 'great job',
            'rating' => '100',
            'id_customer' => 2,
            'id_worker' => 3,
        ]);
    }
}
