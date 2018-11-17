<?php

namespace App\Providers;

use App\Topic;
use App\Channel;
use App\Observers\TopicObserver;
use App\Observers\ChannelObserver;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (!Collection::hasMacro('paginate')) {
            Collection::macro('paginate', function ($perPage = 15, $page = null, $options = []) {
                $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);

                return (new LengthAwarePaginator($this->forPage($page, $perPage), $this->count(), $perPage, $page, $options))
                    ->withPath('');
            });
        }

        Topic::observe(TopicObserver::class);
        Channel::observe(ChannelObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}