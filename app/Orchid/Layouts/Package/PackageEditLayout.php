<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Package;

use Orchid\Screen\Actions\Button;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;
use Orchid\Support\Color;

class PackageEditLayout extends Rows
{
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
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */
    protected function fields(): iterable
    {
        return [
            Input::make('package.name')
                 ->required()
                 ->title('Название пакета')
                 ->placeholder('Название пакета'),
            Input::make('package.nights')
                 ->type('number')
                 ->min(1)
                 ->max(366)
                 ->required()
                 ->title('Ночей'),
            Select::make('package.days_start')
                  ->required()
                  ->title('Начало')
                  ->options($this->days)
                  ->empty('Не выбрано'),
            Select::make('package.days_end')
                  ->required()
                  ->title('Конец')
                  ->options($this->days)
                  ->empty('Не выбрано'),

            Button::make('Создать пакет')
                  ->type(Color::SUCCESS)
                  ->icon('save')
                  ->method('store')
                  ->canSee(!$this->query['packageExists']),
            Button::make('Сохранить')
                  ->type(Color::SUCCESS)
                  ->icon('save')
                  ->method('update')
                  ->canSee($this->query['packageExists'])
        ];
    }
}
