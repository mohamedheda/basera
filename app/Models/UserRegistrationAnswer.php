<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserRegistrationAnswer extends Model
{
    protected $fillable = [
        'user_id',
        'question_id',
        'answer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(RegistrationQuestion::class, 'question_id');
    }
}
