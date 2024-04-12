<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Reservation;

use App\Models\Reservation;
use Carbon\CarbonImmutable;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class ReservationListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'reservations';

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
              ->filter(Input::make())->render(function (Reservation $reservation) {
                    return Link::make((string)$reservation->id)
                               ->route('platform.reservations.edit', $reservation);
                }),
            TD::make('cottage_id', 'Коттедж')
              ->sort()
              ->filter()
              ->render(function (Reservation $reservation) {
                  return Link::make(($reservation->cottage->name))
                             ->route('platform.cottages.edit', $reservation->cottage);
              }),
            TD::make('customer_profile_id', 'Анкета')
              ->render(function (Reservation $reservation) {
                  return Link::make(($reservation->customerProfile->full_name))
                             ->route('platform.customerProfiles.edit', $reservation->customerProfile);
              }),
            TD::make('start', 'Дата заезда')
              ->render(function (Reservation $reservation) {
                  return CarbonImmutable::make($reservation->start)->format('d.m.Y');
              }),
            TD::make('end', 'Дата выезда')
              ->render(function (Reservation $reservation) {
                  return CarbonImmutable::make($reservation->end)->format('d.m.Y');
              }),
            TD::make('amount', 'Сумма'),
            TD::make('pay_before', 'Оплатить до')
              ->sort()
              ->filter()
              ->render(function (Reservation $reservation) {
                  return CarbonImmutable::make($reservation->pay_before)->format('d.m.Y H:i:s');
              }),
            TD::make('status', 'Статус')
              ->sort()
              ->filter()
              ->render(function (Reservation $reservation) {
                  return $reservation->status->status();
              }),
            TD::make('created_at', 'Дата создания')
              ->render(function (Reservation $reservation) {
                  return CarbonImmutable::make($reservation->created_at)->format('d.m.Y H:i:s');
              })
              ->defaultHidden(),
            TD::make('updated_at', 'Дата изменения')
              ->render(function (Reservation $reservation) {
                  return CarbonImmutable::make($reservation->updated_at)->format('d.m.Y H:i:s');
              })
        ];
    }
}
