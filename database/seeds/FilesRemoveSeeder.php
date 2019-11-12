<?php

use Illuminate\Database\Seeder;

class FilesRemoveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $files = glob('storage/files/*');

        foreach ($files as $file) {
            unlink($file);
        }
    }
}
