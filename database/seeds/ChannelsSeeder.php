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
                'name' => ucfirst($faker->unique()->word)
            ]);
        }
    }
}

