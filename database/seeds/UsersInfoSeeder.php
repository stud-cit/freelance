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
            'country' => 'Ukraine',
            'city' => 'Sumy'
        ]);

        DB::table('users_info')->insert([
            'id_user' => 2,
            'name' => 'customer',
            'surname' => 'customer',
            'patronymic' => 'customer',
            'birthday_date' => '2019-07-03',
            'phone_number' => '1234567',
            'viber' => '214557',
            'skype' => '@customer',
            'about_me' => 'customer',
            'country' => 'Ukraine',
            'city' => 'Sumy'
        ]);

        DB::table('users_info')->insert([
            'id_user' => 3,
            'name' => 'worker',
            'surname' => 'worker',
            'patronymic' => 'worker',
            'birthday_date' => '2019-07-03',
            'phone_number' => '867543',
            'viber' => '23657',
            'skype' => '@worker',
            'about_me' => 'worker',
            'country' => 'Ukraine',
            'city' => 'Sumy'
        ]);

        $files = glob('public/img/*');

        foreach ($files as $file) {
            if (is_file($file) && $file != "public/img/0.png") {
                unlink($file);
            }
        }

        Storage::disk('public')->copy('0.png', '1.png');
        Storage::disk('public')->copy('0.png', '2.png');
        Storage::disk('public')->copy('0.png', '3.png');
    }
}
