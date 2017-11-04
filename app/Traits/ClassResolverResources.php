<?php namespace App\Traits;

trait ClassResolverResources
{
    /**
     * @param $resource
     * @return string
     */
    protected function resolveResourceClass($resource)
    {
        $modelClassName = get_class($resource->first());
        $resourceClassName = __NAMESPACE__ . '\\' . (new \ReflectionClass($modelClassName))->getShortName() . 'Resource';

        if (class_exists($resourceClassName)) {
            return $resourceClassName;
        }

        return null;
    }
}
