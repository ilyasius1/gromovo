<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Gallery;

use App\Http\Requests\Gallery\StoreGalleryRequest;
use App\Http\Requests\Gallery\UpdateGalleryRequest;
use App\Models\Gallery;
use App\Services\GalleryService;
use Illuminate\Http\RedirectResponse;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class GalleryEditScreen extends Screen
{
    protected ?Gallery $gallery = null;

    /**
     * @return bool
     */
    protected function galleryExists(): bool
    {
        return (bool)$this->gallery?->exists;
    }

    public function __construct(
        protected GalleryService $galleryService
    )
    {
    }

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Gallery $gallery): iterable
    {
        $this->gallery = $gallery;
        return [
            'gallery' => $gallery,
            'galleryExists' => $this->galleryExists()
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->galleryExists() ? 'Редактирование галереи ' . $this->gallery->name : 'Создание галереи';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Создать галерею')
                  ->type(Color::SUCCESS)
                  ->icon('save')
                  ->method('store')
                  ->canSee(!$this->galleryExists()),

            Button::make('Сохранить')
                  ->type(Color::SUCCESS)
                  ->icon('save')
                  ->method('update')
                  ->canSee((bool)$this->galleryExists()),

            Button::make('Remove')
                  ->type(Color::DANGER)
                  ->icon('trash')
                  ->method('remove')
                  ->canSee((bool)$this->galleryExists()),

            Link::make('Вернуться к списку')
                ->type(Color::BASIC)
                ->icon('arrow-return-left')
                ->route('platform.galleries')
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
            Layout::rows([
                Input::make('gallery.name')
                     ->required()
                     ->title('Название')
                     ->placeholder('Название галереи'),
                Input::make('gallery.name_eng')
                     ->title('nameEng')
                     ->disabled(),
                Input::make('gallery.description')
                     ->required()
                     ->title('Описание')
                     ->placeholder('Описание галереи'),
            ]),
            Layout::wrapper('admin.gallery', [
                'imagesLayout' => Layout::view('admin.gallery_images', ['gallery' => $this->gallery->images]),
                'fields' => Layout::columns([
                    Layout::rows([
                        Upload::make("images")
                              ->title('Добавить фотографии')
                              ->acceptedFiles('image/*')
                              ->maxFileSize(20)
                              ->horizontal(),
                    ])
                ])
            ]),
        ];
    }

    /**
     * @param StoreGalleryRequest $request
     * @return RedirectResponse
     */
    public function store(StoreGalleryRequest $request): RedirectResponse
    {
        $this->galleryService->createGallery($request->validated());
        Alert::info('You have successfully created a gallery.');
        return redirect()->route('platform.galleries');
    }

    /**
     * @param Gallery $gallery
     * @param UpdateGalleryRequest $request
     * @return RedirectResponse
     */
    public function update(Gallery $gallery, UpdateGalleryRequest $request): RedirectResponse
    {
        $this->galleryService->updateGallery($gallery, $request->validated());
        Alert::info('You have successfully updated a gallery.');
        return redirect()->route('platform.galleries');
    }

    /**
     * @param Gallery $gallery
     * @return RedirectResponse
     */
    public function remove(Gallery $gallery): RedirectResponse
    {
        $this->galleryService->deleteGallery($gallery);
        Alert::info('You have successfully deleted the gallery.');
        return redirect()->route('platform.galleries');
    }
}
