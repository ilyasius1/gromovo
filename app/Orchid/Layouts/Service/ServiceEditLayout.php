<?php

namespace App\Orchid\Layouts\Service;

use App\Models\ServiceCategory;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;
use Orchid\Support\Color;

class ServiceEditLayout extends Rows
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
            Input::make('service.name')
                ->required()
                ->title('Название услуги')
                ->placeholder('Название услуги'),
            Select::make('service.service_category_id')
                ->required()
                ->empty('Выберите категорию')
                ->title('Категория услуг')
                ->help('')
                ->fromModel(ServiceCategory::class, 'name'),
            Input::make('service.attention')
                ->title('Обратите внимание'),
            Input::make('service.price')
                ->title('Цена'),
            Input::make('service.price_per_hour')
                ->title('Цена за час'),
            Input::make('service.price_per_day')
                ->title('Цена за день'),

            Button::make('Создать услугу')
                ->type(Color::SUCCESS)
                ->icon('save')
                ->method('store')
                ->canSee(!$this->query['serviceExists']),

            Button::make('Сохранить')
                ->type(Color::SUCCESS)
                ->icon('save')
                ->method('update')
                ->canSee((bool)$this->query['serviceExists']),
        ];
    }
}
