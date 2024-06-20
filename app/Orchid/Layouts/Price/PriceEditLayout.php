<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Price;

use App\Models\CottageType;
use App\Models\Package;
use App\Models\Period;
use Illuminate\Contracts\Container\BindingResolutionException;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\Switcher;
use Orchid\Screen\Layouts\Rows;
use Orchid\Support\Color;

class PriceEditLayout extends Rows
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
     * @throws BindingResolutionException
     */
    protected function fields(): iterable
    {
        return [
            Select::make('price.cottage_type_id')
                  ->required()
                  ->empty('Выберите тип коттеджа')
                  ->placeholder('Выберите тип коттеджа')
                  ->title('Тип коттеджа')
                  ->help('')
                  ->fromModel(CottageType::class, 'name'),
            Relation::make('price.period_id')
                    ->fromModel(Period::class, 'name')
                    ->applyScope('active')
                    ->required()
                    ->empty('Выберите период')
                    ->placeholder('Выберите период')
                    ->title('Период')
                    ->displayAppend('nameWithDates'),
            Select::make('price.package_id')
                  ->required()
                  ->empty('Выберите пакет')
                  ->placeholder('Выберите пакет')
                  ->title('Пакет')
                  ->help('')
                  ->fromModel(Package::class, 'name'),
            Input::make('price.rate')
                 ->type('number')
                 ->required()
                 ->title('Цена')
                 ->min(0)
                 ->value(0)
                 ->placeholder('Цена'),

            Switcher::make('price.is_active')
                    ->sendTrueOrFalse()
                    ->checked()
                    ->title('Активна')
                    ->placeholder('Активна'),

            Button::make('Создать цену')
                  ->type(Color::SUCCESS)
                  ->icon('save')
                  ->method('store')
                  ->canSee(!$this->query['priceExists']),
            Button::make('Сохранить')
                  ->type(Color::SUCCESS)
                  ->icon('save')
                  ->method('update')
                  ->canSee($this->query['priceExists'])
        ];
    }
}
