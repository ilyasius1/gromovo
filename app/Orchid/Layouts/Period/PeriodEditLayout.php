<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Period;

use Orchid\Screen\Actions\Button;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\DateRange;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Switcher;
use Orchid\Screen\Layouts\Rows;
use Orchid\Support\Color;

class PeriodEditLayout extends Rows
{
    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    protected $title;

    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */
    protected function fields(): iterable
    {
        return [
            Input::make('period.name')
                 ->required()
                 ->title('Название периода')
                 ->placeholder('Название периода')
                 ->help(''),
            DateRange::make('period')
                     ->required()
                     ->title('Даты'),
            Switcher::make('period.is_holiday')
                    ->sendTrueOrFalse()
                    ->placeholder('Праздничный'),
            CheckBox::make('period.is_active')
                    ->placeholder('Активен?')
                    ->help(''),

            Button::make('Создать период')
                  ->type(Color::SUCCESS)
                  ->icon('save')
                  ->method('store')
                  ->canSee(!$this->query['periodExists']),

            Button::make('Сохранить')
                  ->type(Color::SUCCESS)
                  ->icon('save')
                  ->method('update')
                  ->canSee($this->query['periodExists'])
        ];
    }
}
