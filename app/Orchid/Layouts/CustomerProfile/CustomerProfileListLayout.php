<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\CustomerProfile;

use App\Models\Cottage;
use App\Models\CustomerProfile;
use Carbon\CarbonImmutable;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class CustomerProfileListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'customerProfiles';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('id', 'id')
              ->sort()
              ->filter(Input::make())
              ->render(function (CustomerProfile $customerProfile) {
                  return Link::make((string)$customerProfile->id)
                             ->route('platform.customerProfiles.edit', $customerProfile);
              }),
            TD::make('full_name', 'Полное имя')
              ->sort()
              ->filter(Input::make())
              ->render(function (CustomerProfile $customerProfile) {
                  return Link::make((string)$customerProfile->full_name)
                             ->route('platform.customerProfiles.edit', $customerProfile);
              }),
            TD::make('birthdate', 'Дата рождения')
              ->render(function (CustomerProfile $customerProfile) {
                  return CarbonImmutable::make($customerProfile->birthdate)->format('d.m.Y');
              }),
            TD::make('phone', 'Телефон'),
            TD::make('email', 'E-mail'),
            TD::make('document_number', 'document_number'),
            TD::make('document_issued_by', 'document_issued_by'),
            TD::make('document_issued_at', 'Дата выдачи')
              ->render(function (CustomerProfile $customerProfile) {
                  return CarbonImmutable::make($customerProfile->document_issued_at)->format('d.m.Y');
              }),
            TD::make('is_active', 'Подписка на новости')
              ->filter(Select::make('news_subscription')
                             ->empty('Все')
                             ->options([
                                 'true' => 'Да',
                                 'false' => 'Нет'
                             ])
                             ->title('Subscription?')
              )
              ->render(function (CustomerProfile $customerProfile) {
                  return $customerProfile->news_subscription ? 'Да' : 'Нет';
              }),
            TD::make('created_at', 'Дата создания')
              ->render(function (CustomerProfile $customerProfile) {
                  return CarbonImmutable::make($customerProfile->created_at)->format('d.m.Y H:i:s');
              })
              ->defaultHidden(),
            TD::make('updated_at', 'Дата изменения')
              ->render(function (CustomerProfile $customerProfile) {
                  return CarbonImmutable::make($customerProfile->created_at)->format('d.m.Y H:i:s');
              })
              ->defaultHidden()
        ];
    }
}
