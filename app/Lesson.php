<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $fillable = ['title', 'body', 'active'];

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
