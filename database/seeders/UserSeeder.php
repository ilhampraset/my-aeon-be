<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {
            $first_name =  $faker->firstName;
            $last_name = $faker->lastName;
            User::create([
                'first_name' => $first_name,
                'last_name' => $last_name,
                'email' => $faker->unique()->safeEmail,
                'profile_picture' => "https://ui-avatars.com/api/?name=$first_name+$last_name",
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
            ]);
        }
    }
}
