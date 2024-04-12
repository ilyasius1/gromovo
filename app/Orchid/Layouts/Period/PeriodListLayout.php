<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Period;

use App\Models\Period;
use Carbon\CarbonImmutable;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\DateRange;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class PeriodListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'periods';

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
              ->render(function (Period $period) {
                  return Link::make((string)$period->id)
                             ->route('platform.periods.edit', $period);
              }),
            TD::make('name', 'Название')
              ->sort()
              ->filter(Input::make())
              ->render(function (Period $period) {
                  return Link::make($period->name)
                             ->route('platform.periods.edit', $period);
              }),
            TD::make('start', 'Дата начала')
              ->sort()
              ->render(function (Period $period) {
                  return CarbonImmutable::make($period->start)->format('d.m.Y');
              }),
            TD::make('end', 'Дата окончания')
              ->sort()
              ->render(function (Period $period) {
                  return CarbonImmutable::make($period->end)->format('d.m.Y');
              }),
            TD::make('is_holiday', 'Праздничный?')
              ->filter(Select::make('is_holiday')
                             ->empty('Все')
                             ->options([
                                 'true' => 'Да',
                                 'false' => 'Нет'
                             ])
                             ->title('Праздничный?')
              )
              ->render(function (Period $period) {
                  return $period->is_holiday ? 'Да' : 'Нет';
              }),
            TD::make('is_active', 'Активен')
              ->filter(Select::make('active')
                             ->empty('Все')
                             ->options([
                                 'true' => 'Да',
                                 'false' => 'Нет'
                             ])
                             ->title('Активен?')
              )
              ->render(function (Period $period) {
                  return $period->is_active ? 'Да' : 'Нет';
              }),
            TD::make('created_at', 'Дата создания')
              ->sort()
              ->filter(DateRange::make())
              ->render(function (Period $period) {
                  return CarbonImmutable::make($period->created_at)->format('d.m.Y H:i:s');
              })
              ->defaultHidden(),
            TD::make('updated_at', 'Дата изменения')
              ->sort()
              ->filter(DateRange::make())
              ->render(function (Period $period) {
                  return CarbonImmutable::make($period->updated_at)->format('d.m.Y H:i:s');
              })
              ->defaultHidden()
        ];
    }
}
