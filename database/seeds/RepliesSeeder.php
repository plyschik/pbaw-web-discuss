<?php

use App\Reply;
use Illuminate\Database\Seeder;

class RepliesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        for ($i = 1; $i <= 23; $i++) {
            Reply::create([
                'user_id' => mt_rand(1, 3),
                'topic_id' => $i,
                'content' => $faker->realText(),
            ]);

            Reply::create([
                'user_id' => mt_rand(1, 3),
                'topic_id' => $i,
                'content' => $faker->realText(),
            ]);
        }
    }
}
