<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CottageResource;
use App\Models\Cottage;
use App\QueryBuilders\CottagesQueryBuilder;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CottageController extends Controller
{
    public function __construct(protected CottagesQueryBuilder $cottagesQueryBuilder)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $cottages = $this->cottagesQueryBuilder->getActive();
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

    public function getFree(Request $request): AnonymousResourceCollection
    {
        $validator = Validator::make($request->all(), [
            'cottage_type' => 'sometimes|numeric|exists:App\Models\Cottage,id',
            'start' => 'nullable|date|required_with:end',
            'end' => 'nullable|date|after:start|required_with:start',
        ]);
        $valid = $validator->valid();
        if (!array_key_exists('start', $valid) && array_key_exists('end', $valid)) {
            unset($valid['end']);
        }
        if (!array_key_exists('end', $valid) && array_key_exists('start', $valid)) {
            unset($valid['start']);
        }
        $cottages = $this->cottagesQueryBuilder->getFree($valid);
        return CottageResource::collection($cottages);
    }

}
