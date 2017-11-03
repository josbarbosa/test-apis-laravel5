<?php namespace App\Http\Controllers;

use App\Http\Requests\LessonRequest;
use App\Http\Resources\LessonCollection;
use App\Http\Resources\TagCollection;
use App\Lesson;
use App\Traits\ResponsableApi;

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
     * @return LessonCollection
     */
    public function index(): LessonCollection
    {
        /** 1. All is bad */
        /** 2. No way to attach meta data */
        /** 3. Linking db structure to the API output */
        /** 4. No way to signal headers/response codes */

        /** return Lesson::all();  really bad practice */

        /** https://www.rfc-editor.org/rfc/rfc2616.txt */


        return (new LessonCollection(
            Lesson::paginate(getItemsPerPage('lessons'))
        ));
    }

    /**
     * @param Lesson $lesson
     * @return LessonCollection
     */
    public function show(Lesson $lesson): LessonCollection
    {
        return (new LessonCollection($lesson->get()));
    }

    /**
     * @param LessonRequest $request
     * @return LessonCollection
     */
    public function store(LessonRequest $request): LessonCollection
    {
        $lesson = Lesson::create($request->all());

        return (new LessonCollection($lesson->get()))
            ->withCreatedCodeStatus()
            ->setMessage('Lesson created successfully');
    }

    /**
     * @param Lesson $lesson
     * @return mixed
     */
    public function destroy(Lesson $lesson)
    {
        if ($lesson->delete()) {
            return $this->respondeDeleteSuccess();
        } else {
            return $this->respondInternalError();
        }
    }

    /**
     * @param Lesson $lesson
     * @return mixed
     */
    public function update(Lesson $lesson)
    {
        if ($lesson->update(request()->all())) {
            return (new LessonCollection($lesson->get()))
                ->withUpdatedCodeStatus()
                ->setMessage('Lesson updated successfully');
        } else {
            return $this->respondInternalError();
        }
    }

    /**
     * @param Lesson $lesson
     * @return TagCollection
     */
    public function tags(Lesson $lesson): TagCollection
    {
        return (new TagCollection($lesson->tags));
    }

}
