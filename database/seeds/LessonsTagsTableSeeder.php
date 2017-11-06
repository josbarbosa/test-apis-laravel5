<?php

use App\Lesson;
use App\Tag;
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
        $lessons = Lesson::all();
        $tags = Tag::all();

        $lessons->each(function ($lesson) use ($tags) {
            $lesson->tags()->attach($tags->random(rand(1, 5)));
        });
    }
}
