<?php namespace Tests\Unit;

use App\Lesson;
use App\Tag;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class LessonTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_returns_all_tags_for_a_given_lesson(): void
    {
        $lesson = create(Lesson::class, 1);
        $lesson->tags()->attach(create(Tag::class, 2));

        $this->assertCount(2, $lesson->tags);
    }
}
