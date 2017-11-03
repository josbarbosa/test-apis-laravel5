<?php namespace App\Traits;

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
     * @param $data
     * @param array $headers
     * @return mixed
     */
    public function respond($data, $headers = [])
    {
        return Response::json($data, $this->getStatusCode(), $headers);
    }

    /**
     * @param $errors
     * @return mixed
     */
    public function respondWithErrors($errors)
    {
        return $this->respond(array_merge($this->buildMessagableResponse(), ['errors' => $errors]));
    }

    /**
     * @return mixed
     */
    public function respondWithSuccess()
    {
        return $this->respond($this->buildMessagableResponse());
    }

    /**
     * @return mixed
     */
    public function respondWithErrorMessage()
    {
        return $this->respond($this->buildMessagableResponse());
    }

    /**
     * @return mixed
     */
    public function respondNotFound()
    {
        return $this->setMessage('Not found')
            ->setStatusCode(StatusCode::HTTP_NOT_FOUND)
            ->respondWithErrorMessage();
    }

    /**
     * @return mixed
     */
    public function respondUnauthorized()
    {
        return $this->setMessage('Invalid credentials')
            ->setStatusCode(StatusCode::HTTP_UNAUTHORIZED)
            ->respondWithErrorMessage();
    }


    /**
     * @return mixed
     */
    public function respondInternalError()
    {
        return $this->setMessage('Internal Server Error')
            ->setStatusCode(StatusCode::HTTP_INTERNAL_SERVER_ERROR)
            ->respondWithErrorMessage();
    }

    /**
     * @param null $errors
     * @return mixed
     */
    public function respondFailedValidation($errors = null)
    {
        return $this->setMessage('Failed Validation')
            ->setStatusCode(StatusCode::HTTP_UNPROCESSABLE_ENTITY)
            ->respondWithErrors($errors);
    }

    /**
     * @return mixed
     */
    public function respondeDeleteSuccess()
    {
        return $this->setMessage('Resource deleted successfully')
            ->setStatusCode(StatusCode::HTTP_OK)
            ->respondWithSuccess();
    }

    /**
     * @return mixed
     */
    public function respondeUpdateSuccess()
    {
        return $this->setMessage('Resource updated successfully')
            ->setStatusCode(StatusCode::HTTP_OK)
            ->respondWithSuccess();
    }
}
