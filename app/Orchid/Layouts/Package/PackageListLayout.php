<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Package;

use App\Models\Package;
use Carbon\CarbonImmutable;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\DateRange;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class PackageListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'packages';
    protected array $days = [
        1 => 'Понедельник',
        2 => 'Вторник',
        3 => 'Среда',
        4 => 'Четверг',
        5 => 'Пятница',
        6 => 'Суббота',
        7 => 'Воскресенье'
    ];

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
              ->render(function (Package $package) {
                  return Link::make((string)$package->id)
                             ->route('platform.packages.edit', $package);
              }),
            TD::make('name', 'Название')
              ->sort()
              ->filter(Input::make())
              ->render(function (Package $package) {
                  return Link::make($package->name)
                             ->route('platform.packages.edit', $package);
              }),
            TD::make('nights', 'Ночей')->sort()
              ->filter(Input::make()
                            ->type('number')
                            ->min(1)
                            ->max(366)
                            ->title('Ночей')
                            ->placeholder('Y'))
              ->render(fn(Package $package) => $package->nights),
            TD::make('days_start', 'Начало')
              ->sort()
              ->filter(Select::make()
                             ->empty('Все')
                             ->options($this->days)
                             ->title('День недели')
              )
              ->render(function (Package $package) {
                  return $this->days[$package->days_start];
              }),
            TD::make('days_end', 'Конец')
              ->sort()
              ->filter(Select::make()
                             ->empty('Все')
                             ->options($this->days)
                             ->title('День недели')
              )
              ->render(function (Package $package) {
                  return $this->days[$package->days_end];
              }),
            TD::make('created_at', 'Дата создания')
              ->sort()
              ->filter(DateRange::make())
              ->render(function (Package $package) {
                  return CarbonImmutable::make($package->created_at)
                                        ->format('d.m.Y H:i:s');
              })
              ->defaultHidden(),
            TD::make('updated_at', 'Дата изменения')
              ->sort()
              ->filter(DateRange::make())
              ->render(function (Package $package) {
                  return CarbonImmutable::make($package->updated_at)
                                        ->format('d.m.Y H:i:s');
              })
              ->defaultHidden()
        ];
    }
}
