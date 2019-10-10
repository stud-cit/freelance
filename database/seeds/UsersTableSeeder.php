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
            'id_dept' => null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
	    ]);
    }
}
