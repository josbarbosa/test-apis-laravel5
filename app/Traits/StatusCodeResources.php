<?php namespace App\Traits;

use Illuminate\Http\Response as StatusCode;

trait StatusCodeResources
{
    /**
     * HTTP 201, The request has been fulfilled,
     * resulting in the creation of a new resource.
     *
     * @return $this
     */
    public function withCreateStatusCode()
    {
        $this->setStatusCode(StatusCode::HTTP_CREATED);

        return $this;
    }

    /**
     * HTTP 200, The request has been fulfilled,
     * resulting in the update of a new resource.
     *
     * @return $this
     */
    public function withUpdateStatusCode()
    {
        $this->setStatusCode(StatusCode::HTTP_OK);

        return $this;
    }
}
