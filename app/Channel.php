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
}
