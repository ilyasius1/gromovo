<?php

namespace App\Orchid\Screens\CottageType;

use App\Models\CottageType;
use Carbon\CarbonImmutable;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\DateRange;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;

class CottageTypeListScreen extends Screen
{
    public string $name = 'Типы коттеджей';

    public string $description = 'Список типов коттеджей';

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'cottageTypes' => CottageType::paginate(10)
        ];
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Создать тип коттеджей')
                ->type(Color::PRIMARY)
                ->icon('plus-square-fill')
                ->route('platform.cottageTypes.create')
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
            Layout::table('cottageTypes', [
                TD::make('id', 'id')
                    ->render(function (CottageType $cottageType) {
                        return Link::make((string)$cottageType->id)
                            ->route('platform.cottageTypes.edit', $cottageType);
                    }),
                TD::make('name', 'Название')
                    ->render(function (CottageType $cottageType) {
                        return Link::make($cottageType->name)
                            ->route('platform.cottageTypes.edit', $cottageType);
                    }),
                TD::make('created_at', 'Дата создания')
                    ->sort()
                    ->filter(DateRange::make())
                    ->render(function (CottageType $cottageType){
                        return CarbonImmutable::make($cottageType->created_at)
                            ->format('d.m.Y H:i:s');
                    })->defaultHidden(),
                TD::make('updated_at', 'Дата изменения')
                    ->sort()
                    ->filter(DateRange::make())
                    ->render(function (CottageType $cottageType){
                        return CarbonImmutable::make($cottageType->updated_at)
                            ->format('d.m.Y H:i:s');
                    })->defaultHidden()
            ])
        ];
    }
}
