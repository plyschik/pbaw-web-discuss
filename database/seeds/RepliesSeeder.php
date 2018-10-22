<?php

use App\Reply;
use Illuminate\Database\Seeder;
use Faker\Factory as FakerFactory;

class RepliesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = resolve(FakerFactory::class);

        for ($i = 1; $i <= 30; $i++) {
            for ($j = 1; $j <= mt_rand(2, 12); $j++) {
                $randomDateTime = $faker->dateTimeBetween('-30 days', 'now', 'Europe/Warsaw');

                Reply::create([
                    'user_id' => mt_rand(1, 3),
                    'topic_id' => $i,
                    'content' => $faker->realText(),
                    'created_at' => $randomDateTime,
                    'updated_at' => $randomDateTime
                ]);
            }
        }
    }
}
