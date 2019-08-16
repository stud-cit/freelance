<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class UsersInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users_info')->insert([
            'id_user' => 1,
            'name' => 'admin',
            'surname' => 'admin',
            'patronymic' => 'admin',
            'birthday_date' => '2019-07-03',
            'phone_number' => '777777',
            'viber' => '123456789',
            'skype' => '@admin',
            'about_me' => 'very good man',
        ]);

        Storage::disk('public')->copy('0.png', '1.png');
    }
}
