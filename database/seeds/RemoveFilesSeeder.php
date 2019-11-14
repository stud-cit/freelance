<?php

use Illuminate\Database\Seeder;

class RemoveFilesSeeder extends Seeder
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

        $files = glob('storage/orders/*');

        foreach ($files as $file) {
            unlink($file);
        }
    }
}
