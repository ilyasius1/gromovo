<?php

namespace App\QueryBuilders;

use App\Models\Cottage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class CottagesQueryBuilder extends QueryBuilder
{
    public function getModel(): Builder
    {
        return Cottage::query();
    }

    public function getAll(): Collection|LengthAwarePaginator
    {
        return $this->getModel()->get();
    }

    public function getAllWithTypes(): Collection
    {
        return $this->getModel()
                    ->select(
                        'cottages.*',
                        'cottage_types.name as cottage_type',
                    )
                    ->join('cottage_types', 'cottages.cottage_type_id', '=','cottage_types.id')
                    ->get();
    }

    public function paginateWithTypes($perPage = 10): LengthAwarePaginator
    {
        return $this->getModel()
            ->join('cottage_types', 'cottages.cottage_type_id', '=','cottage_types.id')
            ->paginate($perPage);
    }
}
