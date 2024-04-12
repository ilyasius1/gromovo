<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Package;

use App\Models\Package;
use App\Orchid\Layouts\Package\PackageListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Color;

class PackageListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'packages' => Package::filters()->defaultSort('id')->paginate(20)
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Список пакетов';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Создать пакет')
                ->type(Color::PRIMARY)
                ->icon('plus-square-fill')
                ->route('platform.packages.create')
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
            PackageListLayout::class
        ];
    }
}
