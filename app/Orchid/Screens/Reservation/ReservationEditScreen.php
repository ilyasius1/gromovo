<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Reservation;

use App\Http\Requests\Reservation\StoreReservationRequest;
use App\Http\Requests\Reservation\UpdateReservationRequest;
use App\Models\Reservation;
use App\Orchid\Layouts\Reservation\ReservationEditLayout;
use App\Services\ReservationService;
use Illuminate\Http\RedirectResponse;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Alert;

class ReservationEditScreen extends Screen
{
    protected ?Reservation $reservation = null;


    public function __construct(protected ReservationService $reservationService)
    {
    }

    protected function reservationExists(): bool
    {
        return (bool)$this->reservation?->exists;
    }

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Reservation $reservation): iterable
    {
        $this->reservation = $reservation;
        return [
            'reservation' => $this->reservation,
            'reservationExists' => $this->reservationExists()
        ];
    }


    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->reservationExists()
            ? 'Редактирование брони id# ' . $this->reservation->id
            : 'Создание брони';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Создать бронь')
                  ->type(Color::SUCCESS)
                  ->icon('save')
                  ->method('store')
                  ->canSee(!$this->reservationExists()),

            Button::make('Сохранить')
                  ->type(Color::SUCCESS)
                  ->icon('save')
                  ->method('update')
                  ->canSee((bool)$this->reservationExists()),

            Button::make('Remove')
                  ->type(Color::DANGER)
                  ->icon('trash')
                  ->method('remove')
                  ->canSee((bool)$this->reservationExists()),

            Link::make('Вернуться к списку')
                ->type(Color::BASIC)
                ->icon('arrow-return-left')
                ->route('platform.reservations')
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            ReservationEditLayout::class
        ];
    }

    public function store(StoreReservationRequest $request): RedirectResponse
    {
        $this->reservationService->createReservation($request->validated('reservation'));
        Alert::info('You have successfully created a reservation.');
        return redirect()->route('platform.reservations');
    }

    public function update(Reservation $reservation, UpdateReservationRequest $request): RedirectResponse
    {
        $reservation->update($request->validated('reservation'));
        Alert::info('You have successfully updated a reservation.');
        return redirect()->route('platform.reservations');
    }

    public function remove(Reservation $reservation): RedirectResponse
    {
        $reservation->delete();
        Alert::info('You have successfully deleted the reservation.');
        return redirect()->route('platform.periods');
    }
}
