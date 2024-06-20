<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
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
            'cottageId' => $this->cottage_id,
            'cottageDescription' => $this->cottage->description,
            'customerProfileId' => $this->customer_profile_id,
            'start' => $this->start,
            'end' => $this->end,
            'mainPlaces' => $this->main_places,
            'additionalPlaces' => $this->additional_places,
            'childrenPlaces' => $this->children_places,
            'amount' => $this->amount,
            'contractNumber' => $this->contract_number,
            'payBefore' => $this->pay_before,
            'status' => $this->status->status(),
            'nights' => Carbon::parse($this->start)->diffInDays($this->end)
        ];
    }
}
