<?php namespace App\Http\Controllers;

use App\Http\Resources\TagCollection;
use App\Tag;
use App\Traits\ResponsableApi;
use Illuminate\Http\JsonResponse;

/**
 * Class TagsController
 * @package App\Http\Controllers
 */
class TagsController extends Controller
{
    use ResponsableApi;

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return (new TagCollection(
            Tag::paginate(getItemsPerPage('tags'))
        ))->response();
    }

    /**
     * @param Tag $tag
     * @return JsonResponse
     */
    public function show(Tag $tag): JsonResponse
    {
        return (new TagCollection($tag->get()))->response();
    }
}
