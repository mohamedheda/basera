<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RiskAssessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'has_investment_experience',
        'willing_to_risk_capital',
        'has_stable_income',
        'plans_short_term_withdrawal',
        'prefers_high_risk_high_return',
        'consults_financial_advisor',
        'risk_score',
        'risk_profile',
    ];

    protected function casts(): array
    {
        return [
            'has_investment_experience' => 'boolean',
            'willing_to_risk_capital' => 'boolean',
            'has_stable_income' => 'boolean',
            'plans_short_term_withdrawal' => 'boolean',
            'prefers_high_risk_high_return' => 'boolean',
            'consults_financial_advisor' => 'boolean',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function calculateRiskScore()
    {
        $score = 0;

        // Add points for each "yes" answer that indicates higher risk tolerance
        if ($this->has_investment_experience) $score += 2;
        if ($this->willing_to_risk_capital) $score += 3;
        if ($this->has_stable_income) $score -= 1; // Stable income reduces risk
        if ($this->plans_short_term_withdrawal) $score += 2;
        if ($this->prefers_high_risk_high_return) $score += 3;
        if ($this->consults_financial_advisor) $score -= 1; // Consulting advisor reduces risk

        // Determine risk profile based on score
        if ($score <= 2) {
            $this->risk_profile = 'conservative';
        } elseif ($score <= 5) {
            $this->risk_profile = 'moderate';
        } else {
            $this->risk_profile = 'aggressive';
        }

        $this->risk_score = max(0, min(10, $score));
        return $this;
    }

    public function getRiskProfileNameAttribute()
    {
        return match ($this->risk_profile) {
            'conservative' => 'محافظ',
            'moderate' => 'متوسط',
            'aggressive' => 'مخاطر عالية',
            default => $this->risk_profile
        };
    }
}
