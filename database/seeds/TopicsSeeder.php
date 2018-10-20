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
            'channel_id' => rand(1,10),
            'title' => 'User topic',
            'content' => 'User topic content.'
        ]);

        Topic::create([
            'user_id' => 2,
            'channel_id' => rand(1,10),
            'title' => 'Moderator topic',
            'content' => 'Moderator topic content.'
        ]);

        Topic::create([
            'user_id' => 3,
            'channel_id' => rand(1,10),
            'title' => 'Administrator topic',
            'content' => 'Administrator topic content.'
        ]);
    }
}
