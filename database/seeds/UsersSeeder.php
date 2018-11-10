<?php

use App\User;
use Illuminate\Database\Seeder;
use Faker\Factory as FakerFactory;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = resolve(FakerFactory::class);

        User::create([
            'name' => 'user',
            'email' => 'user@webdiscuss',
            'password' => bcrypt('password'),
            'date_of_birth' => $faker->dateTimeBetween('-40 years', '-8 years'),
            'email_verified_at' => now()
        ])->assignRole('user');

        User::create([
            'name' => 'administrator',
            'email' => 'administrator@webdiscuss',
            'password' => bcrypt('password'),
            'date_of_birth' => $faker->dateTimeBetween('-40 years', '-8 years'),
            'email_verified_at' => now()
        ])->assignRole('administrator');

        for ($i = 0; $i < 30; $i++) {
            User::create([
                'name' => $faker->userName,
                'email' => $faker->email,
                'password' => bcrypt('password'),
                'date_of_birth' => $faker->dateTimeBetween('-40 years', '-8 years'),
                'email_verified_at' => now()
            ])->assignRole('user');
        }
    }
}
