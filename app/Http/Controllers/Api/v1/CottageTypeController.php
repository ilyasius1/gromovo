<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CottageTypeResource;
use App\Models\CottageType;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CottageTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        return CottageTypeResource::collection(CottageType::all());
    }

    /**
     * Display the specified resource.
     */
    public function show(CottageType $cottageType): CottageTypeResource
    {
        return new CottageTypeResource($cottageType);
    }
}
