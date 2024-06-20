<?php

declare(strict_types=1);

namespace App\QueryBuilders;

use App\Models\Price;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class PricesQueryBuilder extends QueryBuilder
{
    /**
     * @return Builder
     */
    public function getModel(): Builder
    {
        return Price::query();
    }

    /**
     * @param int|string $cottageId
     * @return Builder
     */
    public function byCottage(int|string $cottageId): Builder
    {
        return $this->getModel()
                    ->join('cottage_types', 'cottage_types.id', '=', 'prices.cottage_type_id')
                    ->join('cottages', 'cottages.cottage_type_id', '=', 'cottage_types.id')
                    ->where('cottages.id', '=', $cottageId);
    }

    /**
     * Получить цены на коттедж
     *
     * @param int|string $cottageId
     * @return Collection
     */
    public function getByCottage(int|string $cottageId): Collection
    {
        return $this->byCottage($cottageId)
                    ->get();
    }

    /**
     * @param int|string $cottageId
     * @param CarbonImmutable $start
     * @param CarbonImmutable $end
     * @param $isFullMonth
     * @param $orderBy
     * @param $orderDirection
     * @return Collection
     */
    public function getByCottageAndDates(int|string $cottageId, CarbonImmutable $start, CarbonImmutable $end, $isFullMonth = false, $orderBy = 'packages.nights', $orderDirection = 'desc'): Collection
    {
        $bookingNights = $end->diffInDays($start);
        return Price::with([
            'cottageType',
            'package',
            'period'
        ])
                    ->join('periods', 'prices.period_id', '=', 'periods.id')
                    ->join('packages', 'prices.package_id', '=', 'packages.id')
                    ->join('cottage_types', 'prices.cottage_type_id', '=', 'cottage_types.id')
                    ->join('cottages', 'cottage_types.id', '=', 'cottages.cottage_type_id')
                    ->select(
                        'prices.id',
                        'prices.rate',
                        'prices.name',
                        'prices.cottage_type_id',
                        'prices.period_id',
                        'prices.package_id'
            )
                    ->where('prices.is_active', '=', true)
                    ->where('cottages.id', '=', $cottageId)
                    ->where(function (Builder $query) use ($bookingNights, $isFullMonth) {
                        $query->where('packages.nights', '<=', $bookingNights);
                        if ($isFullMonth) {
                            $query->orWhere('packages.nights', '=', 30);
                        }
                        return $query;
                    }
                    )
                    ->where(function (Builder $query) use ($start, $end) {
                        return $query->where(function (Builder $query) use ($start, $end) {
                            return $query->where('periods.start', '>', $start)
                                         ->where('periods.start', '<=', $end);
                        })
                                     ->orWhere((function (Builder $query) use ($start, $end) {
                                         return $query->where('periods.end', '>', $start)
                                                      ->where('periods.end', '<=', $end);
                                     }))
                                     ->orWhere(function (Builder $query) use ($start, $end) {
                                         return $query->where('periods.start', '<=', $start)
                                                      ->where('periods.end', '>=', $end);
                                     });
                    })
                    ->orderBy($orderBy, $orderDirection)->orderBy('periods.start')
                    ->get();

    }


    /**
     * Получить цены со связанными типами коттеджей, периодами и пакетами
     *
     * @return \Illuminate\Database\Eloquent\Collection|array
     */
    public function getAllWithRelations(): \Illuminate\Database\Eloquent\Collection|array
    {
        return $this->getModel()
                    ->join('cottage_types', 'cottage_types.id', '=', 'prices.cottage_type_id')
                    ->join('periods', 'periods.id', '=', 'prices.period_id')
                    ->join('packages', 'packages.id', '=', 'prices.package_id')
                    ->select(
                        'prices.id as priceId',
                        'prices.name as priceName',
                        'prices.rate',
                        'prices.cottage_type_id as cottageTypeId',
                        'cottage_types.name as cottageTypeName',
                        'prices.period_id as periodId',
                        'periods.name as periodName',
                        'periods.start',
                        'periods.end',
                        'periods.is_holiday',
                        'prices.package_id as packageId',
                        'packages.name as packageName',
                        'packages.nights as days')
                    ->where('periods.is_active', '=', 'true')
                    ->where('prices.is_active', '=', 'true')
                    ->get();
    }
}
