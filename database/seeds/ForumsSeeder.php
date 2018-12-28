<?php

use App\Forum;
use Illuminate\Database\Seeder;
use Faker\Factory as FakerFactory;

class ForumsSeeder extends Seeder
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
            Forum::create([
                'category_id' => $faker->numberBetween(1, 7),
                'name' => rtrim(ucfirst($faker->unique()->sentence($faker->numberBetween(2, 3))), '.'),
                'description' => $faker->sentence
            ]);
        }
    }
}