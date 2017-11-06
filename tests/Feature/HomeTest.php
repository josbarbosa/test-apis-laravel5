<?php namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HomeTest extends TestCase
{
    /** @test */
    public function it_tests_home_page()
    {
        $this->get('/')->assertStatus(200);
    }

    /** @test */
    public function it_throws_404_when_query_wrong_route_page()
    {
        $this->get('/wrongroute')->assertStatus(404);
    }
}
