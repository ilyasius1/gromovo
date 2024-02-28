<?php

namespace App\Orchid\Screens\Price;

use App\Http\Requests\StorePriceRequest;
use App\Http\Requests\UpdatePriceRequest;
use App\Models\Price;
use App\Orchid\Layouts\Price\PriceEditLayout;
use Illuminate\Http\RedirectResponse;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Switcher;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class PriceEditScreen extends Screen
{
    protected ?Price $price = null;

    /**
     * Is price exists
     *
     * @return bool
     */
    protected function priceExists(): bool
    {
        return (bool)$this->price?->exists;
    }

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Price $price): iterable
    {
        $this->price = $price;
        return [
            'price' => $price,
            'priceExists' => $this->priceExists()
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->priceExists() ? 'Редактирование цены ' . $this->price->name : 'Создание цены';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Создать цену')
                ->type(Color::SUCCESS)
                ->icon('save')
                ->method('store')
                ->canSee(!$this->priceExists()),

            Button::make('Сохранить')
                ->type(Color::SUCCESS)
                ->icon('save')
                ->method('update')
                ->canSee((bool)$this->priceExists()),

            Button::make('Remove')
                ->type(Color::DANGER)
                ->icon('trash')
                ->method('remove')
                ->canSee((bool)$this->priceExists()),

            Link::make('Вернуться к списку')
                ->type(Color::BASIC)
                ->icon('arrow-return-left')
                ->route('platform.prices')
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
            PriceEditLayout::class
        ];
    }

    public function store(StorePriceRequest $request): RedirectResponse
    {
        Price::create($request->validated('price'));
        Alert::info('You have successfully created a price.');
        return redirect()->route('platform.prices');
    }

    public function update(Price $price, UpdatePriceRequest $request): RedirectResponse
    {
        $price->fill($request->validated('price'))->save();
        Alert::info('You have successfully updated a price.');
        return redirect()->route('platform.prices');
    }

    public function remove(Price $price): RedirectResponse
    {
        $price->delete();
        Alert::info('You have successfully deleted the price.');
        return redirect()->route('platform.prices');
    }

}
