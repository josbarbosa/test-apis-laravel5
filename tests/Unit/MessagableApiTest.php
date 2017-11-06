<?php namespace Tests\Unit;

use App\Traits\MessagableApi;
use Tests\TestCase;

class MessagableApiTest extends TestCase
{
    use MessagableApi;

    /** @test */
    public function it_has_default_values(): void
    {
        $this->assertArraySubset($this->buildMessagableResponse(), [
            'message' => 'success',
            'code'    => 200,
        ]);
    }

    /** @test */
    public function it_builds_a_message_response(): void
    {
        $this->setStatusCode(204);
        $this->setMessage('New message');

        $this->assertArraySubset($this->buildMessagableResponse(), [
            'message' => $this->getMessage(),
            'code'    => $this->getStatusCode(),
        ]);
    }
}
