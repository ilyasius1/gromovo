<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Cottage;
use App\Models\Gallery;
use Illuminate\Support\Str;

class CottageService
{
    public function __construct(
        protected GalleryService $galleryService
    )
    {
    }

    /**
     * Creates cottage with galleries
     *
     * @param array $fields
     * @return Cottage
     */
    public function createCottage(array $fields): Cottage
    {
        $cottage = new Cottage($fields['cottage']);

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
        if(!empty($fields['images'])){
            $this->fillGalleries($cottage, $fields['images']);
        }
        return $cottage;
    }

    /**
     * Update cottage and it's galleries
     *
     * @param Cottage $cottage
     * @param array $fields
     * @return void
     */
    public function update(Cottage $cottage, array $fields): void
    {
        $cottage->fill($fields['cottage'])->save();
        if(!empty($fields['images'])){
            $this->fillGalleries($cottage, $fields['images']);
        }
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
            $this->galleryService->deleteGallery($gallery);
        }
        $cottage->delete();
    }

    /**
     * Fill galleries with images
     *
     * @param Cottage $cottage
     * @param array $images
     * @return void
     */
    public function fillGalleries(Cottage $cottage, array $images): void
    {
        foreach ($images as $key => $images_group) {
            $galleryField = $key . '_gallery_id';
            $gallery_id = $cottage->$galleryField;
            $this->galleryService->attachImages(
                Gallery::find($gallery_id),
                $images_group
            );
        }
    }
}
