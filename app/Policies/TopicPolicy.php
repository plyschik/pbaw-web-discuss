<?php

namespace App\Policies;

use App\User;
use App\Topic;
use Illuminate\Auth\Access\HandlesAuthorization;

class TopicPolicy
{
    use HandlesAuthorization;

    public function manage(User $user, Topic $topic)
    {
        if($user->hasRole('administrator|moderator')){
            return true;
        }
        return $user->id === $topic->user_id;
    }
}
