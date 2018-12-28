<?php

namespace App\Observers;

use App\Forum;

class ForumObserver
{
    /**
     * Handle the channel "created" event.
     *
     * @param  \App\Forum  $channel
     * @return void
     */
    public function created(Forum $channel)
    {
        $dispatcher = Forum::getEventDispatcher();

        Forum::unsetEventDispatcher();

        $channel->update([
            'slug' => str_slug($channel->id . ' ' . $channel->name)
        ]);

        Forum::setEventDispatcher($dispatcher);
    }

    /**
     * Handle the channel "updated" event.
     *
     * @param  \App\Forum  $channel
     * @return void
     */
    public function updated(Forum $channel)
    {
        $dispatcher = Forum::getEventDispatcher();

        Forum::unsetEventDispatcher();

        $channel->update([
            'slug' => str_slug($channel->id . ' ' . $channel->name)
        ]);

        Forum::setEventDispatcher($dispatcher);
    }
}