<?php

namespace App\Orchid\Screens\Package;

use App\Http\Requests\StorePackageRequest;
use App\Http\Requests\UpdatePackageRequest;
use App\Models\Package;
use App\Orchid\Layouts\Package\PackageEditLayout;
use Illuminate\Http\RedirectResponse;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Alert;

class PackageEditScreen extends Screen
{
    protected ?Package $package = null;

    /**
     * Is package exists
     *
     * @return bool
     */
    protected function packageExists(): bool
    {
        return (bool)$this->package?->exists;
    }

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Package $package): iterable
    {
        $this->package = $package;
        return [
            'package' => $package,
            'packageExists' => $this->packageExists()
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->packageExists() ? 'Редактирование пакета ' . $this->package->name : 'Создание пакета';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Создать пакет')
                ->type(Color::SUCCESS)
                ->icon('save')
                ->method('store')
                ->canSee(!$this->packageExists()),

            Button::make('Сохранить')
                ->type(Color::SUCCESS)
                ->icon('save')
                ->method('update')
                ->canSee((bool)$this->packageExists()),

            Button::make('Remove')
                ->type(Color::DANGER)
                ->icon('trash')
                ->method('remove')
                ->canSee((bool)$this->packageExists()),

            Link::make('Вернуться к списку')
                ->type(Color::BASIC)
                ->icon('arrow-return-left')
                ->route('platform.packages')
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
            PackageEditLayout::class
        ];
    }


    /**
     * Save new package
     *
     * @param StorePackageRequest $request
     * @return RedirectResponse
     */
    public function store(StorePackageRequest $request): RedirectResponse
    {
        Package::create($request->validated('package'));
        Alert::info('You have successfully created a package.');
        return redirect()->route('platform.packages');
    }

    /**
     * Update package
     *
     * @param Package $package
     * @param UpdatePackageRequest $request
     * @return RedirectResponse
     */
    public function update(Package $package, UpdatePackageRequest $request): RedirectResponse
    {
        $package->fill($request->validated('package'))->save();
        Alert::info('You have successfully updated a package.');
        return redirect()->route('platform.packages');
    }

    /**
     * Remove package
     *
     * @param Package $package
     * @return RedirectResponse
     */
    public function remove(Package $package): RedirectResponse
    {
        $package->delete();
        Alert::info('You have successfully deleted the package.');
        return redirect()->route('platform.packages');
    }
}
