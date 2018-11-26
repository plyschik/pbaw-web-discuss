<?php

namespace App;

use Cog\Laravel\Ban\Traits\Bannable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Cog\Contracts\Ban\Bannable as BannableContract;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail, BannableContract
{
    use HasRoles, Bannable, SoftDeletes, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'slug',
        'name',
        'email',
        'password',
        'date_of_birth',
        'last_logged_in',
        'ip_address',
        'user_agent',
        'email_verified_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $dates = [
        'date_of_birth',
        'last_logged_in'
    ];

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
        return $this->hasMany(Reply::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
