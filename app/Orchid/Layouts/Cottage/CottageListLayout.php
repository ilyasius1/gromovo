<?php

namespace App\Orchid\Layouts\Cottage;

use App\Models\Cottage;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;

class CottageListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'cottages';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('id', 'id')
                ->sort()
                ->render(function (Cottage $cottage) {
                    return Link::make((string)$cottage->id)
                        ->route('platform.cottages.edit', $cottage);
                }),
            TD::make('name', 'Название')
                ->sort()
                ->width('250px')
                ->render(function (Cottage $cottage) {
                    return Link::make($cottage->name)
                        ->route('platform.cottages.edit', $cottage);
                }),
            TD::make('cottage_type_id', 'Тип коттеджа')
                ->render(function (Cottage $cottage) {
                    return Link::make($cottage->cottageType->name)
                        ->route('platform.cottageTypes.edit', $cottage->cottageType);
                }),
            TD::make('area', 'Площадь'),
            TD::make('floors', 'Этажей'),
            TD::make('is_active', 'Активен')
                ->render(function (Cottage $cottage) {
                    return $cottage->is_active ? 'Да' : 'Нет';
                }),
        ];
    }
}
