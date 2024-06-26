<?php

declare(strict_types=1);

use App\Orchid\Screens\Cottage\CottageEditScreen;
use App\Orchid\Screens\Cottage\CottageListScreen;
use App\Orchid\Screens\CottageType\CottageTypeEditScreen;
use App\Orchid\Screens\CottageType\CottageTypeListScreen;
use App\Orchid\Screens\CustomerProfile\CustomerProfileEditScreen;
use App\Orchid\Screens\CustomerProfile\CustomerProfileListScreen;
use App\Orchid\Screens\Examples\ExampleActionsScreen;
use App\Orchid\Screens\Examples\ExampleCardsScreen;
use App\Orchid\Screens\Examples\ExampleChartsScreen;
use App\Orchid\Screens\Examples\ExampleFieldsAdvancedScreen;
use App\Orchid\Screens\Examples\ExampleFieldsScreen;
use App\Orchid\Screens\Examples\ExampleGridScreen;
use App\Orchid\Screens\Examples\ExampleLayoutsScreen;
use App\Orchid\Screens\Examples\ExampleScreen;
use App\Orchid\Screens\Examples\ExampleTextEditorsScreen;
use App\Orchid\Screens\Gallery\GalleryEditScreen;
use App\Orchid\Screens\Gallery\GalleryListScreen;
use App\Orchid\Screens\Package\PackageEditScreen;
use App\Orchid\Screens\Package\PackageListScreen;
use App\Orchid\Screens\Period\PeriodEditScreen;
use App\Orchid\Screens\Period\PeriodListScreen;
use App\Orchid\Screens\PlatformScreen;
use App\Orchid\Screens\Price\PriceEditScreen;
use App\Orchid\Screens\Price\PriceListScreen;
use App\Orchid\Screens\Booking\BookingEditScreen;
use App\Orchid\Screens\Booking\BookingListScreen;
use App\Orchid\Screens\Role\RoleEditScreen;
use App\Orchid\Screens\Role\RoleListScreen;
use App\Orchid\Screens\Service\ServiceEditScreen;
use App\Orchid\Screens\Service\ServiceListScreen;
use App\Orchid\Screens\ServiceCategory\ServiceCategoryEditScreen;
use App\Orchid\Screens\ServiceCategory\ServiceCategoryListScreen;
use App\Orchid\Screens\User\UserEditScreen;
use App\Orchid\Screens\User\UserListScreen;
use App\Orchid\Screens\User\UserProfileScreen;
use Illuminate\Support\Facades\Route;
use Tabuna\Breadcrumbs\Trail;

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the need "dashboard" middleware group. Now create something great!
|
*/

// Main
Route::screen('/main', PlatformScreen::class)
    ->name('platform.main');

// Cottage types
Route::screen('cottage-types', CottageTypeListScreen::class)
    ->name('platform.cottageTypes');

// Cottage types > Create
Route::screen('cottage-types/create', CottageTypeEditScreen::class)
    ->name('platform.cottageTypes.create');

// Cottage types > Cottage type
Route::screen('cottage-types/{cottageType}/edit', CottageTypeEditScreen::class)
    ->name('platform.cottageTypes.edit');

// Cottages
Route::screen('cottages', CottageListScreen::class)
    ->name('platform.cottages');

// Cottages > Create
Route::screen('cottages/create', CottageEditScreen::class)
    ->name('platform.cottages.create');

// Cottages > Cottage
Route::screen('cottages/{cottage}/edit', CottageEditScreen::class)
    ->name('platform.cottages.edit');

// Periods
Route::screen('periods', PeriodListScreen::class)
    ->name('platform.periods');

// Periods > Create
Route::screen('periods/create', PeriodEditScreen::class)
    ->name('platform.periods.create');

// Periods > Period
Route::screen('periods/{period}/edit', PeriodEditScreen::class)
    ->name('platform.periods.edit');

// Packages
Route::screen('packages', PackageListScreen::class)
    ->name('platform.packages');

// Packages > Create
Route::screen('packages/create', PackageEditScreen::class)
    ->name('platform.packages.create');

// Packages > Package
Route::screen('packages/{package}/edit', PackageEditScreen::class)
    ->name('platform.packages.edit');

// Prices
Route::screen('prices', PriceListScreen::class)
    ->name('platform.prices');

// Prices > Create
Route::screen('prices/create', PriceEditScreen::class)
    ->name('platform.prices.create');

// Prices > Price
Route::screen('prices/{price}/edit', PriceEditScreen::class)
    ->name('platform.prices.edit');

