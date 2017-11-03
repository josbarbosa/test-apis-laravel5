<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    private $tables = [
        'lessons',
        'tags',
        'users',
        'lesson_tag',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->cleanDatabase();

        $this->call([
            LessonsTableSeeder::class,
            UsersTableSeeder::class,
            TagsTableSeeder::class,
            LessonsTagsTableSeeder::class,
        ]);
    }

    private function cleanDatabase()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0');

        foreach ($this->tables as $tableName) {
            \DB::table($tableName)->truncate();
        }

        \DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
