<?php

namespace App\Orchid\Layouts\Cottage;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Layouts\Rows;
use Orchid\Support\Facades\Layout;

class CottageGalleryEditLayout extends Rows
{
    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    protected $title;

//    protected ?string $galleryName = 'gallery';

    public function __construct(
        private readonly string $galleryName = 'main'
    ) {}

    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */
    protected function fields(): iterable
    {
        return [
            Upload::make("images.$this->galleryName")
                ->title('Добавить фотографии')
                    ->acceptedFiles('image/*')
                ->maxFileSize(20)
                ->horizontal(),
        ];
    }
}
