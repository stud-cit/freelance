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
            'birthday_date' => null,
            'phone_number' => null,
            'about_me' => null,
        ]);

        $files = glob('public/img/*');

        foreach ($files as $file) {
            if (is_file($file) && $file != "public/img/0.png") {
                unlink($file);
            }
        }

        Storage::disk('public')->copy('0.png', '1.png');
    }
}
