<?php

namespace App\Policies;

use App\User;
use App\Reply;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReplyPolicy
{
    use HandlesAuthorization;

    public function manage(User $user, Reply $reply)
    {
        if($user->hasRole('administrator|moderator')){
            return true;
        }
        return $user->id === $reply->user_id;
    }
}
