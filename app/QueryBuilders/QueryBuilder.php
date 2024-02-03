<?php

namespace App\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

abstract class QueryBuilder
{
    abstract public function getModel(): Builder;

    abstract public function getAll(): Collection | LengthAwarePaginator;
}
