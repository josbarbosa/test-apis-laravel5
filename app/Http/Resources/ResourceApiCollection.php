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
     * @var string
     */
    protected $resourceClass;

    /**
     * ResourceApiCollection constructor.
     * @param $resource
     * @param $resourceClass
     */
    public function __construct($resource, $resourceClass = null)
    {
        parent::__construct($resource);

        $this->resourceClass = $resourceClass;
    }

    /**
     * Return a Resource Class Name
     *
     * @return string
     */
    public function getResourceClass(): string
    {
        return $this->resourceClass;
    }

    /**
     * @param $resourceClass
     * @return ResourceApiCollection
     */
    public function setResourceClass($resourceClass): self
    {
        $this->resourceClass = $resourceClass;

        return $this;
    }

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
    public function withCreateCodeStatus()
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
    public function withUpdateCodeStatus()
    {
        $this->setStatusCode(StatusCode::HTTP_OK);

        return $this;
    }

    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var string $wrap */
        return $this->merge($this->buildMessagableResponse(), 2, [
            $this->resourceClass::$wrap =>
                $this->collectResource(
                    $this->resourceClass::collection($this->collection)
                ),
        ]);
    }
}
