<?php

namespace App\Http\Resources\V1\Subscription;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionPackageResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'duration_type' => $this->duration_type,
            'duration_months' => $this->duration_months,
            'duration_name' => $this->duration_name,
            'price' => $this->price,
            'formatted_price' => $this->formatted_price,
            'currency' => $this->currency,
            'is_popular' => $this->is_popular,
            'features' => $this->features,
        ];
    }
}
