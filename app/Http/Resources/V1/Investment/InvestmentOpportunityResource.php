<?php

namespace App\Http\Resources\V1\Investment;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvestmentOpportunityResource extends JsonResource
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
            'company_name' => $this->company_name,
            'description' => $this->description,
            'current_price' => $this->current_price,
            'entry_price' => $this->entry_price,
            'expected_return_percentage' => $this->expected_return_percentage,
            'market' => $this->market,
            'is_american' => $this->market === 'american',
            'is_halal' => $this->is_halal,
            'market_name' => $this->market_name,
            'sector' => $this->sector,
            'sector_name' => $this->sector_name,
            'image' => $this->image,
        ];
    }
}
