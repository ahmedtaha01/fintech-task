<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();
        $now = now();

        $rows = [];
        for ($i = 0; $i < 10; $i++) {
            $rows[] = [
                'name' => $faker->name(),
                'email' => $faker->unique()->safeEmail(),
                'phone' => $faker->numerify('##########'),
                'password' => Hash::make('password'),
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        User::insert($rows);
    }
}
