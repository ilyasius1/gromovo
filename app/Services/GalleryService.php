<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Gallery;
use App\Models\Image;
use Orchid\Attachment\Models\Attachment;

class GalleryService
{
    /**
     * @param array $fields
     * @return Gallery
     */
    public function createGallery(array $fields): Gallery
    {
        $gallery = Gallery::create($fields['gallery']);
        $this->attachImages($gallery, $fields['images']);
        return $gallery;
    }

    /**
     * @param Gallery $gallery
     * @param array $fields
     * @return void
     */
    public function updateGallery(Gallery $gallery, array $fields): void
    {
        $gallery->update($fields['gallery']);
        if (!empty($fields['images'])) {
            $this->attachImages($gallery, $fields['images']);
        }
    }

    /**
     * @param Gallery $gallery
     * @param array $images
     * @return void
     */
    public function attachImages(Gallery $gallery, array $images): void
    {
        $attachments = Attachment::findMany($images);
        foreach ($images as $attachment_id) {
            $attachment = $attachments->find($attachment_id);
            Image::create([
                'name' => $attachment->original_name,
                'gallery_id' => $gallery->id,
                'attachment_id' => $attachment_id
            ]);
        }
    }

    /**
     * @param Gallery $gallery
     * @return void
     */
    public function deleteGallery(Gallery $gallery): void
    {
        foreach ($gallery->images as $image) {
            $image->attachment?->delete();
            $image->delete();
        }
        $gallery->delete();
    }
}
