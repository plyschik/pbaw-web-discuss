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
        if($user->hasRole('administrator')){
            return true;
        }

        if($user->categories()->where('category_id', $topic->channel->category->id)->count() && !$topic->user->hasRole('administrator')){
            return true;
        }

        return $user->id === $topic->user_id;
    }
}
