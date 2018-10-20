<?php

use App\Channel;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ChannelsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        for ($i = 0; $i < 10; $i++) {
            Channel::create([
                'name' => $faker->unique()->word
            ]);
        }
    }
}

