<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCottageTypeRequest;
use App\Http\Requests\UpdateCottageTypeRequest;
use App\Http\Resources\CottageTypeResource;
use App\Models\CottageType;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CottageTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $cottageTypes = CottageType::all();
        return CottageTypeResource::collection($cottageTypes);
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
    public function store(StoreCottageTypeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param CottageType $cottageType
     * @return CottageTypeResource
     */
    public function show(CottageType $cottageType): CottageTypeResource
    {
        return new CottageTypeResource($cottageType);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CottageType $cottageType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCottageTypeRequest $request, CottageType $cottageType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CottageType $cottageType)
    {
        //
    }
}
