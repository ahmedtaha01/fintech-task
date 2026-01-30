<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccountsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();
        $now = now();

        $users = User::all();
        $rows = [];

        foreach ($users as $user) {
            $rows[] = [
                'user_id' => $user->id,
                'bank_name' => $faker->company(),
                'bank_account_name' => $user->name,
                'bank_account_number' => $faker->bothify('##########'),
                'bank_iban_number' => $faker->iban(),
                'balance' => $faker->randomFloat(2, 0, 10000),
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        if (!empty($rows)) {
            DB::table('accounts')->insert($rows);
        }
    }
}
