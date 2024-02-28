<?php

namespace App\Orchid\Screens\ServiceCategory;

use App\Models\ServiceCategory;
use App\Orchid\Layouts\ServiceCategory\ServiceCategoryListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Color;

class ServiceCategoryListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'serviceCategories' => ServiceCategory::paginate(20)
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Категории услуг';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Создать категорию')
                ->type(Color::PRIMARY)
                ->icon('plus-square-fill')
                ->route('platform.serviceCategories.create')
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
            ServiceCategoryListLayout::class
        ];
    }
}
