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
        /** 1. All is bad */
        /** 2. No way to attach meta data */
        /** 3. Linking db structure to the API output */
        /** 4. No way to signal headers/response codes */

        /** return Lesson::all();  really bad practice */

        /** https://www.rfc-editor.org/rfc/rfc2616.txt */

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
        if ($lesson->delete()) {
            return $this->respondDeleteSuccess();
        } else {
            return $this->respondInternalError();
        }
    }


    /**
     * @param LessonRequest $request
     * @param Lesson $lesson
     * @return ResourceApiCollection|JsonResponse
     */
    public function update(Lesson $lesson, LessonRequest $request)
    {
        if ($lesson->update($request->all())) {
            return (new ResourceApiCollection($lesson->get()))
                ->withUpdateStatusCode()
                ->setMessage('Lesson updated successfully');
        } else {
            return $this->respondBadRequest();
        }
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
     * @param LessonRepository $lessonRepo
     * @return ResourceApiCollection
     */
    public function tagsGroup(LessonRepository $lessonRepo): ResourceApiCollection
    {
        return (new ResourceApiCollection(
            $lessonRepo->getLessonsWithGroupedTags(), TagGroupResource::class)
        );
    }

}
