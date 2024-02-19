<?php

namespace App\Services;

use App\Models\Cottage;
use App\Models\Gallery;
use Illuminate\Support\Str;

class CottageService
{
    /**
     * Creates cottage with galleries
     *
     * @param array $fields
     * @return Cottage
     */
    public function createCottage(array $fields): Cottage
    {
        $cottage = new Cottage($fields);

        $mainGallery = Gallery::create([
            'name' => $cottage->name,
            'name_eng' => Str::slug($cottage->name),
            'description' => "Фотографии коттеджа $cottage->name"
        ]);
        $schemaGallery = Gallery::create([
            'name' => $cottage->name . ' схема',
            'name_eng' => Str::slug($cottage->name . ' схема'),
            'description' => "Схема коттеджа $cottage->name"
        ]);
        $summerGallery = Gallery::create([
            'name' => $cottage->name . ' летом',
            'name_eng' => Str::slug($cottage->name . ' летом'),
            'description' => "Фотографии коттеджа $cottage->name летом"
        ]);
        $winterGallery = Gallery::create([
            'name' => $cottage->name . ' зимой',
            'name_eng' => Str::slug($cottage->name . ' зимой'),
            'description' => "Фотографии коттеджа $cottage->name зимой",
        ]);

        $cottage->mainGallery()->associate($mainGallery);
        $cottage->schemaGallery()->associate($schemaGallery);
        $cottage->summerGallery()->associate($summerGallery);
        $cottage->winterGallery()->associate($winterGallery);
        $cottage->save();

        return $cottage;
    }

    /**
     * Deletes cottage with all galleries,images and attachments
     *
     * @param Cottage $cottage
     * @return void
     */
    public function deleteCottage(Cottage $cottage): void
    {
        $galleries = [
            'mainGallery' => $cottage->mainGallery,
            'schemaGallery' => $cottage->schemaGallery,
            'summerGallery' => $cottage->summerGallery,
            'winterGallery' => $cottage->winterGallery
        ];
        foreach ($galleries as  $gallery) {
            foreach ($gallery->images as $image)
            {
                $image->attachment?->delete();
                $image->delete();
            }
            $gallery->delete();
        }
        $cottage->delete();
    }
}
