<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = [
            [
                'slug' => 'about-us',
                'title_ar' => 'من نحن',
                'title_en' => 'About Us',
                'description_ar' => 'نحن منصة استثمارية رائدة نوفر أفضل الفرص الاستثمارية للمستثمرين في المملكة. نهدف إلى تمكين المستثمرين من اتخاذ قرارات مالية مدروسة من خلال توفير معلومات شاملة وتحليلات دقيقة.',
                'description_en' => 'We are a leading investment platform providing the best investment opportunities for investors in the Kingdom. We aim to empower investors to make informed financial decisions by providing comprehensive information and accurate analysis.',
                'is_active' => true,
            ],
            [
                'slug' => 'terms-and-conditions',
                'title_ar' => 'الشروط والأحكام',
                'title_en' => 'Terms and Conditions',
                'description_ar' => 'باستخدام منصتنا، فإنك توافق على الالتزام بهذه الشروط والأحكام. يرجى قراءة هذه الشروط بعناية قبل استخدام خدماتنا. نحن نحتفظ بالحق في تعديل هذه الشروط في أي وقت.',
                'description_en' => 'By using our platform, you agree to comply with these terms and conditions. Please read these terms carefully before using our services. We reserve the right to modify these terms at any time.',
                'is_active' => true,
            ],
        ];

        foreach ($pages as $page) {
            Page::updateOrCreate(
                ['slug' => $page['slug']],
                $page
            );
        }
    }
}
