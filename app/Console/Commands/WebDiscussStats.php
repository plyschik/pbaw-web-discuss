<?php

namespace App\Console\Commands;

use App\User;
use App\Topic;
use App\Reply;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

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
            'topics_count' => function () {
                return Topic::count();
            },
            'posts_count' => function () {
                return Reply::count();
            },
            'users_count' => function () {
                return User::count();
            },
            'latest_user' => function () {
                return User::latest()->first();
            }
        ];

        foreach ($stats as $key => $value) {
            Cache::forget($key);
            Cache::rememberForever($key, $value);
        }
    }
}