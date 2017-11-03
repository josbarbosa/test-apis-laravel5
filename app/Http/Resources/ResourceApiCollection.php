<?php namespace App\Http\Resources;

use App\Traits\MessagableApi;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response as StatusCode;

/**
 * Class ResourceApiCollection
 * @package App\Http\Resources
 */
class ResourceApiCollection extends ResourceCollection
{
    use MessagableApi;

    /**
     * Parent class withResponse override
     *
     * @param Request $request
     * @param JsonResponse $response
     */
    public function withResponse($request, $response): void
    {
        $response->setStatusCode($this->getStatusCode());
    }

    /**
     * HTTP 201, The request has been fulfilled,
     * resulting in the creation of a new resource.
     *
     * @return $this
     */
    public function withCreatedCodeStatus()
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
    public function withUpdatedCodeStatus()
    {
        $this->setStatusCode(StatusCode::HTTP_OK);

        return $this;
    }

    /**
     * @param $resource
     * @return array
     */
    protected function getResourceCollection($resource): array
    {
        return array_merge(
            $this->buildMessagableResponse(),
            [
                $resource::$wrap => $this->collectResource(
                    $resource::collection($this->collection)
                ),
            ]
        );
    }
}
