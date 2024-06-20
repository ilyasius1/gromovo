<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Booking;

use App\Models\Booking;
use Carbon\CarbonImmutable;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class BookingListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'bookings';

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
              ->filter(Input::make())->render(function (Booking $booking) {
                    return Link::make((string)$booking->id)
                               ->route('platform.bookings.edit', $booking);
                }),
            TD::make('cottage_id', 'Коттедж')
              ->sort()
              ->filter()
              ->render(function (Booking $booking) {
                  return Link::make(($booking->cottage->name))
                             ->route('platform.cottages.edit', $booking->cottage);
              }),
            TD::make('customer_profile_id', 'Анкета')
              ->render(function (Booking $booking) {
                  return Link::make(($booking->customerProfile->full_name))
                             ->route('platform.customerProfiles.edit', $booking->customerProfile);
              }),
            TD::make('start', 'Дата заезда')
              ->render(function (Booking $booking) {
                  return CarbonImmutable::make($booking->start)->format('d.m.Y');
              }),
            TD::make('end', 'Дата выезда')
              ->render(function (Booking $booking) {
                  return CarbonImmutable::make($booking->end)->format('d.m.Y');
              }),
            TD::make('amount', 'Сумма'),
            TD::make('pay_before', 'Оплатить до')
              ->sort()
              ->filter()
              ->render(function (Booking $booking) {
                  return CarbonImmutable::make($booking->pay_before)->format('d.m.Y H:i:s');
              }),
            TD::make('status', 'Статус')
              ->sort()
              ->filter()
              ->render(function (Booking $booking) {
                  return $booking->status->status();
              }),
            TD::make('created_at', 'Дата создания')
              ->render(function (Booking $booking) {
                  return CarbonImmutable::make($booking->created_at)->format('d.m.Y H:i:s');
              })
              ->defaultHidden(),
            TD::make('updated_at', 'Дата изменения')
              ->render(function (Booking $booking) {
                  return CarbonImmutable::make($booking->updated_at)->format('d.m.Y H:i:s');
              })
        ];
    }
}
