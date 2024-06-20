<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Package;

use App\Enums\DayOfWeek;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;
use Orchid\Support\Color;

class PackageEditLayout extends Rows
{

    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     * @throws \ReflectionException
     * @throws \Throwable
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
                  ->fromEnum(DayOfWeek::class, 'dayLocaleUcFirst')
                  ->empty('Не выбрано'),
            Select::make('package.days_end')
                  ->required()
                  ->title('Конец')
                  ->fromEnum(DayOfWeek::class, 'dayLocaleUcFirst')
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
