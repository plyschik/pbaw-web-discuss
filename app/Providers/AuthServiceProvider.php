<?php

namespace App\Providers;

use App\User;
use App\Topic;
use App\Reply;
use App\Channel;
use App\Category;
use App\Policies\UserPolicy;
use App\Policies\ReplyPolicy;
use App\Policies\TopicPolicy;
use App\Policies\ChannelPolicy;
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
        Channel::class => ChannelPolicy::class,
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