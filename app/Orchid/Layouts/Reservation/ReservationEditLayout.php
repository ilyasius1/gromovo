<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Reservation;

use App\Enums\ReservationStatus;
use App\Models\Cottage;
use App\Models\CustomerProfile;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;
use Orchid\Support\Color;

class ReservationEditLayout extends Rows
{
    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    protected $title = 'Бронь';

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
            Select::make('reservation.cottage_id')
                  ->required()
                  ->empty('Выберите коттедж')
                  ->title('Коттедж')
                  ->fromModel(Cottage::class, 'name'),
            Select::make('reservation.customer_profile_id')
                  ->required()
                  ->empty('Выберите анкету')
                  ->title('Анкета')
                  ->fromModel(CustomerProfile::class, 'full_name'),
            Input::make('reservation.start')
                 ->type('date')
                 ->required()
                 ->title('Дата заезда')
                 ->placeholder('ДД.ММ.ГГГГ'),
            Input::make('reservation.end')
                 ->type('date')
                 ->required()
                 ->title('Дата выезда')
                 ->placeholder('ДД.ММ.ГГГГ'),
            Input::make('reservation.amount')
                 ->mask([
                     'mask' => '[9]{1,}',
                 ])
                 ->required()
                 ->title('Сумма')
                 ->placeholder('Сумма'),
            Input::make('reservation.pay_before')
                 ->type('datetime-local')
                 ->required()
                 ->value($this->query['reservation.pay_before'])
                 ->title('Оплатить до')
                 ->canSee($this->query['reservationExists']),
            Select::make('reservation.status')
                  ->fromEnum(ReservationStatus::class, 'status')
                  ->required()
                  ->title('Статус')
                  ->value(ReservationStatus::DRAFT)
                  ->canSee($this->query['reservationExists']),

            Button::make('Создать бронь')
                  ->type(Color::SUCCESS)
                  ->icon('save')
                  ->method('store')
                  ->canSee(!$this->query['reservationExists']),

            Button::make('Сохранить')
                  ->type(Color::SUCCESS)
                  ->icon('save')
                  ->method('update')
                  ->canSee($this->query['reservationExists'])
        ];
    }
}
