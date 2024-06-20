<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReservationResource extends JsonResource
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
            'cottage_id' => $this->cottage_id,
            'customer_profile_id' => $this->customer_profile_id,
            'start' => $this->start,
            'end' => $this->end,
            'amount' => $this->amount,
            'contract_number' => $this->contract_number,
            'pay_before' => $this->pay_before,
            'status' => $this->status,
        ];
    }
}
