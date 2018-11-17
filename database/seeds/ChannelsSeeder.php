<?php

use App\Channel;
use Illuminate\Database\Seeder;
use Faker\Factory as FakerFactory;

class ChannelsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = resolve(FakerFactory::class);

        for ($i = 0; $i < 10; $i++) {
            Channel::create([
                'category_id' => $faker->numberBetween(1, 7),
                'name' => rtrim(ucfirst($faker->unique()->sentence($faker->numberBetween(2, 3))), '.'),
                'description' => $faker->sentence
            ]);
        }
    }
}