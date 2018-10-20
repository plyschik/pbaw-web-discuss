<?php

use App\Topic;
use Illuminate\Database\Seeder;

class TopicsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Topic::create([
            'user_id' => 1,
            'title' => 'User topic',
            'content' => 'User topic content.'
        ]);

        Topic::create([
            'user_id' => 2,
            'title' => 'Moderator topic',
            'content' => 'Moderator topic content.'
        ]);

        Topic::create([
            'user_id' => 3,
            'title' => 'Administrator topic',
            'content' => 'Administrator topic content.'
        ]);
    }
}
