<?php

use App\Category;
use Illuminate\Database\Seeder;
use Faker\Factory as FakerFactory;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = resolve(FakerFactory::class);

        for ($i = 0; $i < 8; $i++) {
            $name = rtrim(ucfirst($faker->unique()->sentence($faker->numberBetween(1, 2))), '.');

            Category::create([
                'slug' => str_slug($name),
                'name' => $name,
            ]);
        }
    }
}

