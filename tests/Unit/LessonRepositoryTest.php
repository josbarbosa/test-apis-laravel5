<?php namespace Tests\Unit;

use App\Lesson;
use App\Repositories\LessonRepository;
use App\Tag;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class LessonRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function lessons_with_group_tags()
    {
        $lesson = create(Lesson::class, 1);
        $lesson->tags()->attach($tags = create(Tag::class, 2));

        $lessonRepo = new LessonRepository();

        $lessonGroupTags = $lessonRepo->getLessonsWithGroupedTags();

        $this->assertEquals($lesson->title, $lessonGroupTags->first()->title);

        $this->assertEquals($lesson->tags->reduce(function ($name, $tag) {
            return $name . (($name) ? ',' : '') . $tag->name;
        }), $lessonGroupTags->first()->names);
    }
}
