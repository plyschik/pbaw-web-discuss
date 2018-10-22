<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Faker\Factory as FakerFactory;

class FakerProvider extends ServiceProvider
{
    protected $defer = true;

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(FakerFactory::class, function () {
            $faker = FakerFactory::create();
            $faker->seed(config('app.faker.seed'));

            return $faker;
        });
    }

    public function provides()
    {
        return [FakerFactory::class];
    }
}
