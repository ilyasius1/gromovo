<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\CustomerProfile;

use Orchid\Screen\Actions\Button;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;
use Orchid\Support\Color;

class CustomerProfileEditLayout extends Rows
{
    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    protected $title = 'Анкета клиента';

    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */
    protected function fields(): iterable
    {
        return [
            Input::make('customerProfile.full_name')
                 ->required()
                 ->title('ФИО')
                 ->placeholder('ФИО')
                 ->help(''),
            Input::make('customerProfile.phone')
                 ->type('tel')
                 ->mask([
                     'mask' => '+7 (999) 999-9999',
                     'removeMaskOnSubmit' => true
                 ])
                 ->required()
                 ->title('Номер телефона')
                 ->placeholder('Номер телефона')
                 ->help(''),
            Input::make('customerProfile.email')
                 ->mask([
                     'alias' => 'email',
                     'removeMaskOnSubmit' => true
                 ])
                 ->required()
                 ->title('Email')
                 ->placeholder('Email')
                 ->help(''),
            Input::make('customerProfile.document_number')
                 ->mask([
                     'mask' => '** ** ******',
                     'regex' => '[0-9a-zA-Z]{10}',
                     'removeMaskOnSubmit' => true
                 ])
                 ->required()
                 ->title('Серия и номер документа')
                 ->placeholder('Серия и номер документа')
                 ->help(''),
            Input::make('customerProfile.document_issued_by')
                 ->required()
                 ->title('Кем выдан')
                 ->placeholder('Кем выдан')
                 ->help(''),
            Input::make('customerProfile.document_issued_at')
                 ->type('date')
                 ->required()
                 ->title('Дата выдачи'),
            Input::make('customerProfile.address')
                 ->required()
                 ->title('Адрес')
                 ->placeholder('Адрес')
                 ->help(''),
            Input::make('customerProfile.birthdate')
                 ->type('date')
                 ->required()
                 ->title('Дата рождения')
                 ->placeholder('ДД.ММ.ГГГГ'),
            CheckBox::make('customerProfile.news_subscription')
                    ->placeholder('Подписка на новости'),

            Button::make('Создать анкету')
                  ->type(Color::SUCCESS)
                  ->icon('save')
                  ->method('store')
                  ->canSee(!$this->query['customerProfileExists']),

            Button::make('Сохранить')
                  ->type(Color::SUCCESS)
                  ->icon('save')
                  ->method('update')
                  ->canSee($this->query['customerProfileExists'])
        ];
    }
}
