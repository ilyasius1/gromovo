<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Price\IndexPriceRequest;
use App\Http\Requests\Price\StorePriceRequest;
use App\Http\Requests\Price\UpdatePriceRequest;
use App\Http\Resources\PriceCollection;
use App\Http\Resources\PriceResource;
use App\Models\Price;
use App\QueryBuilders\PricesQueryBuilder;
use App\QueryBuilders\QueryBuilder;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Cache;

class PriceController extends Controller
{
    protected QueryBuilder $pricesQueryBuilder;

    public function __construct(PricesQueryBuilder $pricesQueryBuilder)
    {
        $this->pricesQueryBuilder = $pricesQueryBuilder;
    }

    /**
     * Display a listing of the resource.
     * @param IndexPriceRequest $request
     * @return ResourceCollection
     */
    public function index(IndexPriceRequest $request): ResourceCollection
    {
        $cottageId = $request->validated('cottage');
        if ($cottageId) {
            $prices = $this->pricesQueryBuilder->getByCottage($cottageId);
            return PriceResource::collection($prices);
        } else {
            $prices = Cache::remember('prices', 60 * 60 * 24 * 7, function () {
                return $this->pricesQueryBuilder->getAllWithRelations();
            });
            return new PriceCollection($prices);
        }
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
    public function store(StorePriceRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Price $price): PriceResource
    {
        return new PriceResource($price);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Price $price)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePriceRequest $request, Price $price)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Price $price)
    {
        //
    }
}
