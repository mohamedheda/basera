<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 5; $i++) {
            User::create([
                'name' => "User $i",
                'email' => "user$i@elryad.com",
                'phone' => "96000000" . $i,
                'password' => Hash::make('123123123'),
                'otp_verified' => true,
                'is_active' => true,
                'date_of_birth' => now()->subYears(20)->format('Y-m-d'),
                'marital_status' => 'married',
                'family_members_count' => 1,
                'education_level' => 'bachelor',
                'annual_income' => 10000,
                'total_savings' => 10000,
                'bank_id' => 1,
                'national_id' => "1234567890" . $i,
                'created_at' => now()->subDays($i),
                'updated_at' => now()->subDays($i),
            ]);
        }
    }
}
