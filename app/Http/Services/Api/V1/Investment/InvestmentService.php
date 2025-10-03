<?php

namespace App\Http\Services\Api\V1\Investment;

use App\Models\InvestmentOpportunity;
use App\Models\User;
use Exception;

class InvestmentService
{
    /**
     * Get all investment opportunities with filters
     */
    public function getAllOpportunities(array $filters = [])
    {
        $query = InvestmentOpportunity::where('is_active', true);

        // Apply filters
        if (!empty($filters['market'])) {
            $query->where('market', $filters['market']);
        }

        if (!empty($filters['sector'])) {
            $query->where('sector', $filters['sector']);
        }

        if (!empty($filters['risk_level'])) {
            $query->where('risk_level', $filters['risk_level']);
        }

        if (!empty($filters['is_halal'])) {
            $query->where('is_halal', $filters['is_halal']);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    /**
     * Get single investment opportunity by ID
     */
    public function getOpportunityById(int $id)
    {
        return InvestmentOpportunity::where('id', $id)
            ->where('is_active', true)
            ->first();
    }

    /**
     * Get investment recommendations based on user's risk profile
     */
    public function getRecommendations(User $user, int $limit = 5)
    {
        $riskAssessment = $user->riskAssessment;

        if (!$riskAssessment) {
            throw new Exception('Risk assessment not found. Please complete your profile first.');
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
            ->limit($limit)
            ->get();

        return [
            'risk_profile' => $riskAssessment->risk_profile,
            'risk_score' => $riskAssessment->risk_score,
            'opportunities' => $opportunities
        ];
    }

    /**
     * Search investment opportunities
     */
    public function searchOpportunities(string $searchQuery, int $perPage = 10)
    {
        return InvestmentOpportunity::where('is_active', true)
            ->where(function ($query) use ($searchQuery) {
                $query->where('company_name', 'LIKE', "%{$searchQuery}%")
                    ->orWhere('description', 'LIKE', "%{$searchQuery}%")
                    ->orWhere('sector', 'LIKE', "%{$searchQuery}%");
            })
            ->orderBy('expected_return_percentage', 'desc')
            ->paginate($perPage);
    }

    /**
     * Get investment statistics
     */
    public function getStatistics()
    {
        return [
            'total_opportunities' => InvestmentOpportunity::where('is_active', true)->count(),
            'average_return' => round(InvestmentOpportunity::where('is_active', true)->avg('expected_return_percentage'), 2),
            'halal_count' => InvestmentOpportunity::where('is_active', true)->where('is_halal', true)->count(),
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
    }
}
