<?php

namespace App\Http\ViewComposers;

use App\Channel;
use Illuminate\View\View;

class ChannelsListComposer
{
    /**
     * Bind data to view.
     *
     * @param View $view
     * @return void
     */
    public function compose(View $view)
    {
        $channels = (new Channel)
            ->select(['id', 'name'])
            ->withCount('topics')
            ->orderBy('name', 'ASC')
            ->get();

        $view->with('channels', $channels);
    }
}