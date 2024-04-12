<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceCollection;
use App\Http\Resources\ServiceResource;
use App\Models\Service;
use App\QueryBuilders\ServicesQueryBuilder;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Cache;

class ServiceController extends Controller
{
    public function __construct(protected ServicesQueryBuilder $servicesQueryBuilder)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return ResourceCollection
     */
    public function index(): ResourceCollection
    {
        $services = Cache::remember('services', 60 * 60 * 24 * 7, function () {
            return $this->servicesQueryBuilder->getAllWithCategories();
        });
        return ServiceCollection::make($services);
    }

    /**
     * Display the specified resource.
     *
     * @param Service $service
     * @return ServiceResource
     */
    public function show(Service $service): ServiceResource
    {
        return new ServiceResource($service);
    }
}
