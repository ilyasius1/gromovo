<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ServiceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $services = [];
        foreach ($this->collection->unique('service_category_id') as $service) {
            $serviceCategory = [
                'id' => $this->when($request->user() && $request->user()->isAdmin, $service->service_category_id),
                'serviceName' => $service->categoryName
            ];
            $servicesCollection = $this->collection->filter(
                fn($item) => $item->service_category_id === $service['service_category_id']
            );
            foreach ($servicesCollection as $item) {
                $serviceCategory ['prices'][] = new ServiceResource($item);
            }
            $services [] = $serviceCategory;
        }
        return $services;
    }
}
