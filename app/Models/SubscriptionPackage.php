<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubscriptionPackage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'duration_type',
        'duration_months',
        'price',
        'currency',
        'is_popular',
        'is_active',
        'features',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'is_popular' => 'boolean',
            'is_active' => 'boolean',
            'features' => 'array',
        ];
    }

    public function userSubscriptions()
    {
        return $this->hasMany(UserSubscription::class);
    }

    public function getDurationNameAttribute()
    {
        return match ($this->duration_type) {
            'monthly' => 'باقة شهرية',
            'semi_annual' => 'باقة نصف سنوية',
            'annual' => 'باقة سنوية',
            default => $this->duration_type
        };
    }

    public function getFormattedPriceAttribute()
    {
        return number_format($this->price, 0) . ' ' . $this->currency;
    }
}
