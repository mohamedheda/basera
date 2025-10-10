<?php

namespace Database\Seeders;

use App\Models\Manager;
use Illuminate\Database\Seeder;

class ManagerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $manager = Manager::query()->create([
            'name' => 'Admin',
            'email' => 'admin@basierah.com',
            'phone' => '+96650000000',
            'password' => 'basierah@123',
        ]);
        $manager->addRole(1);
    }
}
