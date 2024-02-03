<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePeriodRequest;
use App\Http\Requests\UpdatePeriodRequest;
use App\Http\Resources\PeriodResource;
use App\Models\Period;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PeriodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $periods = Period::all();
        return PeriodResource::collection($periods);
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
    public function store(StorePeriodRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Period $period
     * @return PeriodResource
     */
    public function show(Period $period): PeriodResource
    {
        return new PeriodResource($period);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Period $period)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePeriodRequest $request, Period $period)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Period $period)
    {
        //
    }
}
