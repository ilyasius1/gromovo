<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Price;

use App\Models\Price;
use App\Orchid\Layouts\Price\PriceListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Color;

class PriceListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'prices' => Price::filters()
                             ->with('cottageType:id,name', 'package:id,name', 'period:id,name,start,end')
                             ->select(
                                 'id',
                                 'name',
                                 'cottage_type_id',
                                 'period_id',
                                 'package_id',
                                 'rate',
                                 'is_active',
                                 'created_at',
                                 'updated_at'
                             )
                             ->defaultSort('id')
                             ->paginate(20)
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Список цен';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Создать цену')
                ->type(Color::PRIMARY)
                ->icon('plus-square-fill')
                ->route('platform.prices.create')
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
            PriceListLayout::class
        ];
    }
}
