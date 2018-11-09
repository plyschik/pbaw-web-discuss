<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name'];

    public function channels()
    {
        return $this->hasMany(Channel::class);
    }
}
