<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $values = [
            ['name' => 'C#'],
            ['name' => 'C/C++'],
            ['name' => 'Flash/Flex'],
            ['name' => 'Java'],
            ['name' => 'Javascript'],
            ['name' => '.NET'],
            ['name' => 'Node.js'],
            ['name' => 'PHP'],
            ['name' => 'Python'],
            ['name' => 'Ruby'],
            ['name' => 'Swift'],
            ['name' => 'Бази данних'],
            ['name' => 'Тестування і QA'],
        ];

        DB::table('categories')->insert($values);
    }
}
