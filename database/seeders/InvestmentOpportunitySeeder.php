<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\InvestmentOpportunity;

class InvestmentOpportunitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $opportunities = [
            [
                'company_name' => 'شركة أرامكو السعودية',
                'description' => 'فرصة استثمارية واعدة في أسهم شركة أرامكو السعودية، الرائدة عالمياً في مجال الطاقة. تتميز الشركة بمركز مالي قوي، سجل نمو ثابت وتوقعات إيجابية للقطاع. هذه الفرصة تهدف إلى تحقيق عوائد رأسمالية جيدة بالإضافة إلى توزيعات أرباح منتظمة للمستثمرين على المدى المتوسط إلى الطويل.',
                'current_price' => 35.50,
                'entry_price' => 34.00,
                'expected_return_percentage' => 12.5,
                'market' => 'saudi',
                'sector' => 'energy',
                'is_halal' => true,
                'risk_level' => 'medium',
                'is_active' => true,
            ],
            [
                'company_name' => 'آبل إنك',
                'description' => 'استثمار في شركة آبل، إحدى أكبر شركات التكنولوجيا في العالم. تتميز الشركة بمنتجاتها المبتكرة وخدماتها المتنوعة، مع نمو مستمر في الإيرادات والأرباح.',
                'current_price' => 175.20,
                'entry_price' => 170.00,
                'expected_return_percentage' => 8.7,
                'market' => 'american',
                'sector' => 'technology',
                'is_halal' => false,
                'risk_level' => 'low',
                'is_active' => true,
            ],
            [
                'company_name' => 'بنك الراجحي',
                'description' => 'استثمار في بنك الراجحي، أحد أكبر البنوك الإسلامية في العالم. يتميز البنك بقوة مالية عالية ونمو مستمر في الخدمات المصرفية الإسلامية.',
                'current_price' => 72.80,
                'entry_price' => 71.00,
                'expected_return_percentage' => 12.1,
                'market' => 'saudi',
                'sector' => 'banking',
                'is_halal' => true,
                'risk_level' => 'low',
                'is_active' => true,
            ],
            [
                'company_name' => 'شركة سابك',
                'description' => 'استثمار في شركة سابك، إحدى أكبر شركات البتروكيماويات في العالم. تتميز الشركة بتنوع منتجاتها وقوة في السوق العالمي.',
                'current_price' => 95.40,
                'entry_price' => 92.00,
                'expected_return_percentage' => 15.8,
                'market' => 'saudi',
                'sector' => 'energy',
                'is_halal' => true,
                'risk_level' => 'medium',
                'is_active' => true,
            ],
            [
                'company_name' => 'تسلا',
                'description' => 'استثمار في شركة تسلا، الرائدة في صناعة السيارات الكهربائية وتقنيات الطاقة النظيفة. تتميز الشركة بالابتكار والنمو السريع.',
                'current_price' => 245.80,
                'entry_price' => 240.00,
                'expected_return_percentage' => 22.5,
                'market' => 'american',
                'sector' => 'technology',
                'is_halal' => false,
                'risk_level' => 'high',
                'is_active' => true,
            ],
        ];

        foreach ($opportunities as $opportunity) {
            InvestmentOpportunity::create($opportunity);
        }
    }
}
