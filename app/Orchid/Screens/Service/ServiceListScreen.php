<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Service;

use App\Models\Service;
use App\Models\ServiceCategory;
use App\Orchid\Layouts\Service\ServiceListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Color;

class ServiceListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'services' => Service::with('serviceCategory')
                                 ->filters()
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
        return 'Список услуг';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Создать услугу')
                ->type(Color::PRIMARY)
                ->icon('plus-square-fill')
                ->route('platform.services.create')
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
            ServiceListLayout::class
        ];
    }
}
