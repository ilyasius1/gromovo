<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Period;

use App\Http\Requests\StorePeriodRequest;
use App\Http\Requests\UpdatePeriodRequest;
use App\Models\Period;
use App\Orchid\Layouts\Period\PeriodEditLayout;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Alert;

class PeriodEditScreen extends Screen
{
    protected ?Period $period = null;

    /**
     * Is period exists
     *
     * @return bool
     */
    protected function periodExists(): bool
    {
        return (bool)$this->period?->exists;
    }

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Period $period): iterable
    {
        $this->period = $period;
        return [
            'period' => $period,
            'periodExists' => $this->periodExists()
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->periodExists() ? 'Редактирование периода ' . $this->period->name : 'Создание периода';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Создать период')
                ->type(Color::SUCCESS)
                ->icon('save')
                ->method('store')
                ->canSee(!$this->periodExists()),

            Button::make('Сохранить')
                ->type(Color::SUCCESS)
                ->icon('save')
                ->method('update')
                ->canSee((bool)$this->periodExists()),

            Button::make('Remove')
                ->type(Color::DANGER)
                ->icon('trash')
                ->method('remove')
                ->canSee((bool)$this->periodExists()),

            Link::make('Вернуться к списку')
                ->type(Color::BASIC)
                ->icon('arrow-return-left')
                ->route('platform.periods')
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
            PeriodEditLayout::class
        ];
    }

    /**
     * Save new period
     *
     * @param StorePeriodRequest $request
     * @return RedirectResponse
     */
    public function store(StorePeriodRequest $request): RedirectResponse
    {
        Period::create($request->validated('period'));
        Alert::info('You have successfully created a period.');
        return redirect()->route('platform.periods');
    }

    /**
     * Update period
     *
     * @param Period $period
     * @param UpdatePeriodRequest $request
     * @return RedirectResponse
     */
    public function update(Period $period, UpdatePeriodRequest $request): RedirectResponse
    {
        $period->fill($request->validated('period'))->save();
        Alert::info('You have successfully updated a period.');
        return redirect()->route('platform.periods');
    }

    /**
     * Удалить период
     *
     * @param Period $period
     * @return RedirectResponse
     */
    public function remove(Period $period): RedirectResponse
    {
        $period->delete();
        Alert::info('You have successfully deleted the period.');
        return redirect()->route('platform.periods');
    }
}
