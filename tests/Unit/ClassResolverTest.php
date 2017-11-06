<?php namespace Tests\Unit;

use App\Lesson;
use App\Repositories\LessonRepository;
use App\Tag;
use App\Traits\ClassResolverResources;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ClassResolverTest extends TestCase
{
    use DatabaseTransactions, ClassResolverResources;

    /** @test */
    public function it_search_for_a_resource()
    {
        /** Using known model Lesson */
        $lesson = create(Lesson::class, 1);
        $lesson->tags()->attach(create(Tag::class, 2));

        $this->assertNotNull($this->resolveResourceClass(Lesson::all()));

        /** Using collection */
        $lessonRepo = new LessonRepository();

        $this->assertNull($this->resolveResourceClass($lessonRepo->getLessonsWithGroupedTags()));
    }
}
