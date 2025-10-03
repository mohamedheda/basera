<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RegistrationQuestion extends Model
{
    protected $fillable = [
        'question_text_en',
        'question_text_ar',
        'question_type',
        'options',
        'is_required',
        'is_active',
        'order',
        'validation_rules',
    ];

    protected $casts = [
        'options' => 'array',
        'is_required' => 'boolean',
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    public function answers(): HasMany
    {
        return $this->hasMany(UserRegistrationAnswer::class);
    }

    public function getQuestionTextAttribute(): string
    {
        $locale = app()->getLocale();
        return $locale === 'ar' ? $this->question_text_ar : $this->question_text_en;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }
}
