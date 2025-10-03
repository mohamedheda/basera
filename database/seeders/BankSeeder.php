<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Bank;

class BankSeeder extends Seeder
{
    public function run(): void
    {
        $banks = [
            ['name_en' => 'Al Rajhi Bank', 'name_ar' => 'مصرف الراجحي', 'is_active' => true],
            ['name_en' => 'National Commercial Bank (NCB)', 'name_ar' => 'البنك الأهلي التجاري', 'is_active' => true],
            ['name_en' => 'Riyad Bank', 'name_ar' => 'بنك الرياض', 'is_active' => true],
            ['name_en' => 'Saudi British Bank (SABB)', 'name_ar' => 'البنك السعودي البريطاني (ساب)', 'is_active' => true],
            ['name_en' => 'Samba Financial Group', 'name_ar' => 'مجموعة سامبا المالية', 'is_active' => true],
            ['name_en' => 'Saudi Investment Bank', 'name_ar' => 'البنك السعودي للاستثمار', 'is_active' => true],
            ['name_en' => 'Banque Saudi Fransi', 'name_ar' => 'البنك السعودي الفرنسي', 'is_active' => true],
            ['name_en' => 'Arab National Bank', 'name_ar' => 'البنك العربي الوطني', 'is_active' => true],
            ['name_en' => 'Bank AlJazira', 'name_ar' => 'بنك الجزيرة', 'is_active' => true],
            ['name_en' => 'Bank AlBilad', 'name_ar' => 'بنك البلاد', 'is_active' => true],
            ['name_en' => 'Alinma Bank', 'name_ar' => 'مصرف الإنماء', 'is_active' => true],
            ['name_en' => 'National Bank of Kuwait (NBK)', 'name_ar' => 'بنك الكويت الوطني', 'is_active' => true],
            ['name_en' => 'Gulf International Bank', 'name_ar' => 'بنك الخليج الدولي', 'is_active' => true],
            ['name_en' => 'Emirates NBD', 'name_ar' => 'بنك الإمارات دبي الوطني', 'is_active' => true],
            ['name_en' => 'Other', 'name_ar' => 'أخرى', 'is_active' => true],
        ];

        foreach ($banks as $bank) {
            Bank::create($bank);
        }
    }
}
