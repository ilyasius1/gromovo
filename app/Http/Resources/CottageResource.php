<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

class CottageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $images = [];
        $collection = Collection::make($this->mainGallery->images);
        if($collection->isNotEmpty()){
            foreach ($collection as $img) {
                $images []= $img->attachment?->url;
            }
        }
        return [
            'id' => $this->id,
            'name' => $this->name,
            'cottage_type_id' => $this->cottage_type_id,
            'main_gallery_id' => $this->main_gallery_id,
            'schema_gallery_id' => $this->schema_gallery_id,
            'summer_gallery_id' => $this->summer_gallery_id,
            'winter_gallery_id' => $this->winter_gallery_id,
            'area' => $this->area,
            'floors' => $this->floors,
            'bedrooms' => $this->bedrooms,
            'single_beds' => $this->single_beds,
            'double_beds' => $this->double_beds,
            'placement' => [
                'main' => $this->cottageType->main_places,
                'additional' => $this->cottageType->additional_places,
                'children' => $this->cottageType->children_places
            ],
            'additional_single_beds' => $this->additional_single_beds,
            'additional_double_beds' => $this->additional_double_beds,
            'sleeppingBerths' => [
                'main' => [
                    'double' => $this->double_beds,
                    'single' => $this->single_beds,
                ],
                'extra' => [
                    'double' => $this->additional_double_beds,
                    'single' => $this->additional_single_beds,
                ],
            ],
            'bathrooms' => $this->bathrooms,
            'showers' => $this->showers,
            'sauna' => $this->sauna,
            'fireplace' => $this->fireplace,
            'floor1_features' => $this->floor1_features,
            'floor2_features' => $this->floor2_features,
            'floor3_features' => $this->floor3_features,
            'is_active' => $this->is_active,
            'images' => $images
        ];
    }
}
