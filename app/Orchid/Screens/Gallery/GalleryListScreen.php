<?php

namespace App\Orchid\Screens\Gallery;

use App\Models\Gallery;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;

class GalleryListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'galleries' => Gallery::paginate(20)
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Список галерей';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Создать ')
                ->type(Color::PRIMARY)
                ->icon('plus-square-fill')
                ->route('platform.galleries.create')
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
            Layout::table('galleries', [
                TD::make('id', 'id')
                    ->render(function (Gallery $gallery) {
                        return Link::make((string)$gallery->id)
                            ->route('platform.galleries.edit', $gallery);
                    }),
                TD::make('name', 'Название')
                    ->render(function (Gallery $gallery) {
                        return Link::make((string)$gallery->name)
                            ->route('platform.galleries.edit', $gallery);
                    }),
                TD::make('name_eng', 'name_eng'),
                TD::make('description', 'Описание'),
                TD::make('main_image_id', 'main_image_id'),
                TD::make('created_at', 'Дата создания')->defaultHidden(),
                TD::make('updated_at', 'Дата изменения')->defaultHidden()
            ])
        ];
    }
}
