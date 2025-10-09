<?php

namespace App\Http\Resources\V1\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function __construct($resource, private readonly bool $withToken)
    {
        parent::__construct($resource);
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'national_id' => $this->national_id,
            'date_of_birth' => $this->date_of_birth?->format('Y-m-d'),
            'marital_status' => $this->marital_status,
            'family_members_count' => $this->family_members_count,
            'education_level' => $this->education_level,
            'annual_income' => $this->annual_income,
            'total_savings' => $this->total_savings,
            'bank' => $this->bank?->name,
            'is_active' => $this->is_active,
            'otp_token' => $this->whenNotNull($this->otp?->token),
            'otp_verified' => $this->otp_verified,
            'token' => $this->when($this->withToken, $this->token()),
            'created_at' => $this->created_at?->toDateTimeString(),
            'has_subscription' => $this->activeSubscription?->isActive(),
        ];
    }
}
