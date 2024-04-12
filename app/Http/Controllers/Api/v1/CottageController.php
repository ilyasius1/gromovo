<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
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
     * Display the specified resource.
     *
     * @param Cottage $cottage
     * @return CottageResource
     */
    public function show(Cottage $cottage): CottageResource
    {
        return new CottageResource($cottage);
    }

}
