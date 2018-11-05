<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reply extends Model
{
    use SoftDeletes;

    protected $fillable = ['user_id', 'topic_id', 'parent_id', 'content', 'is_topic'];
    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class, 'parent_id');
    }
}
