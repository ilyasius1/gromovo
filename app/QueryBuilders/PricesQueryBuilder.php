<?php

namespace App\QueryBuilders;

use App\Models\Price;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class PricesQueryBuilder extends QueryBuilder
{

    public function getModel(): Builder
    {
        return Price::query();
    }

    public function getAll(): Collection|LengthAwarePaginator
    {
        return $this->getModel()->get();
    }

    public function getByCottage($cottageId): Collection
    {
        return $this->getModel()
                    ->join('cottage_types', 'cottage_types.id', '=', 'prices.cottage_type_id')
                    ->join('cottages', 'cottages.cottage_type_id', '=','cottage_types.id')
                    ->where('cottages.id', '=', $cottageId)
                    ->get();
    }

    public function getPaginate(): LengthAwarePaginator
    {
        return $this->getModel()->paginate(10);
    }
}
