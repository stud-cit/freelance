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
	      'name' => 'admin',
	      'surname' => 'admin',
	      'patronymic' => 'admin',
	      'birthday_date' => '2019-07-03',
	      'email' => 'admin@gmail.com',
	      'phone_number' => '777777',
	      'id_role' => 1,
	      'about_me' => 'very good man',
	      'avatar' => '',
	      'password' => bcrypt('admin'),
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
	    ]);
    }
}
