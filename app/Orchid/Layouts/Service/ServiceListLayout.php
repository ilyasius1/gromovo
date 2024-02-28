<?php

namespace App\Orchid\Layouts\Service;

use App\Models\Service;
use Carbon\CarbonImmutable;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class ServiceListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'services';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('id', 'id')
            ->render(function (Service $service) {
                return Link::make((string)$service->id)
                    ->route('platform.services.edit', $service);
            }),
            TD::make('name', 'Название')
                ->render(function (Service $service) {
                    return Link::make((string)$service->name)
                        ->route('platform.services.edit', $service);
                }),
            TD::make('serviceCategory', 'Категория услуг')
                ->render(function (Service $service) {
                    return Link::make((string)$service->serviceCategory->name)
                        ->route('platform.serviceCategories.edit', $service->serviceCategory);
                }),
            TD::make('price', 'Цена'),
            TD::make('price_per_hour', 'Цена за час'),
            TD::make('price_per_day', 'Цена за день'),
        ];
    }
}
