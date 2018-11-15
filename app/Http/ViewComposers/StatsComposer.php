<?php

namespace App\Http\ViewComposers;

use App\User;
use App\Topic;
use App\Reply;
use Carbon\Carbon;
use Illuminate\View\View;
use Illuminate\Support\Facades\Cache;
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
                'total' => Cache::remember('stats.topics.total', config('webdiscuss.stats.cache_ttl'), function () {
                    return Topic::count();
                }),
                'today' => Cache::remember('stats.topics.today', config('webdiscuss.stats.cache_ttl'), function () {
                    return Topic::whereDate('created_at', Carbon::today())->count();
                }),
                'views' => Cache::remember('stats.topics.views', config('webdiscuss.stats.cache_ttl'), function () {
                    return ViewTracker::getViewsCountByType(Topic::class);
                })
            ],
            'replies' => [
                'total' => Cache::remember('stats.replies.total', config('webdiscuss.stats.cache_ttl'), function () {
                    return Reply::count();
                }),
                'today' => Cache::remember('stats.replies.today', config('webdiscuss.stats.cache_ttl'), function () {
                    return Reply::whereDate('created_at', Carbon::today())->count();
                })
            ],
            'users' => [
                'total' => Cache::remember('stats.users.total', config('webdiscuss.stats.cache_ttl'), function () {
                    return User::count();
                }),
                'average_age' => Cache::remember('stats.users.average_age', config('webdiscuss.stats.cache_ttl'), function () {
                    return round(User::selectRaw("TIMESTAMPDIFF(YEAR, DATE(date_of_birth), current_date) AS age")->get()->avg('age'));
                }),
                'last_registered' => Cache::remember('stats.users.last_registered', config('webdiscuss.stats.cache_ttl'), function () {
                    return User::latest()->first();
                }),
                'last_logged_in' => Cache::remember('stats.users.last_logged_in', config('webdiscuss.stats.cache_ttl'), function () {
                    return User::latest('last_logged_in')->first();
                })
            ],
            'most_replies' => Cache::remember('stats.most_replies', config('webdiscuss.stats.cache_ttl'), function () {
                $replies = Reply::select('created_at')->get()
                    ->groupBy(function ($row) {
                        return Carbon::parse($row->created_at)->format('d-m-Y');
                    })->sort();

                return [
                    'date' => $replies->keys()->last(),
                    'total' => $replies->last()->count()
                ];
            })
        ];

        $popularTopics = Cache::remember('stats.popular_topics', config('webdiscuss.stats.cache_ttl'), function () {
            return Topic::withCount('replies')->limit(config('webdiscuss.stats.popular_posts_limit'))->latest('replies_count')->get();
        });

        $latestTopics = Cache::remember('stats.latest_topics', config('webdiscuss.stats.cache_ttl'), function () {
            return Topic::limit(config('webdiscuss.stats.latest_posts_limit'))->latest()->get();
        });

        $view->with([
            'stats' => $stats,
            'popularTopics' => $popularTopics,
            'latestTopics' => $latestTopics
        ]);
    }
}