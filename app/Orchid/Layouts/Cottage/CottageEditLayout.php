<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Cottage;

use App\Models\CottageType;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;
use Orchid\Support\Color;

class CottageEditLayout extends Rows
{
    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    protected $title;

//    protected string $target = 'cottage';

    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */
    protected function fields(): iterable
    {
        return [
            Input::make('cottage.name')
                ->required()
                ->title('Название коттеджа')
                ->placeholder('Название коттеджа')
                ->help(''),
            Select::make('cottage.cottage_type_id')
                ->required()
                ->empty('Выберите тип')
                ->title('Тип коттеджа')
                ->help('')
                ->fromModel(CottageType::class, 'name'),
            TextArea::make('cottage.description')
                ->title('Описание'),
            Input::make('cottage.area')
                ->title('Площадь, м²')
                ->placeholder('Площадь')
                ->help(''),
            Input::make('cottage.floors')
                ->type('number')
                ->min(0)
                ->title('Этажей')
                ->placeholder('Этажей')
                ->help(''),
            Input::make('cottage.bedrooms')
                ->type('number')
                ->min(0)
                ->title('Количество спален')
                ->placeholder('Количество спален')
                ->help(''),
            Input::make('cottage.single_beds')
                ->type('number')
                ->min(0)
                ->title('Односпальных мест')
                ->placeholder('Односпальных мест')
                ->help(''),
            Input::make('cottage.double_beds')
                ->type('number')
                ->min(0)
                ->title('Двуспальных мест')
                ->placeholder('Двуспальных мест')
                ->help(''),
            Input::make('cottage.additional_single_beds')
                ->type('number')
                ->min(0)
                ->title('Дополнительных односпальных мест')
                ->placeholder('Дополнительных односпальных мест')
                ->help(''),
            Input::make('cottage.additional_double_beds')
                ->type('number')
                ->min(0)
                ->title('Дополнительных двуспальных мест')
                ->placeholder('Дополнительных двуспальных мест')
                ->help(''),
            Input::make('cottage.bathrooms')
                ->type('number')
                ->min(0)
                ->title('Санузлов')
                ->placeholder('Количество санузлов')
                ->help(''),
            Input::make('cottage.showers')
                ->type('number')
                ->min(0)
                ->title('Душевых кабин')
                ->placeholder('Количество душевых')
                ->help(''),
            TextArea::make('floor1_features')
                ->title('1 этаж')
                ->value($this->query['presenter']->floor1)
                ->rows(8),
            TextArea::make('floor2_features')
                ->title('2 этаж')
                ->value($this->query['presenter']->floor2)
                ->rows(8),
            TextArea::make('floor3_features')
                ->title('3 этаж')
                ->value($this->query['presenter']->floor3)
                ->rows(8),
            CheckBox::make('cottage.sauna')
                ->title('Сауна')
                ->placeholder('Сауна')
                ->help(''),
            CheckBox::make('cottage.fireplace')
                ->title('Мангал')
                ->placeholder('Место для мангала')
                ->help(''),
            CheckBox::make('cottage.is_active')
                ->title('Активен')
                ->placeholder('Активен?')
                ->help(''),
            Button::make('Создать коттедж')
                ->type(Color::SUCCESS)
                ->icon('save')
                ->method('store')
                ->canSee(!$this->query['cottageExists']),

            Button::make('Сохранить')
                ->type(Color::SUCCESS)
                ->icon('save')
                ->method('update')
                ->canSee($this->query['cottageExists'])
        ];
    }
}
