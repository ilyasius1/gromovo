<?php

declare(strict_types=1);

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

    public function getActive(): Collection
    {
        return $this->getModel()->active()->orderBy('id')->get();
    }

    public function getAllWithTypes(): Collection
    {
        return $this->getModel()
                    ->select(
                        'cottages.*',
                        'cottage_types.name as cottage_type',
                    )
                    ->join('cottage_types', 'cottages.cottage_type_id', '=', 'cottage_types.id')
                    ->get();
    }

    public function paginateWithTypes($perPage = 10): LengthAwarePaginator
    {
        return $this->getModel()
                    ->join('cottage_types', 'cottages.cottage_type_id', '=', 'cottage_types.id')
                    ->paginate($perPage);
    }

    public function getFree($params)
    {
        $query = $this->getModel();
        if (isset($params['cottage_type'])) {
            $query->where('cottages.cottage_type_id', '=', $params['cottage_type']);
        }
        if (isset($params['start'], $params['end'])) {
            $query->join('bookings', 'bookings.cottage_id', '=', 'cottages.id')
                  ->where('bookings.start', '>', $params['end'])
                  ->orWhere('bookings.end', '<', $params['start']);
        }
        $query->active();
        return $query->get();
    }
}
