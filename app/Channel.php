<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    protected $guarded = [];

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

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
