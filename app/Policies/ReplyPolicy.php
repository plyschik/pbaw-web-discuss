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
        if ($user->hasRole('administrator')) {
            return true;
        }

        if ($user->categories()->where('category_id', $reply->topic->channel->category->id)->count() && !$reply->user->hasRole('administrator')) {
            return true;
        }

        return $user->id === $reply->user_id;
    }
}
