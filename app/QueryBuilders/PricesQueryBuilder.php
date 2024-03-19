<?php

declare(strict_types=1);

namespace App\QueryBuilders;

use App\Models\Price;
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
     * Получить цены на коттедж
     *
     * @param int|string $cottageId
     * @return Collection
     */
    public function getByCottage(int|string $cottageId): Collection
    {
        return $this->getModel()
                    ->join('cottage_types', 'cottage_types.id', '=', 'prices.cottage_type_id')
                    ->join('cottages', 'cottages.cottage_type_id', '=','cottage_types.id')
                    ->where('cottages.id', '=', $cottageId)
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
