<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function manage(User $user, User $model)
    {
        if($user->hasRole('administrator')){
            return true;
        }
        return $user->id === $model->id;
    }
}
