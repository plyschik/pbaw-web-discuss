<?php

use App\User;
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

            $category = Category::create([
                'name' => $name,
            ]);

            for ($j = 0; $j < 2; $j++) {
                $user = User::find($faker->numberBetween(3, 30));
                $user->categories()->attach($category);
            }
        }
    }
}