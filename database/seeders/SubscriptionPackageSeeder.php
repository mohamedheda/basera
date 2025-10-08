<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SubscriptionPackage;

class SubscriptionPackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $packages = [
            [
                'name' => 'باقة شهرية',
                'description' => 'اشتراك لمدة شهر واحد',
                'duration_type' => 'monthly',
                'duration_months' => 1,
                'price' => 500.00,
                'currency' => 'SAR',
                'is_popular' => false,
                'is_active' => true,
            ],
            [
                'name' => 'باقة نصف سنوية',
                'description' => 'اشتراك لمدة 6 أشهر',
                'duration_type' => 'semi_annual',
                'duration_months' => 6,
                'price' => 2500.00,
                'currency' => 'SAR',
                'is_popular' => true,
                'is_active' => true,
            ],
            [
                'name' => 'باقة سنوية',
                'description' => 'اشتراك لمدة 12 شهر',
                'duration_type' => 'annual',
                'duration_months' => 12,
                'price' => 4800.00,
                'currency' => 'SAR',
                'is_popular' => false,
                'is_active' => true,
            ],
        ];

        foreach ($packages as $package) {
            SubscriptionPackage::create($package);
        }
    }
}
