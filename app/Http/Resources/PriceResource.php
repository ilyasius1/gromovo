<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PriceResource extends JsonResource
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
            'cottage_type' => $this->cottageType->name,
            'period' => $this->period->name,
            'package' => $this->package->name,
            'start' => $this->period->start,
            'end' => $this->period->end,
            'days' => $this->package->nights,
            'rate' => $this->rate,
            'daysEnd' => $this->days_end
        ];
    }
}
