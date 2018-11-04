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
            $name = rtrim(ucfirst($faker->unique()->sentence($faker->numberBetween(1, 2))), '.');

            Channel::create([
                'slug' => str_slug($name),
                'name' => $name,
                'description' => $faker->sentence
            ]);
        }
    }
}

