<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Booking;

use App\Http\Requests\Booking\StoreBookingRequest;
use App\Http\Requests\Booking\UpdateBookingRequest;
use App\Models\Booking;
use App\Orchid\Layouts\Booking\BookingEditLayout;
use App\Services\BookingService;
use Illuminate\Http\RedirectResponse;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Alert;

class BookingEditScreen extends Screen
{
    protected ?Booking $booking = null;


    public function __construct(protected BookingService $bookingService)
    {
    }

    protected function bookingExists(): bool
    {
        return (bool)$this->booking?->exists;
    }

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Booking $booking): iterable
    {
        $this->booking = $booking;
        return [
            'booking' => $this->booking,
            'bookingExists' => $this->bookingExists()
        ];
    }


    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->bookingExists()
            ? 'Редактирование брони id# ' . $this->booking->id
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
                  ->canSee(!$this->bookingExists()),

            Button::make('Сохранить')
                  ->type(Color::SUCCESS)
                  ->icon('save')
                  ->method('update')
                  ->canSee((bool)$this->bookingExists()),

            Button::make('Remove')
                  ->type(Color::DANGER)
                  ->icon('trash')
                  ->method('remove')
                  ->canSee((bool)$this->bookingExists()),

            Link::make('Вернуться к списку')
                ->type(Color::BASIC)
                ->icon('arrow-return-left')
                ->route('platform.bookings')
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
            BookingEditLayout::class
        ];
    }

    public function store(StoreBookingRequest $request): RedirectResponse
    {
        $this->bookingService->createBooking($request->validated('booking'));
        Alert::info('You have successfully created a booking.');
        return redirect()->route('platform.booking
        s');
    }

    public function update(Booking $booking, UpdateBookingRequest $request): RedirectResponse
    {
        $booking->update($request->validated('booking'));
        Alert::info('You have successfully updated a booking.');
        return redirect()->route('platform.booking
        s');
    }

    public function remove(Booking $booking): RedirectResponse
    {
        $booking->delete();
        Alert::info('You have successfully deleted the booking.');
        return redirect()->route('platform.periods');
    }
}
