<?php

namespace App\Observers;

use App\Channel;

class ChannelObserver
{
    /**
     * Handle the channel "created" event.
     *
     * @param  \App\Channel  $channel
     * @return void
     */
    public function created(Channel $channel)
    {
        $dispatcher = Channel::getEventDispatcher();

        Channel::unsetEventDispatcher();

        $channel->update([
            'slug' => str_slug($channel->id . ' ' . $channel->name)
        ]);

        Channel::setEventDispatcher($dispatcher);
    }

    /**
     * Handle the channel "updated" event.
     *
     * @param  \App\Channel  $channel
     * @return void
     */
    public function updated(Channel $channel)
    {
        $dispatcher = Channel::getEventDispatcher();

        Channel::unsetEventDispatcher();

        $channel->update([
            'slug' => str_slug($channel->id . ' ' . $channel->name)
        ]);

        Channel::setEventDispatcher($dispatcher);
    }
}