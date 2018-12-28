<?php

use App\Reply;
use App\Topic;
use Illuminate\Database\Seeder;
use Faker\Factory as FakerFactory;

class TopicsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = resolve(FakerFactory::class);

        for ($i = 0; $i < 30; $i++) {
            $randomDateTime = $faker->dateTimeBetween('-30 days', '-10 days', 'Europe/Warsaw');

            $topic = Topic::create([
                'user_id' => $faker->numberBetween(1, 3),
                'forum_id' => $faker->numberBetween(1, 10),
                'title' => rtrim($faker->unique()->sentence(), '.'),
                'created_at' => $randomDateTime,
                'updated_at' => $randomDateTime
            ]);

            Reply::create([
                'user_id' => $topic->user_id,
                'topic_id' => $topic->id,
                'content' => $faker->text($faker->numberBetween(200, 500)),
                'is_topic' => 1,
                'created_at' => $topic->created_at,
                'updated_at' => $topic->updated_at
            ]);
        }
    }
}
