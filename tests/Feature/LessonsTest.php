<?php namespace Tests\Feature;

use App\Lesson;
use App\Tag;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

/**
 * Class LessonsTest
 * @package Tests\Feature
 */
class LessonsTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    function a_user_needs_to_receive_a_valid_lesson_json_structure_response(): void
    {
        /** Given some lessons */
        create(Lesson::class, 10);

        /** and a number of lessons to paginate */
        $itemsPerPage = 2;
        setItemsPerPage('lessons', $itemsPerPage);

        /** we fetch the lessons */
        $response = $this->getJson('api/v1/lessons');

        /** see if exists items in the data structure of the response */
        $this->assertCount($itemsPerPage, $response->decodeResponseJson()['data'] ?? []);

        /** Test the json structure */
        $response->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'code',
                'data'  => [
                    '*' => [
                        'id',
                        'title',
                        'body',
                        'active',
                        'tags' => [
                            '*' => [
                                'id',
                                'name',
                            ],
                        ],
                        'created_at',
                        'updated_at',
                    ],
                ],
                'links' => [
                    'first',
                    'last',
                    'prev',
                    'next',
                ],
                'meta'  => [
                    'current_page',
                    'from',
                    'last_page',
                    'path',
                    'per_page',
                    'to',
                    'total',
                ],
            ]);
    }

    /** @test */
    function it_fetches_lessons_with_tags_using_pagination(): void
    {
        /** Lets change the lesson items per page */
        $itemsPerPage = 2;
        setItemsPerPage('lessons', $itemsPerPage);

        /** Create some Lessons with Tags */
        ($lessons = create(Lesson::class, 20))->each(function ($lesson) {
            $lesson->tags()->attach(create(Tag::class, 2));
        });

        /** fetch the first lessons to see if the response returns a 200 ok status */
        $response = $this->getJson('api/v1/lessons')->assertStatus(200);

        /** Get the url of the last page to query the api again
         * and test if the last item created is in the json response
         */
        $lastPageUrl = $response->decodeResponseJson()['links']['last'] ?? '';
        $response = $this->getJson($lastPageUrl);

        /** Get the last one */
        $lastLesson = $lessons->last();

        /** Test the Lesson json fragment */
        $response->assertStatus(200)
            ->assertJsonFragment($this->getLessonFragment($lastLesson));
    }

    /** @test */
    function it_fetches_a_single_lesson(): void
    {
        $lesson = create(Lesson::class, 1);
        $lesson->tags()->attach(create(Tag::class, 2));

        $response = $this->getJson('api/v1/lessons/' . $lesson->id)
            ->assertStatus(200);

        $response->assertJsonFragment($this->getLessonFragment($lesson));
    }

    /** @test */
    function it_404s_if_a_lesson_is_not_found(): void
    {
        create(Lesson::class, 20);

        $this->getJson('api/v1/lessons/21')->assertStatus(404);
    }

    /** @test */
    function it_creates_a_new_lesson_given_valid_parameters(): void
    {
        $this->signIn();

        $response = $this->postJson('api/v1/lessons', [
            'title'  => 'New Title',
            'body'   => 'New Body',
            'active' => true,
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'message',
                'code',
                'data',
            ]);
    }

    /** @test */
    function it_throws_a_422_if_a_new_lesson_request_fails_validation(): void
    {
        $this->signIn();

        $response = $this->postJson('api/v1/lessons')
            ->assertStatus(422);

        $errors = $response->decodeResponseJson()['errors'] ?? [];

        $this->assertResponseHasKeys(
            ['title', 'body'],
            $errors
        );
    }

    /** @test */
    function it_deletes_a_lesson(): void
    {
        $this->signIn();

        $lesson = create(Lesson::class, 1);

        $response = $this->deleteJson('api/v1/lessons/' . $lesson->id);

        $response->assertStatus(200)
            ->assertJson([
                'code' => 200,
            ])
            ->assertJsonStructure([
                'message',
                'code',
            ]);
    }

    /** @test */
    function it_throws_a_401_when_trying_to_delete_a_lesson_and_is_not_authenticated(): void
    {
        $lesson = create(Lesson::class, 1);

        $response = $this->deleteJson('api/v1/lessons/' . $lesson->id);

        $response->assertStatus(401)
            ->assertJson([
                'code' => 401,
            ])
            ->assertJsonStructure([
                'message',
                'code',
            ]);
    }

    /** @test */
    function it_tries_to_delete_a_lesson_that_not_exists(): void
    {
        $this->signIn();

        $this->deleteJson('api/v1/lessons/1')->assertStatus(404);
    }

    /** @test */
    function it_updates_a_lesson(): void
    {
        $this->signIn();

        $lesson = create(Lesson::class, 1);

        $newTitle = 'New Title';
        $this->patchJson('api/v1/lessons/' . $lesson->id, [
            'title' => $newTitle,
        ])
            ->assertStatus(200)
            ->assertJsonFragment([
                'title' => $newTitle,
                'body'  => $lesson->body,
            ])
            ->assertJsonStructure([
                'message',
                'code',
                'data',
            ]);
    }

    /** @test */
    function it_throws_a_401_when_trying_to_update_a_lesson_and_is_not_authenticated(): void
    {
        $lesson = create(Lesson::class, 1);

        $this->patchJson('api/v1/lessons/' . $lesson->id, [
            'title' => 'New Title',
        ])
            ->assertStatus(401)
            ->assertJson([
                'code' => 401,
            ])
            ->assertJsonStructure([
                'message',
                'code',
            ]);
    }

    /** @test */
    function it_tries_to_update_a_lesson_that_not_exists(): void
    {
        $this->signIn();

        $this->deleteJson('api/v1/lessons/1', ['title' => 'New Title'])->assertStatus(404);
    }

    /**
     * @param array $attributes
     * @param array $response
     */
    private function assertResponseHasKeys(array $attributes, array $response): void
    {
        collect($attributes)->each(function ($attribute) use ($response) {
            $this->assertArrayHasKey($attribute, $response);
        });
    }

    /**
     * @param Lesson $lesson
     * @return array
     */
    private function getLessonFragment(Lesson $lesson): array
    {
        return [
            'id'         => $lesson->id,
            'title'      => $lesson->title,
            'body'       => $lesson->body,
            'active'     => $lesson->active,
            'tags'       => $this->extractTagsToArray($lesson),
            'created_at' => (array)Carbon::parse($lesson->created_at),
            'updated_at' => (array)Carbon::parse($lesson->updated_at),
        ];
    }

    /**
     * @param Lesson $lesson
     * @return array
     */
    private function extractTagsToArray(Lesson $lesson): array
    {
        $tagsArray = [];
        $lesson->tags->each(function ($tag) use (&$tagsArray) {
            array_push($tagsArray, [
                'id'   => $tag->id,
                'name' => $tag->name,
            ]);
        });

        return $tagsArray;
    }
}
