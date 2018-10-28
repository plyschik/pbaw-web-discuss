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
            for ($j = 1; $j <= $faker->numberBetween(2, 12); $j++) {
                $randomDateTime = $faker->dateTimeBetween('-30 days', 'now', 'Europe/Warsaw');

                $reply = Reply::create([
                    'user_id' => $faker->numberBetween(1, 3),
                    'topic_id' => $i,
                    'parent_id' => null,
                    'content' => $faker->realText(),
                    'created_at' => $randomDateTime,
                    'updated_at' => $randomDateTime
                ]);

                if ($faker->boolean(50)) {
                    for ($k = 1; $k <= $faker->numberBetween(1, 3); $k++) {
                        Reply::create([
                            'user_id' => $faker->numberBetween(1, 3),
                            'topic_id' => $i,
                            'parent_id' => $reply->id,
                            'content' => $faker->realText(),
                            'created_at' => $randomDateTime,
                            'updated_at' => $randomDateTime
                        ]);
                    }
                }
            }
        }
    }
}
