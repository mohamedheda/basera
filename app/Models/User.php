<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Tymon\JWTAuth\Facades\JWTAuth;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'date_of_birth' => 'date',
            'annual_income' => 'decimal:2',
            'total_savings' => 'decimal:2',
            'profile_completed' => 'boolean',
            'otp_verified' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function username()
    {
        return 'phone';
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function token()
    {
        return JWTAuth::fromUser($this);
    }

    public function otp()
    {
        return $this->hasOne(Otp::class);
    }

    public function otps()
    {
        return $this->hasMany(Otp::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(UserSubscription::class);
    }

    public function activeSubscription()
    {
        return $this->hasOne(UserSubscription::class)->where('status', 'active')
            ->where('end_date', '>=', now());
    }

    public function riskAssessment()
    {
        return $this->hasOne(RiskAssessment::class);
    }

    public function registrationAnswers()
    {
        return $this->hasMany(UserRegistrationAnswer::class);
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }
}
