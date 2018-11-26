<?php

namespace App\Console\Commands;

use App\User;
use App\Topic;
use App\Reply;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use CyrildeWit\EloquentViewable\ViewTracker;

class WebDiscussStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'webdiscuss:stats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'WebDiscuss stats cache refresh.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $stats = [
            'stats.topics.total' => function () {
                return Topic::count();
            },
            'stats.topics.today' => function () {
                return Topic::whereDate('created_at', Carbon::today())->count();
            },
            'stats.topics.views' => function () {
                return ViewTracker::getViewsCountByType(Topic::class);
            },
            'stats.replies.total' => function () {
                return Reply::count();
            },
            'stats.replies.today' => function () {
                return Reply::whereDate('created_at', Carbon::today())->count();
            },
            'stats.users.total' => function () {
                return User::count();
            },
            'stats.users.average_age' => function () {
                return round(User::selectRaw("TIMESTAMPDIFF(YEAR, DATE(date_of_birth), current_date) AS age")->get()->avg('age'));
            },
            'stats.users.last_registered' => function () {
                return User::latest()->first();
            },
            'stats.users.last_logged_in' => function () {
                return User::latest('last_logged_in')->first();
            },
            'stats.most_replies' => function () {
                $replies = Reply::select('created_at')->get()
                    ->groupBy(function ($row) {
                        return Carbon::parse($row->created_at)->format('d-m-Y');
                    })->sort();

                return [
                    'date' => $replies->keys()->last(),
                    'total' => $replies->last()->count()
                ];
            },
            'stats.popular_topics' => function () {
                return Topic::withCount('replies')->limit(config('webdiscuss.stats.popular_posts_limit'))->latest('replies_count')->get();
            },
            'stats.latest_topics' => function () {
                return Topic::limit(config('webdiscuss.stats.latest_posts_limit'))->latest()->get();
            }
        ];

        foreach ($stats as $key => $value) {
            Cache::forget($key);
            Cache::rememberForever($key, $value);
        }
    }
}