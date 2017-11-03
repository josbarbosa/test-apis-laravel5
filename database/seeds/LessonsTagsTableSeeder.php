<?php

use Illuminate\Database\Seeder;

class LessonsTagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lessonIds = \DB::table('lessons')->pluck('id')->toArray();
        $tagIds = \DB::table('tags')->pluck('id')->toArray();

        $pivots = [];
        foreach ($lessonIds as $lessonId) {
            /** necessary since shuffle() and array_shift() take an array by reference */
            $randomizedTagIds = $tagIds;

            shuffle($randomizedTagIds);
            for ($index = 0; $index < 3; $index++) {
                $pivots[] = [
                    'lesson_id' => $lessonId,
                    'tag_id'    => array_shift($randomizedTagIds),
                ];
            }
        }

        \DB::table('lesson_tag')->insert($pivots);
    }
}
