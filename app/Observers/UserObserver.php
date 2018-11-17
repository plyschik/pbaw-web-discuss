<?php

namespace App\Observers;

use App\User;

class UserObserver
{
    /**
     * Handle the user "created" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function created(User $user)
    {
        $dispatcher = User::getEventDispatcher();

        User::unsetEventDispatcher();

        $user->update([
            'slug' => str_slug($user->id . ' ' . $user->name)
        ]);

        User::setEventDispatcher($dispatcher);
    }

    /**
     * Handle the user "updated" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function updated(User $user)
    {
        $dispatcher = User::getEventDispatcher();

        User::unsetEventDispatcher();

        $user->update([
            'slug' => str_slug($user->id . ' ' . $user->name)
        ]);

        User::setEventDispatcher($dispatcher);
    }
}