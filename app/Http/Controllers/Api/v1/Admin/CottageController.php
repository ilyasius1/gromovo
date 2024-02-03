<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCottageRequest;
use App\Http\Requests\UpdateCottageRequest;
use App\Http\Resources\CottageResource;
use App\Models\Cottage;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CottageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $cottages = Cottage::all();
        return CottageResource::collection($cottages);
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
    public function store(StoreCottageRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Cottage $cottage
     * @return CottageResource
     */
    public function show(Cottage $cottage): CottageResource
    {
        return new CottageResource($cottage);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cottage $cottage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCottageRequest $request, Cottage $cottage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cottage $cottage)
    {
        //
    }
}
