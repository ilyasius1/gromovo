<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Price;

use App\Models\Price;
use Carbon\CarbonImmutable;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class PriceListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'prices';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('id', 'id')
              ->render(function (Price $price) {
                  return Link::make((string)$price->id)
                             ->route('platform.prices.edit', $price);
              }),
            TD::make('name', 'Название')
              ->render(function (Price $price) {
                  return Link::make((string)$price->name)
                             ->route('platform.prices.edit', $price);
              }),
            TD::make('cottageType', 'Тип коттеджа')
              ->render(function (Price $price) {
                  return Link::make((string)$price->cottageType->name)
                             ->route('platform.cottageTypes.edit', $price->cottageType);
              }),
            TD::make('period', 'Период')
              ->render(function (Price $price) {
                  return Link::make((string)$price->period->name)
                             ->route('platform.periods.edit', $price->period);
              }),
            TD::make('start', 'Дата начала')
              ->render(function (Price $price) {
                  return CarbonImmutable::make($price->period->start)->format('d.m.Y');
              })
              ->defaultHidden(),
            TD::make('end', 'Дата окончания')
              ->render(function (Price $price) {
                  return CarbonImmutable::make($price->period->end)->format('d.m.Y');
              })
              ->defaultHidden(),
            TD::make('package', 'Пакет')
              ->render(function (Price $price) {
                  return Link::make((string)$price->package->name)
                             ->route('platform.prices.edit', $price->package);
              }),
            TD::make('nights', 'Цена')
              ->render(fn(Price $price) => $price->rate),
            TD::make('is_active', 'Активна')
              ->render(function (Price $price) {
                  return $price->is_active ? 'Да' : 'Нет';
              })
        ];
    }
}
