<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGalleryRequest;
use App\Http\Requests\UpdateGalleryRequest;
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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGalleryRequest $request)
    {
        //
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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Gallery $gallery)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGalleryRequest $request, Gallery $gallery)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     */
    public function destroy(Gallery $gallery)
    {
        //
    }
}
