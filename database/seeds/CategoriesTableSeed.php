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
            ['name' => 'Розробка ПЗ'],
            ['name' => 'Дизайн'],
            ['name' => 'Контент-менеджмент'],
            ['name' => 'Адміністрування ресурсів'],
            ['name' => 'Підтримка користувачів'],
            ['name' => 'Тестування та QA'],
            ['name' => 'Аналітика'],
            ['name' => 'інше'],
        ];

        DB::table('categories')->insert($values);
    }
}
