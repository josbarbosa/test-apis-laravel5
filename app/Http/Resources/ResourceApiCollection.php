<?php namespace App\Http\Resources;

use App\Exceptions\ResourceCollectionNotFound;
use App\Traits\ClassResolverResources;
use App\Traits\MessagableApi;
use App\Traits\StatusCodeResources;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * In this small example project every json response has the same structure
 * Created class that extends the ResourceCollection class
 * and build the json dynamically without the need to create
 * a correspondent collection for every resource
 *
 * Class ResourceApiCollection
 * @package App\Http\Resources
 */
class ResourceApiCollection extends ResourceCollection
{
    use MessagableApi, StatusCodeResources, ClassResolverResources;

    /**
     * Parent constructor override
     * @param $resource
     * @param $resourceClass
     */
    public function __construct($resource, $resourceClass = null)
    {
        $this->collects = $resourceClass ?? $this->resolveResourceClass($resource);

        parent::__construct($resource);
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
     * Parent class toArray override
     *
     * @param Request $request
     * @return array
     * @throws \Exception
     */
    public function toArray($request)
    {
        if (!$this->collects) {
            throw new ResourceCollectionNotFound();
        }

        return $this->merge(
            $this->buildMessagableResponse(),
            2,
            [
                $this::$wrap => $this->collection->toArray(),
            ]
        );
    }
}
