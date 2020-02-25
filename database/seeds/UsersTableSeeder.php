<?php

use App\Models\User;
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
        $values = [
            'id_role' => 1,
            'email' => 'admin@gmail.com',
            'banned' => false,
            'password' => bcrypt('admin'),
            'id_dept' => null,
            'guid' => ''
        ];

       	User::create($values);
    }
}
