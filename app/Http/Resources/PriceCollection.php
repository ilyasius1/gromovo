<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PriceCollection extends ResourceCollection
{
    /**
     * @var string
     */
    public $collects = PriceItemResource::class;

    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $array = [];
        foreach ($this->collection->unique('periodId') as $period) {
            $cottagesCollection = $this->collection->filter(fn($item) => $item->periodId === $period['periodId']);
            $cottages = [];
            foreach ($cottagesCollection->unique('cottageTypeId') as $price) {
                $cottage = [
                    'cottageType' => $price->cottageTypeName,
                ];
                $cottagesByType = $cottagesCollection->filter(fn($item) => $item->cottageTypeId === $price['cottageTypeId']);
                foreach ($cottagesByType as $item) {
                    $cottage ['packages'] = new PriceItemResource($item);
                }
                $cottages[] = $cottage;
            }
            $array [] = [
                'periodName' => $period['periodName'],
                'start' => $period['start'],
                'end' => $period['end'],
                'isHoliday' => $period['is_holiday'],
                'cottages' => $cottages
            ];
        }
        return $array;
    }
}
