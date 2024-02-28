<?php

namespace App\Orchid\Layouts\ServiceCategory;


use App\Models\ServiceCategory;
use Carbon\CarbonImmutable;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class ServiceCategoryListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'serviceCategories';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('id', 'id')
                ->render(function (ServiceCategory $serviceCategory) {
                    return Link::make((string)$serviceCategory->id)
                        ->route('platform.serviceCategories.edit', $serviceCategory);
                }),
            TD::make('name', 'Название')
                ->render(function (ServiceCategory $serviceCategory) {
                    return Link::make((string)$serviceCategory->name)
                        ->route('platform.serviceCategories.edit', $serviceCategory);
                }),
            TD::make('created_at', 'Дата создания')
                ->render(function (ServiceCategory $serviceCategory){
                    return CarbonImmutable::make($serviceCategory->created_at)->format('d.m.Y H:i:s');
                })
                ->defaultHidden(),
            TD::make('updated_at', 'Дата изменения')
                ->render(function (ServiceCategory $serviceCategory){
                    return CarbonImmutable::make($serviceCategory->updated_at)->format('d.m.Y H:i:s');
                })
                ->defaultHidden()
        ];
    }
}
