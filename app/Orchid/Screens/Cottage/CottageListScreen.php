<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Cottage;

use App\Models\Cottage;
use App\Orchid\Layouts\Cottage\CottageListLayout;
use App\QueryBuilders\CottagesQueryBuilder;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Color;

class CottageListScreen extends Screen
{
    protected string $name = 'Коттеджи';

    protected string $description = 'Список коттеджей';

    protected CottagesQueryBuilder $cottagesQueryBuilder;

    public function __construct(CottagesQueryBuilder $cottagesQueryBuilder)
    {
        $this->cottagesQueryBuilder = $cottagesQueryBuilder;
    }

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'cottages' => Cottage::with('cottageType')
                                ->select('id','name', 'cottage_type_id', 'area' ,'floors','is_active')
                                ->filters()->defaultSort('id')
                                ->paginate(20)
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
            Link::make('Создать коттедж')
                ->type(Color::PRIMARY)
                ->icon('plus-square-fill')
                ->route('platform.cottages.create')
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
            CottageListLayout::class
        ];
    }

}
