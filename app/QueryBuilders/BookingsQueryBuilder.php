<?php

declare(strict_types=1);

namespace App\QueryBuilders;

use App\Enums\BookingStatus;
use App\Models\Booking;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class BookingsQueryBuilder extends QueryBuilder
{
    protected bool $filters = false;
    protected ?string $defaultSort = null;

    /**
     * @param bool $filters
     * @return Builder
     */
    public function getModel(bool $filters = false): Builder
    {
        $query = Booking::query();
        if ($this->filters) {
            $query = $query->filters();
        }
        if (is_string($this->defaultSort)) {
            $query = $query->defaultSort($this->defaultSort);
        }
        return $query;
    }

    /**
     * @return Collection
     */
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

    /**
     * @param bool $filters
     * @param string|null $defaultSort
     * @return Collection
     */
    public function getAllWithRelations(bool $filters = false, ?string $defaultSort = null): Collection
    {
        $this->filters = $filters;
        $this->defaultSort = $defaultSort;
        return $this->selectWithRelations()->get();
    }

    /**
     * @param bool $filters
     * @param string|null $defaultSort
     * @param $perPage
     * @return LengthAwarePaginator
     */
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
     * @param BookingStatus[] $statuses - по статусам бронирования
     * @param bool $withRelations - запрашивать с отношениями или нет
     * @return Collection
     */
    public function getByCottageAndDates(int|string $cottageId, ?string $start = null, ?string $end = null, array $statuses = [], bool $withRelations = false): Collection
    {
        $query = $withRelations
            ? $this->selectWithRelations()
            : $this->getModel()
                   ->where('cottage_id', '=', $cottageId);
        if ($start) {
            $query->where(function (Builder $query) use ($start, $end) {
                $query->where(function (Builder $query) use ($start, $end) {
                    $query->where('start', '>=', $start);
                    if (isset($end)) {
                        $query->where('start', '<', $end);
                    }

                })
                      ->orWhere(function (Builder $query) use ($start, $end) {
                          $query->where('end', '>', $start);
                                if (isset($end)) {
                                    $query->where('end', '<=', $end);
                                }
                      })
                      ->orWhere(function (Builder $query) use ($start, $end) {
                          $query->where('start', '<=', $start);
                              if (isset($end)) {
                                  $query->where('end', '>=', $end);
                              }
                      });
            });
        }
        if (!empty($statuses)) {
            $query->whereIn('status', $statuses);
        }
        return $query->orderBy('start')->get();
    }

    /**
     * @param int|string $cottageId
     * @param string $start
     * @param string $end
     * @return bool
     */
    public function isCottageBooked(int|string $cottageId, string $start, string $end): bool
    {
        return $this->getModel()
                    ->where('cottage_id', '=', $cottageId)
                    ->where(function (Builder $query) use ($start, $end) {
                        $query->where(function (Builder $query) use ($start, $end) {
                            $query->where('start', '>=', $start)
                                  ->where('start', '<', $end);
                        })
                              ->orWhere(function (Builder $query) use ($start, $end) {
                                  $query->where('end', '>', $start)
                                        ->where('end', '<=', $end);
                              });
                    })
                    ->exists();
    }

    public function getByContractNumber(string $contractNumber): Builder|Model
    {
        return $this->selectWithRelations()
                    ->where('contract_number', '=', $contractNumber)
                    ->firstOrFail();
    }
}
