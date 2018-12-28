<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use CyrildeWit\EloquentViewable\Viewable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Topic extends Model
{
    use SoftDeletes, Viewable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'channel_id',
        'slug',
        'title',
        'content'
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function forum()
    {
        return $this->belongsTo(Forum::class);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    public function lastReply()
    {
        return $this->hasOne(Reply::class)->with('user')->latest();
    }
}