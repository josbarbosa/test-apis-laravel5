<?php namespace App\Http\Controllers;

use App\Http\Resources\ResourceApiCollection;
use App\Http\Resources\TagResource;
use App\Tag;
use App\Traits\ResponsableApi;

/**
 * Class TagsController
 * @package App\Http\Controllers
 */
class TagsController extends Controller
{
    use ResponsableApi;

    /**
     * @var string
     */
    protected $tagResourceClass = TagResource::class;

    /**
     * @return ResourceApiCollection
     */
    public function index(): ResourceApiCollection
    {
        return (new ResourceApiCollection(
            Tag::paginate(getItemsPerPage('tags')), $this->tagResourceClass
        ));
    }

    /**
     * @param Tag $tag
     * @return ResourceApiCollection
     */
    public function show(Tag $tag): ResourceApiCollection
    {
        return (new ResourceApiCollection($tag->get(), $this->tagResourceClass));
    }
}
