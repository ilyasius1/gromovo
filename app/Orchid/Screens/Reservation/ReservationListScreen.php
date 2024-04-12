<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Reservation;

use App\Orchid\Layouts\Reservation\ReservationListLayout;
use App\QueryBuilders\ReservationsQueryBuilder;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Color;

class ReservationListScreen extends Screen
{
    protected string $description = 'Список броней';
    protected ReservationsQueryBuilder $queryBuilder;

    public function __construct(ReservationsQueryBuilder $reservationsQueryBuilder)
    {
        $this->queryBuilder = $reservationsQueryBuilder;
    }

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'reservations' => $this->queryBuilder->paginateWithRelations(true, 'id', 20),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Список броней';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Создать бронь')
                ->type(Color::PRIMARY)
                ->icon('plus-square-fill')
                ->route('platform.reservations.create')
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
            ReservationListLayout::class
        ];
    }
}
