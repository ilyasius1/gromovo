<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Period;

use App\Models\Period;
use App\Orchid\Layouts\Period\PeriodListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Color;

class PeriodListScreen extends Screen
{
    protected string $name = 'Периоды';

    protected string $description = 'Список периодов';

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'periods' => Period::filters()->defaultSort('id')->paginate(20)
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Список периодов';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Создать период')
                ->type(Color::PRIMARY)
                ->icon('plus-square-fill')
                ->route('platform.periods.create')
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
            PeriodListLayout::class
        ];
    }
}
