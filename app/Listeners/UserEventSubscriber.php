<?php

namespace App\Listeners;

use Illuminate\Http\Request;

class UserEventSubscriber
{
    private $request;

    /**
     * UserEventSubscriber constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Handle user login event.
     */
    public function onUserLogin($event)
    {
        $event->user->update([
            'last_logged_in' => now(),
            'ip_address' => $this->request->ip(),
            'user_agent' => $this->request->userAgent()
        ]);
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        $events->listen(
            'Illuminate\Auth\Events\Login',
            'App\Listeners\UserEventSubscriber@onUserLogin'
        );
    }
}