<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePackageRequest;
use App\Http\Requests\UpdatePackageRequest;
use App\Http\Resources\PackageResource;
use App\Models\Package;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $packages = Package::all();
        return PackageResource::collection($packages);
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
    public function store(StorePackageRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     * @param Package $package
     * @return PackageResource
     */
    public function show(Package $package): PackageResource
    {
        return new PackageResource($package);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Package $package)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePackageRequest $request, Package $package)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Package $package)
    {
        //
    }
}
