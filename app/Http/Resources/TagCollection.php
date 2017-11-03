<?php namespace App\Http\Resources;

class TagCollection extends ResourceApiCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return $this->getResourceCollection(TagResource::class);
    }
}
