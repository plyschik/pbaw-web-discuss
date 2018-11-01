<?php

use App\Report;
use Illuminate\Database\Seeder;
use Faker\Factory as FakerFactory;

class ReportsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = resolve(FakerFactory::class);

        Report::create([
            'user_id' => $faker->numberBetween(1, 3),
            'reply_id' => 1,
            'reason' => $faker->sentence,
            'created_at' => $datetime = $faker->dateTimeBetween('-7 days', 'now', 'Europe/Warsaw'),
            'updated_at' => $datetime
        ]);

        Report::create([
            'user_id' => $faker->numberBetween(1, 3),
            'reply_id' => 2,
            'reason' => $faker->sentence,
            'created_at' => $datetime = $faker->dateTimeBetween('-7 days', 'now', 'Europe/Warsaw'),
            'updated_at' => $datetime
        ]);

        Report::create([
            'user_id' => $faker->numberBetween(1, 3),
            'reply_id' => 3,
            'reason' => $faker->sentence,
            'created_at' => $datetime = $faker->dateTimeBetween('-7 days', 'now', 'Europe/Warsaw'),
            'updated_at' => $datetime
        ]);
    }
}
