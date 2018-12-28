<?php

namespace App\Providers;

use App\User;
use App\Topic;
use App\Reply;
use App\Forum;
use App\Category;
use App\Policies\UserPolicy;
use App\Policies\ReplyPolicy;
use App\Policies\TopicPolicy;
use App\Policies\ForumPolicy;
use App\Policies\CategoryPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Category::class => CategoryPolicy::class,
        Forum::class => ForumPolicy::class,
        User::class => UserPolicy::class,
        Topic::class => TopicPolicy::class,
        Reply::class => ReplyPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}