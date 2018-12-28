<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $fillable = ['name'];

    public function forums()
    {
        return $this->hasMany(Forum::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
