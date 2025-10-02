<?php

namespace App\Http\Controllers\Api\V1\Risk;

use App\Http\Controllers\Controller;
use App\Models\RiskAssessment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RiskAssessmentController extends Controller
{
    /**
     * Get user's risk assessment
     */
    public function show(Request $request)
    {
        try {
            $user = $request->user();
            $riskAssessment = $user->riskAssessment;

            if (!$riskAssessment) {
                return response()->json([
                    'success' => false,
                    'message' => 'Risk assessment not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $riskAssessment
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch risk assessment',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Create or update risk assessment
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'has_investment_experience' => 'required|boolean',
            'willing_to_risk_capital' => 'required|boolean',
            'has_stable_income' => 'required|boolean',
            'plans_short_term_withdrawal' => 'required|boolean',
            'prefers_high_risk_high_return' => 'required|boolean',
            'consults_financial_advisor' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $user = $request->user();

            // Check if user already has a risk assessment
            $riskAssessment = $user->riskAssessment;

            if ($riskAssessment) {
                // Update existing assessment
                $riskAssessment->update([
                    'has_investment_experience' => $request->has_investment_experience,
                    'willing_to_risk_capital' => $request->willing_to_risk_capital,
                    'has_stable_income' => $request->has_stable_income,
                    'plans_short_term_withdrawal' => $request->plans_short_term_withdrawal,
                    'prefers_high_risk_high_return' => $request->prefers_high_risk_high_return,
                    'consults_financial_advisor' => $request->consults_financial_advisor,
                ]);
            } else {
                // Create new assessment
                $riskAssessment = RiskAssessment::create([
                    'user_id' => $user->id,
                    'has_investment_experience' => $request->has_investment_experience,
                    'willing_to_risk_capital' => $request->willing_to_risk_capital,
                    'has_stable_income' => $request->has_stable_income,
                    'plans_short_term_withdrawal' => $request->plans_short_term_withdrawal,
                    'prefers_high_risk_high_return' => $request->prefers_high_risk_high_return,
                    'consults_financial_advisor' => $request->consults_financial_advisor,
                ]);
            }

            // Calculate risk score
            $riskAssessment->calculateRiskScore()->save();

            return response()->json([
                'success' => true,
                'message' => 'Risk assessment saved successfully',
                'data' => $riskAssessment
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to save risk assessment',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get risk assessment questions
     */
    public function questions()
    {
        try {
            $questions = [
                [
                    'id' => 'has_investment_experience',
                    'question' => 'هل لديك خبرة سابقة في الاستثمار بالأسهم؟',
                    'type' => 'boolean'
                ],
                [
                    'id' => 'willing_to_risk_capital',
                    'question' => 'هل أنت مستعد للمخاطرة بخسارة جزء من رأس مالك؟',
                    'type' => 'boolean'
                ],
                [
                    'id' => 'has_stable_income',
                    'question' => 'هل لديك مصدر دخل ثابت لتغطية نفقاتك الأساسية؟',
                    'type' => 'boolean'
                ],
                [
                    'id' => 'plans_short_term_withdrawal',
                    'question' => 'هل تخطط لسحب أموالك المستثمرة في غضون 1-3 سنوات؟',
                    'type' => 'boolean'
                ],
                [
                    'id' => 'prefers_high_risk_high_return',
                    'question' => 'هل تفضل الاستثمارات ذات العوائد المرتفعة والمخاطر العالية؟',
                    'type' => 'boolean'
                ],
                [
                    'id' => 'consults_financial_advisor',
                    'question' => 'هل تستشير مستشاراً مالياً قبل اتخاذ قرارات الاستثمار؟',
                    'type' => 'boolean'
                ]
            ];

            return response()->json([
                'success' => true,
                'data' => $questions
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch questions',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get risk profile explanation
     */
    public function profileExplanation(Request $request)
    {
        try {
            $user = $request->user();
            $riskAssessment = $user->riskAssessment;

            if (!$riskAssessment) {
                return response()->json([
                    'success' => false,
                    'message' => 'Risk assessment not found'
                ], 404);
            }

            $explanations = [
                'conservative' => [
                    'title' => 'محافظ',
                    'description' => 'أنت مستثمر محافظ يفضل الاستثمارات الآمنة مع عوائد مستقرة ومخاطر منخفضة.',
                    'characteristics' => [
                        'تفضل الاستثمارات الآمنة',
                        'تتحمل مخاطر منخفضة',
                        'تسعى لعوائد مستقرة',
                        'تركز على الحفاظ على رأس المال'
                    ],
                    'recommended_investments' => [
                        'الودائع المصرفية',
                        'السندات الحكومية',
                        'صناديق الاستثمار المحافظة',
                        'الاستثمارات العقارية الآمنة'
                    ]
                ],
                'moderate' => [
                    'title' => 'متوسط',
                    'description' => 'أنت مستثمر متوازن تتحمل مستوى متوسط من المخاطر للحصول على عوائد أفضل.',
                    'characteristics' => [
                        'توازن بين المخاطر والعوائد',
                        'تتحمل مخاطر متوسطة',
                        'تسعى لعوائد جيدة',
                        'مرونة في استراتيجية الاستثمار'
                    ],
                    'recommended_investments' => [
                        'مزيج من الأسهم والسندات',
                        'صناديق الاستثمار المتوازنة',
                        'الاستثمارات العقارية',
                        'السلع الأساسية'
                    ]
                ],
                'aggressive' => [
                    'title' => 'مخاطر عالية',
                    'description' => 'أنت مستثمر جريء تتحمل مخاطر عالية للحصول على عوائد مرتفعة.',
                    'characteristics' => [
                        'تتحمل مخاطر عالية',
                        'تسعى لعوائد مرتفعة',
                        'لديك خبرة في الاستثمار',
                        'تستطيع تحمل تقلبات السوق'
                    ],
                    'recommended_investments' => [
                        'الأسهم النامية',
                        'صناديق الاستثمار عالية المخاطر',
                        'الاستثمارات الناشئة',
                        'العملات الرقمية'
                    ]
                ]
            ];

            $profile = $riskAssessment->risk_profile;
            $explanation = $explanations[$profile] ?? null;

            if (!$explanation) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid risk profile'
                ], 400);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'risk_assessment' => $riskAssessment,
                    'explanation' => $explanation
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch profile explanation',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
