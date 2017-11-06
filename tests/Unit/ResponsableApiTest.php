<?php namespace Tests\Unit;

use App\Traits\ResponsableApi;
use Tests\TestCase;

/**
 * Class ResponsableApiTest
 * @package Tests\Unit
 */
class ResponsableApiTest extends TestCase
{
    use ResponsableApi;

    /** @test */
    function respond_with_resource_not_found(): void
    {
        $this->assertRespond($this->respondResourceNotFound(), 'Api resource not found.', 424);
    }

    /** @test */
    function respond_with_bad_request(): void
    {
        $this->assertRespond($this->respondBadRequest(), 'Resource malformed', 400);
    }

    /** @test */
    function respond_with_delete_success(): void
    {
        $this->assertRespond($this->respondDeleteSuccess(), 'Resource deleted successfully', 200);
    }

    /** @test */
    function respond_with_failed_validation(): void
    {
        $this->assertRespond($this->respondFailedValidation(), 'Failed Validation', 422);
    }

    /** @test */
    function respond_with_unauthorized(): void
    {
        $this->assertRespond($this->respondUnauthorized(), 'Invalid credentials', 401);
    }

    /** @test */
    function respond_with_not_found(): void
    {
        $this->assertRespond($this->respondNotFound(), 'Not found', 404);
    }

    /** @test */
    function respond_with_internal_error(): void
    {
        $this->assertRespond($this->respondInternalError(), 'Internal Server Error', 500);
    }

    /**
     * @param $respond
     * @param $message
     * @param $code
     */
    function assertRespond($respond, $message, $code): void
    {
        $this->assertArraySubset(json_decode($respond->getContent(), true), [
            'message' => $message,
            'code'    => $code,
            'errors'  => '',
        ]);
    }
}
