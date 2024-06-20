<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Booking;

use App\Enums\BookingStatus;
use App\Models\Cottage;
use App\Models\CustomerProfile;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;
use Orchid\Support\Color;

class BookingEditLayout extends Rows
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
            Select::make('booking.cottage_id')
                  ->required()
                  ->empty('Выберите коттедж')
                  ->title('Коттедж')
                  ->fromModel(Cottage::class, 'name'),
            Select::make('booking.customer_profile_id')
                  ->required()
                  ->empty('Выберите анкету')
                  ->title('Анкета')
                  ->fromModel(CustomerProfile::class, 'full_name'),
            Input::make('booking.start')
                 ->type('date')
                 ->required()
                 ->title('Дата заезда')
                 ->placeholder('ДД.ММ.ГГГГ'),
            Input::make('booking.end')
                 ->type('date')
                 ->required()
                 ->title('Дата выезда')
                 ->placeholder('ДД.ММ.ГГГГ'),
            Select::make('booking.main_places')
                  ->options(range(0, 10))
                  ->title('Количество основных мест'),
            Select::make('booking.children_places')
                  ->options(range(0, 10))
                  ->title('Количество детских мест'),
            Select::make('booking.additional_places')
                  ->options(range(0, 10))
                  ->title('Количество дополнительных мест'),
            Input::make('booking.amount')
                 ->mask([
                     'mask' => '[9]{1,}',
                 ])
                 ->required()
                 ->title('Сумма')
                 ->placeholder('Сумма'),
            Input::make('booking.pay_before')
                 ->type('datetime-local')
                 ->required()
                 ->value($this->query['booking.pay_before'])
                 ->title('Оплатить до')
                 ->canSee($this->query['bookingExists']),
            Select::make('booking.status')
                  ->fromEnum(BookingStatus::class, 'status')
                  ->required()
                  ->title('Статус')
                  ->value(BookingStatus::DRAFT)
                  ->canSee($this->query['bookingExists']),

            Button::make('Создать бронь')
                  ->type(Color::SUCCESS)
                  ->icon('save')
                  ->method('store')
                  ->canSee(!$this->query['bookingExists']),

            Button::make('Сохранить')
                  ->type(Color::SUCCESS)
                  ->icon('save')
                  ->method('update')
                  ->canSee($this->query['bookingExists'])
        ];
    }
}
