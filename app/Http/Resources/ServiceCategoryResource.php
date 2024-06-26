<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceCategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $services = ServiceResource::collection($this->services);
        return [
            'id' => $this->id,
            'serviceName' => $this->name,
            'prices' => $services,
        ];
    }
}
