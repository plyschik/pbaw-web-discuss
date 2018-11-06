<?php

namespace App\Http\ViewComposers;

use App\User;
use App\Topic;
use App\Reply;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;
use CyrildeWit\EloquentViewable\ViewTracker;

class StatsComposer
{
    /**
     * Create a new stats composer.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $stats = [
            'topics' => [
                'total' => Cache::remember('stats.topics.total', config('app.stats.cache.ttl'), function () {
                    return Topic::all()->count();
                }),
                'today' => Cache::remember('stats.topics.today', config('app.stats.cache.ttl'), function () {
                    return Topic::whereDate('created_at', Carbon::today())->count();
                }),
                'views' => Cache::remember('stats.topics.views', config('app.stats.cache.ttl'), function () {
                    return ViewTracker::getViewsCountByType(Topic::class);
                })
            ],
            'replies' => [
                'total' => Cache::remember('stats.replies.total', config('app.stats.cache.ttl'), function () {
                    return Reply::all()->count();
                }),
                'today' => Cache::remember('stats.replies.today', config('app.stats.cache.ttl'), function () {
                    return Reply::whereDate('created_at', Carbon::today())->count();
                })
            ],
            'users' => [
                'total' => Cache::remember('stats.users.total', config('app.stats.cache.ttl'), function () {
                    return User::all()->count();
                }),
                'average_age' => Cache::remember('stats.users.average_age', config('app.stats.cache.ttl'), function () {
                    return round(User::selectRaw("TIMESTAMPDIFF(YEAR, DATE(date_of_birth), current_date) AS age")->get()->avg('age'));
                }),
                'last_registered' => Cache::remember('stats.users.last_registered', config('app.stats.cache.ttl'), function () {
                    return User::orderBy('id', 'desc')->first();
                }),
                'last_logged_in' => Cache::remember('stats.users.last_logged_in', config('app.stats.cache.ttl'), function () {
                    return User::orderBy('last_logged_in', 'desc')->first();
                })
            ],
            'most_replies' => Cache::remember('stats.most_replies', config('app.stats.cache.ttl'), function () {
                $replies = Reply::select('created_at')->get()
                    ->groupBy(function ($date) {
                        return Carbon::parse($date->created_at)->format('d-m-Y');
                    })->sort();

                return [
                    'date' => $replies->keys()->last(),
                    'total' => $replies->last()->count()
                ];
            })
        ];

        $popularTopics = Cache::remember('stats.popular_topics', config('app.stats.cache.ttl'), function () {
            return Topic::withCount('replies')->limit(5)->orderBy('replies_count', 'desc')->get();
        });

        $latestTopics = Cache::remember('stats.latest_topics', config('app.stats.cache.ttl'), function () {
            return Topic::limit(5)->orderBy('created_at', 'desc')->get();
        });

        $view->with(compact('stats'));
        $view->with(compact('popularTopics'));
        $view->with(compact('latestTopics'));
    }
}