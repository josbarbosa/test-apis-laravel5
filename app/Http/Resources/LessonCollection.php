<?php namespace App\Http\Resources;

/**
 * Class LessonCollection
 * @package App\Http\Resources
 */
class LessonCollection extends ResourceApiCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return $this->getResourceCollection(LessonResource::class);
    }
}
