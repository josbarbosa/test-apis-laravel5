<?php namespace App\Http\Controllers;

use App\Http\Requests\LessonRequest;
use App\Http\Resources\ResourceApiCollection;
use App\Http\Resources\TagGroupResource;
use App\Lesson;
use App\Repositories\LessonRepository;
use App\Traits\ResponsableApi;
use Illuminate\Http\JsonResponse;

/**
 * Class LessonsController
 * @package App\Http\Controllers
 */
class LessonsController extends Controller
{
    use ResponsableApi;

    /**
     * LessonsController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth.basic')->only('store', 'destroy', 'update');
    }


    /**
     * @return ResourceApiCollection
     */
    public function index(): ResourceApiCollection
    {
        return new ResourceApiCollection(Lesson::paginate(getItemsPerPage('lessons')));
    }

    /**
     * @param Lesson $lesson
     * @return ResourceApiCollection
     */
    public function show(Lesson $lesson): ResourceApiCollection
    {
        return new ResourceApiCollection($lesson->get());
    }

    /**
     * @param LessonRequest $request
     * @return ResourceApiCollection
     */
    public function store(LessonRequest $request): ResourceApiCollection
    {
        $lesson = Lesson::create($request->all());

        return (new ResourceApiCollection($lesson->get()))
            ->withCreateStatusCode()
            ->setMessage('Lesson created successfully');
    }

    /**
     * @param Lesson $lesson
     * @return JsonResponse
     */
    public function destroy(Lesson $lesson): JsonResponse
    {
        $lesson->delete();

        return $this->respondDeleteSuccess();
    }


    /**
     * @param LessonRequest $request
     * @param Lesson $lesson
     * @return ResourceApiCollection|JsonResponse
     */
    public function update(Lesson $lesson, LessonRequest $request)
    {
        try {
            $lesson->update($request->all());
        } catch (\Exception $e) {
            return $this->respondBadRequest();
        }

        return (new ResourceApiCollection($lesson->get()))
            ->withUpdateStatusCode()
            ->setMessage('Lesson updated successfully');
    }

    /**
     * @param Lesson $lesson
     * @return ResourceApiCollection
     */
    public function tags(Lesson $lesson): ResourceApiCollection
    {
        return (new ResourceApiCollection($lesson->tags));
    }

    /**
     * @param LessonRepository $lesson
     * @return ResourceApiCollection
     */
    public function tagsGroup(LessonRepository $lesson): ResourceApiCollection
    {
        return (new ResourceApiCollection($lesson->getLessonsWithGroupedTags(), TagGroupResource::class));
    }
}
