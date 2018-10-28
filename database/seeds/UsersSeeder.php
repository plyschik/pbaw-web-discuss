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
            'date_of_birth' => $faker->dateTimeThisCentury,
            'email_verified_at' => now()
        ])->assignRole('user');

        User::create([
            'name' => 'moderator',
            'email' => 'moderator@webdiscuss',
            'password' => bcrypt('password'),
            'date_of_birth' => $faker->dateTimeThisCentury,
            'email_verified_at' => now()
        ])->assignRole('moderator');

        User::create([
            'name' => 'administrator',
            'email' => 'administrator@webdiscuss',
            'password' => bcrypt('password'),
            'date_of_birth' => $faker->dateTimeThisCentury,
            'email_verified_at' => now()
        ])->assignRole('administrator');
    }
}
