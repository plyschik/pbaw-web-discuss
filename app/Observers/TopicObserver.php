<?php

namespace App\Observers;

use App\Topic;

class TopicObserver
{
    /**
     * Handle the topic "created" event.
     *
     * @param  \App\Topic  $topic
     * @return void
     */
    public function created(Topic $topic)
    {
        $dispatcher = Topic::getEventDispatcher();

        Topic::unsetEventDispatcher();

        $topic->update([
            'slug' => str_slug($topic->id . ' ' . $topic->title)
        ]);

        Topic::setEventDispatcher($dispatcher);
    }

    /**
     * Handle the topic "updated" event.
     *
     * @param  \App\Topic  $topic
     * @return void
     */
    public function updated(Topic $topic)
    {
        $dispatcher = Topic::getEventDispatcher();

        Topic::unsetEventDispatcher();

        $topic->update([
            'slug' => str_slug($topic->id . ' ' . $topic->title)
        ]);

        Topic::setEventDispatcher($dispatcher);
    }
}