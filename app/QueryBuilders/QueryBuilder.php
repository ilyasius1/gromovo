<?php

declare(strict_types=1);

namespace App\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

abstract class QueryBuilder
{
    abstract public function getModel(): Builder;

    public function getAll(): Collection|LengthAwarePaginator
    {
        return $this->getModel()->get();
    }

    /**
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getPaginate(int $perPage = 10): LengthAwarePaginator
    {
        return $this->getModel()->paginate($perPage);
    }

}
