<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Channel extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function topics()
    {
        return $this->hasMany(Topic::class);
    }

    public function replies()
    {
        return $this->hasManyThrough(Reply::class, Topic::class);
    }

    public function lastReplies()
    {
        return $this->replies()->with(['topic', 'user'])->latest();
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
