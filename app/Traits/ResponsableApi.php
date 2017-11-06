<?php namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Response as StatusCode;

/**
 * Trait ResponsableApi
 * @package App\Traits
 */
trait ResponsableApi
{
    use MessagableApi;

    /**
     * @param array $data
     * @param array $headers
     * @return JsonResponse
     */
    public function respond(array $data, array $headers = []): JsonResponse
    {
        return Response::json($data, $this->getStatusCode(), $headers);
    }

    /**
     * @param $errors
     * @return JsonResponse
     */
    public function respondWithErrors($errors): JsonResponse
    {
        return $this->respond(array_merge($this->buildMessagableResponse(), ['errors' => $errors]));
    }

    /**
     * @return JsonResponse
     */
    public function respondWithSuccess(): JsonResponse
    {
        return $this->respond($this->buildMessagableResponse());
    }

    /**
     * @return JsonResponse
     */
    public function respondWithErrorMessage(): JsonResponse
    {
        return $this->respond($this->buildMessagableResponse());
    }

    /**
     * @return JsonResponse
     */
    public function respondNotFound(): JsonResponse
    {
        return $this->setMessage('Not found')
            ->setStatusCode(StatusCode::HTTP_NOT_FOUND)
            ->respondWithErrorMessage();
    }

    /**
     * @return JsonResponse
     */
    public function respondUnauthorized(): JsonResponse
    {
        return $this->setMessage('Invalid credentials')
            ->setStatusCode(StatusCode::HTTP_UNAUTHORIZED)
            ->respondWithErrorMessage();
    }

    /**
     * @return JsonResponse
     */
    public function respondInternalError(): JsonResponse
    {
        return $this->setMessage('Internal Server Error')
            ->setStatusCode(StatusCode::HTTP_INTERNAL_SERVER_ERROR)
            ->respondWithErrorMessage();
    }

    /**
     * @param $errors
     * @return JsonResponse
     */
    public function respondFailedValidation($errors = null): JsonResponse
    {
        return $this->setMessage('Failed Validation')
            ->setStatusCode(StatusCode::HTTP_UNPROCESSABLE_ENTITY)
            ->respondWithErrors($errors);
    }

    /**
     * @return JsonResponse
     */
    public function respondDeleteSuccess(): JsonResponse
    {
        return $this->setMessage('Resource deleted successfully')
            ->setStatusCode(StatusCode::HTTP_OK)
            ->respondWithSuccess();
    }

    /**
     * @return JsonResponse
     */
    public function respondBadRequest(): JsonResponse
    {
        return $this->setMessage('Resource malformed')
            ->setStatusCode(StatusCode::HTTP_BAD_REQUEST)
            ->respondWithErrorMessage();
    }

    public function respondResourceNotFound(): JsonResponse
    {
        return $this->setMessage('Api resource not found.')
            ->setStatusCode(StatusCode::HTTP_FAILED_DEPENDENCY)
            ->respondWithErrorMessage();
    }
}
