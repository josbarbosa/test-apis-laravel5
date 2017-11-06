<?php namespace Tests\Unit;

use App\Exceptions\ResourceCollectionNotFound;
use App\Http\Resources\LessonResource;
use App\Http\Resources\ResourceApiCollection;
use Tests\TestCase;

class ResourceCollectionTest extends TestCase
{
    /** @test */
    function it_throws_exception_resource_collection_not_found(): void
    {
        $this->expectException(ResourceCollectionNotFound::class);
        (new ResourceApiCollection(collect([])))->toArray(request());
    }

    /** @test */
    function it_set_a_response_status_code(): void
    {
        $code = 204;
        $response = (new ResourceApiCollection(collect([]),
            LessonResource::class))->setStatusCode($code)->toArray(request());
        $this->assertAttributeEquals($code, 'code', (object)$response);
    }
}
