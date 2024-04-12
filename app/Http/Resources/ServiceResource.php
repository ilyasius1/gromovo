<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->when($request->user() && $request->user()->isAdmin, $this->id),
            'name' => $this->name,
            'serviceCategoryId' => $this->when($request->user() && $request->user()->isAdmin, $this->service_category_id),
            'attention' => $this->attention,
            'price' => $this->price,
            'pricePerHour' => $this->price_per_hour,
            'pricePerDay' => $this->price_per_day
        ];
    }
}
