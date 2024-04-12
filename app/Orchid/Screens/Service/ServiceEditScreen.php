<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Service;

use App\Http\Requests\Service\StoreServiceRequest;
use App\Http\Requests\Service\UpdateServiceRequest;
use App\Models\Service;
use App\Orchid\Layouts\Service\ServiceEditLayout;
use Illuminate\Http\RedirectResponse;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Alert;

class ServiceEditScreen extends Screen
{
    protected ?Service $service = null;

    /**
     * Is service exists
     *
     * @return bool
     */
    protected function serviceExists(): bool
    {
        return (bool)$this->service?->exists;
    }

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Service $service): iterable
    {
        $this->service = $service;
        return [
            'service' => $service,
            'serviceExists' => $this->serviceExists()
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->serviceExists() ? 'Редактирование услуги ' . $this->service->name : 'Создание услуги';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Создать услугу')
                  ->type(Color::SUCCESS)
                  ->icon('save')
                  ->method('store')
                  ->canSee(!$this->serviceExists()),

            Button::make('Сохранить')
                  ->type(Color::SUCCESS)
                  ->icon('save')
                  ->method('update')
                  ->canSee((bool)$this->serviceExists()),

            Button::make('Remove')
                  ->type(Color::DANGER)
                  ->icon('trash')
                  ->method('remove')
                  ->canSee((bool)$this->serviceExists()),

            Link::make('Вернуться к списку')
                ->type(Color::BASIC)
                ->icon('arrow-return-left')
                ->route('platform.services')
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
            ServiceEditLayout::class
        ];
    }

    public function store(StoreServiceRequest $request): RedirectResponse
    {
        Service::create($request->validated('service'));
        Alert::info('You have successfully created a service.');
        return redirect()->route('platform.services');
    }

    public function update(Service $service, UpdateServiceRequest $request): RedirectResponse
    {
        $service->update($request->validated('service'));
        Alert::info('You have successfully updated a service.');
        return redirect()->route('platform.services');
    }

    public function remove(Service $service): RedirectResponse
    {
        $service->delete();
        Alert::info('You have successfully deleted the service.');
        return redirect()->route('platform.services');
    }
}
