<?php

namespace App\Http\Resources\V1\Subscription;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserSubscriptionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'subscription_package_id' => $this->subscription_package_id,
            'start_date' => $this->start_date?->format('Y-m-d'),
            'end_date' => $this->end_date?->format('Y-m-d'),
            'amount_paid' => $this->amount_paid,
            'status' => $this->status,
            'payment_method' => $this->payment_method,
            'transaction_id' => $this->transaction_id,
            'is_active' => $this->isActive(),
            'is_expired' => $this->isExpired(),
            'days_remaining' => $this->end_date ? max(0, now()->diffInDays($this->end_date, false)) : 0,
            'package' => new SubscriptionPackageResource($this->whenLoaded('subscriptionPackage')),
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
