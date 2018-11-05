<?php

namespace App\Observers;

use App\Channel;

class ChannelObserver
{
    /**
     * Handle the channel "creating" event.
     *
     * @param  \App\Channel  $channel
     * @return void
     */
    public function creating(Channel $channel)
    {
        $channel->slug = str_slug($channel->name);
    }

    /**
     * Handle the channel "updating" event.
     *
     * @param  \App\Channel  $channel
     * @return void
     */
    public function updating(Channel $channel)
    {
        $channel->slug = str_slug($channel->name);
    }
}
