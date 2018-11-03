<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function manage(User $user, User $model)
    {
        if($user->hasRole('administrator')){
            return true;
        }
        return $user->id === $model->id;
    }
}
