<?php

declare(strict_types=1);

namespace App\Orchid\Screens\CottageType;

use App\Http\Requests\CottageType\StoreCottageTypeRequest;
use App\Http\Requests\CottageType\UpdateCottageTypeRequest;
use App\Models\CottageType;
use Illuminate\Http\RedirectResponse;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class CottageTypeEditScreen extends Screen
{
    protected ?CottageType $cottageType = null;

    /**
     * Is cottage type exists
     *
     * @return bool
     */
    protected function cottageTypeExists(): bool
    {
        return (bool)$this->cottageType?->exists;
    }

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(CottageType $cottageType): iterable
    {
        $this->cottageType = $cottageType;
        return [
            'cottageType' => $cottageType
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->cottageTypeExists() ? 'Редактирование типа коттеджей ' . $this->cottageType->name : 'Создание типа коттеджей';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Создать тип коттеджа')
                  ->type(Color::SUCCESS)
                  ->icon('save')
                  ->method('store')
                  ->canSee(!$this->cottageTypeExists()),

            Button::make('Сохранить')
                  ->type(Color::SUCCESS)
                  ->icon('save')
                  ->method('update')
                  ->canSee($this->cottageTypeExists()),

            Button::make('Remove')
                  ->type(Color::DANGER)
                  ->icon('trash')
                  ->method('remove')
                  ->canSee($this->cottageTypeExists()),

            Link::make('Вернуться к списку')
                ->type(Color::BASIC)
                ->icon('arrow-return-left')
                ->route('platform.cottageTypes')
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
                Input::make('cottageType.name')
                     ->title('Название')
                     ->placeholder('Введите название')
                     ->help(''),
                Input::make('cottageType.main_places')
                     ->type('number')
                     ->min(0)
                     ->title('Количество основных мест')
                     ->placeholder('Количество основных мест'),
                Input::make('cottageType.additional_places')
                     ->type('number')
                     ->min(0)
                     ->title('Количество дополнительных мест')
                     ->placeholder('Количество дополнительных мест'),
                Input::make('cottageType.children_places')
                     ->type('number')
                     ->min(0)
                     ->title('Количество дополнительных места для детей от 3 до 12 лет')
                     ->placeholder('Количество дополнительных места для детей от 3 до 12 лет'),

                Button::make('Создать тип коттеджа')
                      ->type(Color::SUCCESS)
                      ->icon('save')
                      ->method('store')
                      ->canSee(!$this->cottageTypeExists()),
                Button::make('Сохранить')
                      ->type(Color::SUCCESS)
                      ->icon('save')
                      ->method('update')
                      ->canSee($this->cottageTypeExists())
            ])
        ];
    }

    /**
     * @param CottageType $cottageType
     * @param UpdateCottageTypeRequest $request
     * @return RedirectResponse
     */
    public function update(CottageType $cottageType, UpdateCottageTypeRequest $request): RedirectResponse//: RedirectResponse
    {
        $cottageType->update($request->validated('cottageType'));
        Alert::info('You have successfully updated a cottage type.');
        return redirect()->route('platform.cottageTypes');
    }

    /**
     * @param StoreCottageTypeRequest $request
     * @return RedirectResponse
     */
    public function store(StoreCottageTypeRequest $request): RedirectResponse
    {
        CottageType::create($request->validated('cottageType'));
        Alert::info('You have successfully created a cottage type.');
        return redirect()->route('platform.cottageTypes');
    }

    /**
     * @param CottageType $cottageType
     * @return RedirectResponse
     */
    public function remove(CottageType $cottageType): RedirectResponse
    {
        $cottageType->delete();
        Alert::info('You have successfully deleted the cottage.');
        return redirect()->route('platform.cottageTypes');
    }
}
