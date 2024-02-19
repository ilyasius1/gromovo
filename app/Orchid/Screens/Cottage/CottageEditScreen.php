<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Cottage;

use App\Http\Requests\StoreCottageRequest;
use App\Http\Requests\UpdateCottageRequest;
use App\Models\Cottage;
use App\Models\Image;
use App\Orchid\Layouts\Cottage\CottageEditLayout;
use App\Orchid\Layouts\Cottage\CottageGalleryEditLayout;
use App\Orchid\Presenters\CottagePresenter;
use App\Services\CottageService;
use Illuminate\Http\RedirectResponse;
use Orchid\Attachment\Models\Attachment;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class CottageEditScreen extends Screen
{
    protected ?Cottage $cottage = null;

    /**
     * Is cottage exists
     *
     * @return bool
     */
    protected function cottageExists(): bool
    {
        return (bool)$this->cottage?->exists;
    }

    /**
     * @param CottageService $cottageService
     */
    public function __construct(
        protected CottageService $cottageService,
    )
    {
    }


    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Cottage $cottage): iterable
    {
        $this->cottage = $cottage;
        return [
            'cottage' => $cottage,
            'cottageExists' => $this->cottageExists(),
            'presenter' => new CottagePresenter($cottage)
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->cottageExists() ? 'Редактирование коттеджа ' . $this->cottage->name : 'Create cottage';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Создать коттедж')
                ->type(Color::SUCCESS)
                ->icon('save')
                ->method('store')
                ->canSee(!$this->cottageExists()),

            Button::make('Сохранить')
                ->type(Color::SUCCESS)
                ->icon('save')
                ->method('update')
                ->canSee((bool)$this->cottageExists()),

            Button::make('Remove')
                ->type(Color::DANGER)
                ->icon('trash')
                ->method('remove')
                ->canSee((bool)$this->cottageExists()),

            Link::make('Вернуться к списку')
                ->type(Color::BASIC)
                ->icon('arrow-return-left')
                ->route('platform.cottages')
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
            Layout::columns([
                CottageEditLayout::class,
            ]),
            Layout::accordion([
                'Галерея' => Layout::wrapper('admin.gallery', [
                        'gallery' => Layout::view('admin.gallery_images',  [ 'gallery' => $this->cottage?->mainGallery]),
                        'fields' => Layout::columns([
                            new CottageGalleryEditLayout('main')
                        ])
                ]),
                $this->cottage?->name . ' план' => Layout::wrapper('admin.gallery', [
                    'gallery' => Layout::view('admin.gallery_images',  [ 'gallery' => $this->cottage?->schemaGallery]),
                    'fields' => Layout::columns([
                        new CottageGalleryEditLayout('schema')
                    ])
                ]),
                $this->cottage?->name . ' зимой' => Layout::wrapper('admin.gallery', [
                    'gallery' => Layout::view('admin.gallery_images',  [ 'gallery' => $this->cottage?->winterGallery]),
                    'fields' => Layout::columns([
                        new CottageGalleryEditLayout('winter')])
                ]),
                $this->cottage?->name . ' летом' => Layout::wrapper('admin.gallery', [
                    'gallery' => Layout::view('admin.gallery_images',  [ 'gallery' => $this->cottage?->summerGallery]),
                    'fields' => Layout::columns([
                        new CottageGalleryEditLayout('summer')])
                ]),
            ])->canSee($this->cottageExists()),
        ];
    }

    /**
     * Update cottage
     *
     * @param Cottage $cottage
     * @param UpdateCottageRequest $request
     * @return RedirectResponse
     */
    public function update(Cottage $cottage, UpdateCottageRequest $request): RedirectResponse//: RedirectResponse
    {
        $attachmentsArray = $request->validated('images')?? [];
        $attachments = Attachment::findMany($attachmentsArray);
        foreach ($attachmentsArray as $key => $attachments_block) {
            $galleryField = $key . '_gallery_id';
            $gallery_id = $cottage->$galleryField;
            foreach ($attachments_block as $attachment_id) {
                $attachment = $attachments->find($attachment_id);
                Image::create([
                    'name' => $attachment->original_name,
                    'gallery_id' => $gallery_id,
                    'attachment_id' => $attachment_id
                ]);
            }
        }

        $cottage->fill($request->validated('cottage'))->save();
        Alert::info('You have successfully created a cottage.');
        return redirect()->route('platform.cottages');
    }

    /**
     * Store new cottage
     *
     * @param StoreCottageRequest $request
     * @return RedirectResponse
     */
    public function store(StoreCottageRequest $request): RedirectResponse
    {
        $cottage = $this->cottageService->createCottage($request->validated('cottage'));
        Alert::info('You have successfully created a cottage.');
        return redirect()->route('platform.cottages.edit', ['cottage' => $cottage]);
    }

    /**
     * Remove cottage
     *
     * @param Cottage $cottage
     * @return RedirectResponse
     */
    public function remove(Cottage $cottage): RedirectResponse
    {
        $this->cottageService->deleteCottage($cottage);
        Alert::info('You have successfully deleted the cottage.');
        return redirect()->route('platform.cottages');
    }
}
