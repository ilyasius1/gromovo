<?php

declare(strict_types=1);

namespace App\Orchid\Screens\ServiceCategory;

use App\Http\Requests\ServiceCategory\StoreServiceCategoryRequest;
use App\Http\Requests\ServiceCategory\UpdateServiceCategoryRequest;
use App\Models\ServiceCategory;
use Illuminate\Http\RedirectResponse;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class ServiceCategoryEditScreen extends Screen
{
    protected ?ServiceCategory $serviceCategory = null;

    /**
     * Is service category exists
     *
     * @return bool
     */
    protected function serviceCategoryExists(): bool
    {
        return (bool)$this->serviceCategory?->exists;
    }

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(ServiceCategory $serviceCategory): iterable
    {
        $this->serviceCategory = $serviceCategory;
        return [
            'serviceCategory' => $serviceCategory,
            'serviceCategoryExists' => $this->serviceCategoryExists()
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->serviceCategoryExists() ? 'Редактирование категории услуг ' . $this->serviceCategory->name : 'Создание категории услуг';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Создать категорию')
                  ->type(Color::SUCCESS)
                  ->icon('save')
                  ->method('store')
                  ->canSee(!$this->serviceCategoryExists()),

            Button::make('Сохранить')
                  ->type(Color::SUCCESS)
                  ->icon('save')
                  ->method('update')
                  ->canSee((bool)$this->serviceCategoryExists()),

            Button::make('Remove')
                  ->type(Color::DANGER)
                  ->icon('trash')
                  ->method('remove')
                  ->canSee((bool)$this->serviceCategoryExists()),

            Link::make('Вернуться к списку')
                ->type(Color::BASIC)
                ->icon('arrow-return-left')
                ->route('platform.serviceCategories')
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
                Input::make('serviceCategory.name')
                     ->title('Название')
                     ->placeholder('Введите название'),

                Button::make('Создать категорию')
                      ->type(Color::SUCCESS)
                      ->icon('save')
                      ->method('store')
                      ->canSee(!$this->serviceCategoryExists()),
                Button::make('Сохранить')
                      ->type(Color::SUCCESS)
                      ->icon('save')
                      ->method('update')
                      ->canSee($this->serviceCategoryExists())
            ])
        ];
    }

    public function store(StoreServiceCategoryRequest $request): RedirectResponse
    {
        ServiceCategory::create($request->validated('serviceCategory'));
        Alert::info('You have successfully created a price.');
        return redirect()->route('platform.serviceCategories');
    }

    public function update(ServiceCategory $serviceCategory, UpdateServiceCategoryRequest $request): RedirectResponse
    {
        $serviceCategory->update($request->validated('serviceCategory'));
        Alert::info('You have successfully updated a price.');
        return redirect()->route('platform.serviceCategories');
    }

    public function remove(ServiceCategory $serviceCategory): RedirectResponse
    {
        $serviceCategory->delete();
        Alert::info('You have successfully deleted the price.');
        return redirect()->route('platform.serviceCategories');
    }
}
