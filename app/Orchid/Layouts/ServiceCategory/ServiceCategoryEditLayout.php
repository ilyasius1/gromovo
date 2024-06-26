<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\ServiceCategory;

use Orchid\Screen\Field;
use Orchid\Screen\Layouts\Rows;

class ServiceCategoryEditLayout extends Rows
{
    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    protected $title;

    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */
    protected function fields(): iterable
    {
        return [];
    }
}
