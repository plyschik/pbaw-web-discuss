<?php

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
            $randomDateTime = $faker->dateTimeBetween('-30 days', 'now', 'Europe/Warsaw');

            Topic::create([
                'user_id' => $faker->numberBetween(1, 3),
                'channel_id' => $faker->numberBetween(1, 10),
                'title' => rtrim($faker->unique()->sentence(), '.'),
                'content' => $faker->text($faker->numberBetween(200, 500)),
                'created_at' => $randomDateTime,
                'updated_at' => $randomDateTime
            ]);
        }
    }
}