// ServiceCategories
Route::screen('service-categories', ServiceCategoryListScreen::class)
    ->name('platform.serviceCategories');

// ServiceCategories > Create
Route::screen('service-categories/create', ServiceCategoryEditScreen::class)
    ->name('platform.serviceCategories.create');

// ServiceCategories > ServiceCategory
Route::screen('service-categories/{serviceCategory}/edit', ServiceCategoryEditScreen::class)
    ->name('platform.serviceCategories.edit');

// Services
Route::screen('services', ServiceListScreen::class)
    ->name('platform.services');

// Services > Create
Route::screen('services/create', ServiceEditScreen::class)
    ->name('platform.services.create');

// Services > Service
Route::screen('services/{service}/edit', ServiceEditScreen::class)
    ->name('platform.services.edit');

// Galleries
Route::screen('galleries', GalleryListScreen::class)
    ->name('platform.galleries');

// Galleries > Create
Route::screen('galleries/create', GalleryEditScreen::class)
    ->name('platform.galleries.create');

// Galleries > Gallery
Route::screen('galleries/{gallery}/edit', GalleryEditScreen::class)
    ->name('platform.galleries.edit');

// CustomerProfiles
Route::screen('customer-profiles', CustomerProfileListScreen::class)
     ->name('platform.customerProfiles');

// CustomerProfiles > Create
Route::screen('customer-profiles/create', CustomerProfileEditScreen::class)
     ->name('platform.customerProfiles.create');

// CustomerProfiles > CustomerProfile
Route::screen('customer-profiles/{customerProfile}/edit', CustomerProfileEditScreen::class)
     ->name('platform.customerProfiles.edit');

// Bookings
Route::screen('bookings', BookingListScreen::class)
     ->name('platform.bookings');

// Bookings > Create
Route::screen('bookings/create', BookingEditScreen::class)
     ->name('platform.bookings.create');

// Bookings > Booking
Route::screen('bookings/{booking}/edit', BookingEditScreen::class)
     ->name('platform.bookings.edit');


// Platform > Profile
Route::screen('profile', UserProfileScreen::class)
    ->name('platform.profile')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Profile'), route('platform.profile')));

// Platform > System > Users > User
Route::screen('users/{user}/edit', UserEditScreen::class)
    ->name('platform.systems.users.edit')
    ->breadcrumbs(fn (Trail $trail, $user) => $trail
        ->parent('platform.systems.users')
        ->push($user->name, route('platform.systems.users.edit', $user)));

// Platform > System > Users > Create
Route::screen('users/create', UserEditScreen::class)
    ->name('platform.systems.users.create')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.systems.users')
        ->push(__('Create'), route('platform.systems.users.create')));

// Platform > System > Users
Route::screen('users', UserListScreen::class)
    ->name('platform.systems.users')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Users'), route('platform.systems.users')));

// Platform > System > Roles > Role
Route::screen('roles/{role}/edit', RoleEditScreen::class)
    ->name('platform.systems.roles.edit')
    ->breadcrumbs(fn (Trail $trail, $role) => $trail
        ->parent('platform.systems.roles')
        ->push($role->name, route('platform.systems.roles.edit', $role)));

// Platform > System > Roles > Create
Route::screen('roles/create', RoleEditScreen::class)
    ->name('platform.systems.roles.create')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.systems.roles')
        ->push(__('Create'), route('platform.systems.roles.create')));

// Platform > System > Roles
Route::screen('roles', RoleListScreen::class)
    ->name('platform.systems.roles')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Roles'), route('platform.systems.roles')));

// Example...
Route::screen('example', ExampleScreen::class)
    ->name('platform.example')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Example Screen'));

Route::screen('/examples/form/fields', ExampleFieldsScreen::class)->name('platform.example.fields');
Route::screen('/examples/form/advanced', ExampleFieldsAdvancedScreen::class)->name('platform.example.advanced');
Route::screen('/examples/form/editors', ExampleTextEditorsScreen::class)->name('platform.example.editors');
Route::screen('/examples/form/actions', ExampleActionsScreen::class)->name('platform.example.actions');

Route::screen('/examples/layouts', ExampleLayoutsScreen::class)->name('platform.example.layouts');
Route::screen('/examples/grid', ExampleGridScreen::class)->name('platform.example.grid');
Route::screen('/examples/charts', ExampleChartsScreen::class)->name('platform.example.charts');
Route::screen('/examples/cards', ExampleCardsScreen::class)->name('platform.example.cards');

//Route::screen('idea', Idea::class, 'platform.screens.idea');
