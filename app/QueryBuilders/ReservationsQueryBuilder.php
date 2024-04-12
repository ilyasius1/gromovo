<?php

declare(strict_types=1);

namespace App\QueryBuilders;

use App\Enums\ReservationStatus;
use App\Models\Reservation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ReservationsQueryBuilder extends QueryBuilder
{
    protected bool $filters = false;
    protected ?string $defaultSort = null;

    public function getModel(bool $filters = false): Builder
    {
        $query = Reservation::query();
        if ($this->filters) {
            $query = $query->filters();
        }
        if (is_string($this->defaultSort)) {
            $query = $query->defaultSort($this->defaultSort);
        }
        return $query;
    }

    public function getAll(): Collection
    {
        return $this->getModel()->get();
    }

    /**
     * @return Builder
     */
    public function selectWithRelations(): Builder
    {
        return $this->getModel()->with(['cottage', 'customerProfile']);
    }

    public function getAllWithRelations(bool $filters = false, ?string $defaultSort = null): Collection
    {
        $this->filters = $filters;
        $this->defaultSort = $defaultSort;
        return $this->selectWithRelations()->get();
    }

    public function paginateWithRelations(bool $filters = false, ?string $defaultSort = null, $perPage = 10): LengthAwarePaginator
    {
        $this->filters = $filters;
        $this->defaultSort = $defaultSort;
        return $this->selectWithRelations()->paginate($perPage);
    }

    /**
     * @param int|string $cottageId
     * @param string|null $start
     * @param string|null $end
     * @param ReservationStatus[] $statuses - по статусам бронирования
     * @param bool $withRelations - запрашивать с отношениями или нет
     * @return Collection
     */
    public function getByCottageAndDates(int|string $cottageId, ?string $start = null, ?string $end = null, array $statuses = [], bool $withRelations = false): Collection
    {
        $query = $withRelations
            ? $this->selectWithRelations()
            : $this->getModel()
                   ->where('cottage_id', '=', $cottageId);
        if ($start && $end) {
            $query->where(function (Builder $query) use ($start, $end) {
                $query->where(function (Builder $query) use ($start, $end) {
                    $query->where('start', '>=', $start)
                          ->where('start', '<', $end);
                })
                      ->orWhere(function (Builder $query) use ($start, $end) {
                          $query->where('end', '<', $start)
                                ->where('end', '<=', $end);
                      });
            });
        }
        if (!empty($statuses)) {
            $query->whereIn('status', $statuses);
        }
        return $query->get();
    }
}
