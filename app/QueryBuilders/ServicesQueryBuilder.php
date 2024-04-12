<?php

declare(strict_types=1);

namespace App\QueryBuilders;

use App\Models\Service;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class ServicesQueryBuilder extends QueryBuilder
{
    public function getModel(): Builder
    {
        return Service::query();
    }

    public function getAllWithCategories(): Collection
    {
        return $this->getModel()
                    ->select(
                        'services.*',
                        'service_categories.name as categoryName',
                    )
                    ->join('service_categories', 'services.service_category_id', '=', 'service_categories.id')
                    ->get();
    }
}
