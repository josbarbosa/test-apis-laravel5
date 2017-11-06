<?php namespace App\Traits;

use Illuminate\Http\Response as StatusCode;

/**
 * Trait MessagableApi
 * @package App\Traits
 */
trait MessagableApi
{
    /**
     * @var int
     */
    protected $statusCode = StatusCode::HTTP_OK;

    /**
     * @var string
     */
    protected $message = 'success';

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @param int $statusCode
     * @return $this
     */
    public function setStatusCode(int $statusCode): self
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;

    }

    /**
     * @param string $message
     * @return $this
     */
    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return array
     */
    public function buildMessagableResponse(): array
    {
        return [
            'message' => $this->getMessage(),
            'code'    => $this->getStatusCode(),
        ];
    }
}
