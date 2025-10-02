<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InvestmentOpportunity extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'description',
        'current_price',
        'entry_price',
        'expected_return_percentage',
        'market',
        'sector',
        'is_halal',
        'risk_level',
        'is_active',
        'image',
    ];

    protected function casts(): array
    {
        return [
            'current_price' => 'decimal:2',
            'entry_price' => 'decimal:2',
            'expected_return_percentage' => 'decimal:2',
            'is_halal' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function getMarketNameAttribute()
    {
        return match ($this->market) {
            'saudi' => 'السوق السعودي',
            'american' => 'السوق الأمريكي',
            'global' => 'السوق العالمي',
            default => $this->market
        };
    }

    public function getSectorNameAttribute()
    {
        return match ($this->sector) {
            'energy' => 'الطاقة',
            'banking' => 'المصرفية',
            'technology' => 'التكنولوجيا',
            'healthcare' => 'الرعاية الصحية',
            'real_estate' => 'العقارات',
            default => $this->sector
        };
    }
}
