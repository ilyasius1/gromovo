<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\GalleryResource;
use App\Models\Gallery;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return  AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $galleries = Gallery::all();
        return GalleryResource::collection($galleries);
    }

    /**
     * Display the specified resource.
     *
     * @param Gallery $gallery
     * @return GalleryResource
     */
    public function show(Gallery $gallery): GalleryResource
    {
        return new GalleryResource($gallery);
    }
}
