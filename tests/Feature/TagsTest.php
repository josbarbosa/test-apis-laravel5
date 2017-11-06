<?php namespace Tests\Feature;

use App\Tag;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class TagsTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    function a_user_needs_to_receive_a_valid_tag_json_structure_response(): void
    {
        /** Given some tags */
        create(Tag::class, 10);

        /** and a number of lessons to paginate */
        $itemsPerPage = 4;
        setItemsPerPage('tags', $itemsPerPage);

        /** we fetch the lessons */
        $response = $this->getJson('api/v1/tags');

        /** see if exists items in the data structure of the response */
        $this->assertCount($itemsPerPage, $response->decodeResponseJson()['data']);

        /** Test the json structure */
        $response->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'code',
                'data'  => [
                    '*' => [
                        'id',
                        'name',
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
    function it_fetches_a_single_tag(): void
    {
        $tag = create(Tag::class, 1);

        $response = $this->getJson('api/v1/tags/' . $tag->id)
            ->assertStatus(200);

        $response->assertJsonFragment($this->tagFragment($tag));
    }
}
