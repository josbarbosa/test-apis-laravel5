<?php namespace App\Traits;

trait ClassResolverResources
{
    /**
     * Tries to map the given collection resource into its individual resources
     * Using the model class that collection belongs
     *
     * @param $resource
     * @return string
     */
    protected function resolveResourceClass($resource)
    {
        $modelClassName = get_class($resource->first());
        $resourceClass = (new \ReflectionClass($modelClassName))->getShortName() . 'Resource';
        if (class_exists($resourceClass = ('App\\Http\\Resources\\' . $resourceClass))) {
            return $resourceClass;
        }
    }
}
