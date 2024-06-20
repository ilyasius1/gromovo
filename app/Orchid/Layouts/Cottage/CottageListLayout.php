<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Cottage;

use App\Models\Cottage;
use App\Models\CottageType;
use Carbon\CarbonImmutable;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\DateRange;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Radio;
use Orchid\Screen\Fields\Select;
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
              ->filter(Input::make())
              ->render(function (Cottage $cottage) {
                  return Link::make((string)$cottage->id)
                             ->route('platform.cottages.edit', $cottage);
              }),
            TD::make('name', 'Название')
              ->sort()
              ->filter(Input::make())
              ->width('250px')
              ->render(function (Cottage $cottage) {
                  return Link::make($cottage->name)
                             ->route('platform.cottages.edit', $cottage);
              }),
            TD::make('cottage_type_id', 'Тип коттеджа')
              ->sort()
              ->filter(Select::make()
                             ->fromModel(CottageType::class, 'name')
                             ->multiple()
              )
              ->render(function (Cottage $cottage) {
                  return Link::make($cottage->cottageType->name)
                             ->route('platform.cottageTypes.edit', $cottage->cottageType);
              }),
            TD::make('area', 'Площадь'),
            TD::make('floors', 'Этажей'),
            TD::make('is_active', 'Активен')
              ->filter(Select::make('active')
                             ->empty('Все')
                             ->options([
                                 'true' => 'Да',
                                 'false' => 'Нет'
                             ])
                             ->title('Active?')
              )
              ->render(function (Cottage $cottage) {
                  return $cottage->is_active ? 'Да' : 'Нет';
              }),
            TD::make('created_at', 'Дата создания')
              ->sort()
              ->filter(DateRange::make())
              ->defaultHidden()
              ->render(function (Cottage $cottage) {
                  return CarbonImmutable::make($cottage->created_at)
                                        ?->format('d.m.Y H:i:s');
              }),
            TD::make('updated_at', 'Дата изменения')
              ->sort()
              ->filter(DateRange::make())
              ->defaultHidden()
              ->render(function (Cottage $cottage) {
                  return CarbonImmutable::make($cottage->updated_at)
                                        ?->format('d.m.Y H:i:s');
              })
        ];
    }
}
