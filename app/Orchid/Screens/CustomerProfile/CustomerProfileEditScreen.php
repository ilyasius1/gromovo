<?php

declare(strict_types=1);

namespace App\Orchid\Screens\CustomerProfile;

use App\Http\Requests\CustomerProfile\StoreCustomerProfileRequest;
use App\Http\Requests\CustomerProfile\UpdateCustomerProfileRequest;
use App\Models\CustomerProfile;
use App\Orchid\Layouts\CustomerProfile\CustomerProfileEditLayout;
use Illuminate\Http\RedirectResponse;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Alert;

class CustomerProfileEditScreen extends Screen
{
    protected ?CustomerProfile $customerProfile = null;

    /**
     *
     * @return bool
     */
    protected function customerProfileExists(): bool
    {
        return (bool)$this->customerProfile?->exists;
    }

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(CustomerProfile $customerProfile): iterable
    {
        $this->customerProfile = $customerProfile;
        return [
            'customerProfile' => $customerProfile,
            'customerProfileExists' => $this->customerProfileExists()
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->customerProfileExists()
            ? 'Редактирование анкеты клиента id# ' . $this->customerProfile->id
            : 'Создание анкеты клиента';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Создать анкету')
                  ->type(Color::SUCCESS)
                  ->icon('save')
                  ->method('store')
                  ->canSee(!$this->customerProfileExists()),

            Button::make('Сохранить')
                  ->type(Color::SUCCESS)
                  ->icon('save')
                  ->method('update')
                  ->canSee((bool)$this->customerProfileExists()),

            Button::make('Remove')
                  ->type(Color::DANGER)
                  ->icon('trash')
                  ->method('remove')
                  ->canSee((bool)$this->customerProfileExists()),

            Link::make('Вернуться к списку')
                ->type(Color::BASIC)
                ->icon('arrow-return-left')
                ->route('platform.customerProfiles')
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
            CustomerProfileEditLayout::class
        ];
    }

    public function store(StoreCustomerProfileRequest $request): RedirectResponse
    {
        CustomerProfile::create($request->validated('customerProfile'));
        Alert::info('You have successfully created a customer profile.');
        return redirect()->route('platform.customerProfiles');
    }

    public function update(CustomerProfile $customerProfile, UpdateCustomerProfileRequest $request): RedirectResponse
    {
        $customerProfile->update($request->validated('customerProfile'));
        Alert::info('You have successfully updated a customer profile.');
        return redirect()->route('platform.customerProfiles');
    }

    public function remove(CustomerProfile $customerProfile): RedirectResponse
    {
        $customerProfile->delete();
        Alert::info('You have successfully deleted the customer profile.');
        return redirect()->route('platform.periods');
    }
}
