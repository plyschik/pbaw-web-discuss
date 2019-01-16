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
        $this->call(RolesAndPermissionsSeeder::class);

        if (App::environment('local')) {
            $this->call([
                UsersSeeder::class,
                CategoriesSeeder::class,
                ForumsSeeder::class,
                TopicsSeeder::class,
                RepliesSeeder::class,
                ReportsSeeder::class
            ]);
        }
    }
}