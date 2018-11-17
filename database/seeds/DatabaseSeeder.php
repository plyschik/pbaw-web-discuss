<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if (App::environment('production')) {
            $this->call(RolesAndPermissionsSeeder::class);
        } else {
            $this->call([
                RolesAndPermissionsSeeder::class,
                UsersSeeder::class,
                CategoriesSeeder::class,
                ChannelsSeeder::class,
                TopicsSeeder::class,
                RepliesSeeder::class,
                ReportsSeeder::class
            ]);
        }
    }
}
