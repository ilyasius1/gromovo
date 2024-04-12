<?php

namespace App\Orchid\Screens\CustomerProfile;

use App\Models\CustomerProfile;
use App\Orchid\Layouts\CustomerProfile\CustomerProfileListLayout;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Color;

class CustomerProfileListScreen extends Screen
{
    protected string $name = 'Анкеты клиентов';
    protected string $description = 'Список анкет клиентов';

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'customerProfiles' => CustomerProfile::filters()->defaultSort('id')->paginate(20)
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Список анкет';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Создать анкету')
                ->type(Color::PRIMARY)
                ->icon('plus-square-fill')
                ->route('platform.customerProfiles.create')
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
            CustomerProfileListLayout::class
        ];
    }
}
