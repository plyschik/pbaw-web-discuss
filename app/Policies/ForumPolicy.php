<?php

namespace App\Policies;

use App\User;
use App\Forum;
use Illuminate\Auth\Access\HandlesAuthorization;

class ForumPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can delete the channel.
     *
     * @param  \App\User  $user
     * @param  \App\Forum  $channel
     * @return mixed
     */
    public function delete(User $user, Forum $channel)
    {
        return !$channel->topics()->count();
    }
}
