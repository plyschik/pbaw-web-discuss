<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
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
