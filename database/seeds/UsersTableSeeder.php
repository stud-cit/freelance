<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       	DB::table('users')->insert([
       	    'id_role' => 1,
            'email' => 'admin@gmail.com',
            'banned' => false,
            'password' => bcrypt('admin'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
	    ]);

        DB::table('users')->insert([
            'id_role' => 2,
            'email' => 'customer@gmail.com',
            'banned' => false,
            'password' => bcrypt('customer'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('users')->insert([
            'id_role' => 3,
            'email' => 'worker@gmail.com',
            'banned' => false,
            'password' => bcrypt('worker'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
