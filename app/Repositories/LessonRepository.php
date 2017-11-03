<?php namespace App\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

/**
 * Class LessonRepository
 * @package App\Repositories
 */
class LessonRepository
{
    /**
     * @return LengthAwarePaginator
     */
    public function getLessonsWithGroupedTags(): LengthAwarePaginator
    {
        return DB::table('lessons')
            ->select('lessons.id', 'title', 'body', 'active', DB::raw('group_concat(tags.name) as names'))
            ->join('lesson_tag', 'lessons.id', '=', 'lesson_tag.lesson_id')
            ->join('tags', 'lesson_tag.tag_id', '=', 'tags.id')
            ->groupBy('lessons.id', 'title', 'body', 'active')
            ->paginate(getItemsPerPage());
    }
}
