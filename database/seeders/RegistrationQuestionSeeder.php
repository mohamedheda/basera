<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RegistrationQuestion;

class RegistrationQuestionSeeder extends Seeder
{
    public function run(): void
    {
        $questions = [
            [
                'question_text_en' => 'Do you have previous experience in investment of its types?',
                'question_text_ar' => 'هل لديك خبرة سابقة في الاستثمار بأنواعه؟',
                'question_type' => 'radio',
                'options' => [
                    'en' => ['Yes', 'No'],
                    'ar' => ['نعم', 'لا']
                ],
                'is_required' => true,
                'is_active' => true,
                'order' => 1,
                'validation_rules' => 'required|string|in:Yes,No,yes,no,نعم,لا',
            ],
            [
                'question_text_en' => 'Are you willing to risk losing part of your capital?',
                'question_text_ar' => 'هل أنت مستعد للمخاطرة بخسارة جزء من رأس مالك؟',
                'question_type' => 'radio',
                'options' => [
                    'en' => ['Yes', 'No'],
                    'ar' => ['نعم', 'لا']
                ],
                'is_required' => true,
                'is_active' => true,
                'order' => 2,
                'validation_rules' => 'required|string|in:Yes,No,yes,no,نعم,لا',
            ],
            [
                'question_text_en' => 'Do you have a stable source of income to cover your basic expenses?',
                'question_text_ar' => 'هل لديك مصدر دخل ثابت لتغطية نفقاتك الأساسية؟',
                'question_type' => 'radio',
                'options' => [
                    'en' => ['Yes', 'No'],
                    'ar' => ['نعم', 'لا']
                ],
                'is_required' => true,
                'is_active' => true,
                'order' => 3,
                'validation_rules' => 'required|string|in:Yes,No,yes,no,نعم,لا',
            ],
            [
                'question_text_en' => 'Are you planning to withdraw your invested funds within 1-3 years?',
                'question_text_ar' => 'هل تخطط لسحب أموالك المستثمرة في غضون 3-1 سنوات؟',
                'question_type' => 'radio',
                'options' => [
                    'en' => ['Yes', 'No'],
                    'ar' => ['نعم', 'لا']
                ],
                'is_required' => true,
                'is_active' => true,
                'order' => 4,
                'validation_rules' => 'required|string|in:Yes,No,yes,no,نعم,لا',
            ],
            [
                'question_text_en' => 'Do you prefer high-return, high-risk investments?',
                'question_text_ar' => 'هل تفضل الاستثمارات ذات العوائد المرتفعة والمخاطر العالية؟',
                'question_type' => 'radio',
                'options' => [
                    'en' => ['Yes', 'No'],
                    'ar' => ['نعم', 'لا']
                ],
                'is_required' => true,
                'is_active' => true,
                'order' => 5,
                'validation_rules' => 'required|string|in:Yes,No,yes,no,نعم,لا',
            ],
            [
                'question_text_en' => 'Will you consult a financial advisor before making your investment decisions?',
                'question_text_ar' => 'هل ستستثمر مستشاراً مالياً قبل اتخاذ قراراتك الاستثمارية؟',
                'question_type' => 'radio',
                'options' => [
                    'en' => ['Yes', 'No'],
                    'ar' => ['نعم', 'لا']
                ],
                'is_required' => true,
                'is_active' => true,
                'order' => 6,
                'validation_rules' => 'required|string|in:Yes,No,yes,no,نعم,لا',
            ],
        ];

        foreach ($questions as $question) {
            RegistrationQuestion::create($question);
        }
    }
}
