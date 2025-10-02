<?php

namespace App\Http\Controllers\Api\V1\Investment;

use App\Http\Controllers\Controller;
use App\Models\InvestmentOpportunity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InvestmentController extends Controller
{
    /**
     * Get all investment opportunities
     */
    public function index(Request $request)
    {
        try {
            $opportunities = InvestmentOpportunity::where('is_active', true)
                ->when($request->market, function ($query, $market) {
                    return $query->where('market', $market);
                })
                ->when($request->sector, function ($query, $sector) {
                    return $query->where('sector', $sector);
                })
                ->when($request->risk_level, function ($query, $riskLevel) {
                    return $query->where('risk_level', $riskLevel);
                })
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            return response()->json([
                'success' => true,
                'data' => $opportunities
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch investment opportunities',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get investment opportunity details
     */
    public function show($id)
    {
        try {
            $opportunity = InvestmentOpportunity::where('id', $id)
                ->where('is_active', true)
                ->first();

            if (!$opportunity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Investment opportunity not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $opportunity
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch investment opportunity',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get investment opportunities by user's risk profile
     */
    public function getRecommendations(Request $request)
    {
        try {
            $user = $request->user();
            $riskAssessment = $user->riskAssessment;

            if (!$riskAssessment) {
                return response()->json([
                    'success' => false,
                    'message' => 'Risk assessment not found. Please complete your profile first.'
                ], 400);
            }

            $query = InvestmentOpportunity::where('is_active', true);

            // Filter based on risk profile
            switch ($riskAssessment->risk_profile) {
                case 'conservative':
                    $query->where('risk_level', 'low');
                    break;
                case 'moderate':
                    $query->whereIn('risk_level', ['low', 'medium']);
                    break;
                case 'aggressive':
                    // Show all risk levels for aggressive investors
                    break;
            }

            $opportunities = $query->orderBy('expected_return_percentage', 'desc')
                ->limit(5)
                ->get();

            return response()->json([
                'success' => true,
                'data' => [
                    'risk_profile' => $riskAssessment->risk_profile,
                    'risk_score' => $riskAssessment->risk_score,
                    'opportunities' => $opportunities
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch recommendations',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Search investment opportunities
     */
    public function search(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'query' => 'required|string|min:2|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $query = $request->query;

            $opportunities = InvestmentOpportunity::where('is_active', true)
                ->where(function ($q) use ($query) {
                    $q->where('company_name', 'LIKE', "%{$query}%")
                        ->orWhere('description', 'LIKE', "%{$query}%")
                        ->orWhere('sector', 'LIKE', "%{$query}%");
                })
                ->orderBy('expected_return_percentage', 'desc')
                ->paginate(10);

            return response()->json([
                'success' => true,
                'data' => $opportunities
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Search failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get investment statistics
     */
    public function statistics()
    {
        try {
            $stats = [
                'total_opportunities' => InvestmentOpportunity::where('is_active', true)->count(),
                'average_return' => InvestmentOpportunity::where('is_active', true)->avg('expected_return_percentage'),
                'markets' => InvestmentOpportunity::where('is_active', true)
                    ->selectRaw('market, COUNT(*) as count')
                    ->groupBy('market')
                    ->get(),
                'sectors' => InvestmentOpportunity::where('is_active', true)
                    ->selectRaw('sector, COUNT(*) as count')
                    ->groupBy('sector')
                    ->get(),
                'risk_levels' => InvestmentOpportunity::where('is_active', true)
                    ->selectRaw('risk_level, COUNT(*) as count')
                    ->groupBy('risk_level')
                    ->get(),
            ];

            return response()->json([
                'success' => true,
                'data' => $stats
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch statistics',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
