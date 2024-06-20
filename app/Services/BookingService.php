<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\DayOfWeek;
use App\Enums\BookingStatus;
use App\Exceptions\CottageIsBookedException;
use App\Exceptions\NoPricesException;
use App\Exceptions\WrongBookingPriceException;
use App\Jobs\SendBookingConfirmation;
use App\Mail\BookingCreated;
use App\Models\CustomerProfile;
use App\Models\Price;
use App\Models\Booking;
use App\QueryBuilders\PricesQueryBuilder;
use App\QueryBuilders\BookingsQueryBuilder;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Mail;

/**
 *
 */
class BookingService
{
    protected const ADDITIONAL_PLACE_RATIO = 0.10;
    protected const CHILDREN_PLACE_RATIO = 0.05;

    public function __construct(
        protected PricesQueryBuilder   $pricesQueryBuilder,
        protected BookingsQueryBuilder $bookingsQueryBuilder
    )
    {
    }

    /**
     * Расчёт стоимости
     *
     * @param int|string $cottageId
     * @param string $start
     * @param string $end
     * @param int $additionalPlaces
     * @param int $childrenPlaces
     * @return int
     * @throws NoPricesException
     * @throws CottageIsBookedException
     */
    public function calculatePrice(int|string $cottageId, string $start, string $end, int $additionalPlaces = 0, int $childrenPlaces = 0): int
    {
        if ($this->isCottageBooked($cottageId, $start, $end)) {
            throw new CottageIsBookedException();
        }
        $st = Carbon::make($start);
        $en = Carbon::make($end);
        $isFullMonth = $st->day === 1 && $st->isSameMonth($en) && $en->isLastOfMonth();
        $prices = $this->pricesQueryBuilder->getByCottageAndDates($cottageId, CarbonImmutable::make($start), CarbonImmutable::make($end), $isFullMonth);
        $hasHolidayPrice = $prices->contains(fn($price) => $price->period->is_holiday);
        $hasNotHolidayPrice = $prices->contains(fn($price) => !$price->period->is_holiday);
        if ($prices->isEmpty() || ($hasHolidayPrice && $hasNotHolidayPrice)) {
            throw new NoPricesException(code: 409);
        }
        $firstPrice = $prices->first();
        if ($isFullMonth && $firstPrice->package->nights === 30) {
            return (int)round(
                $firstPrice->rate * (
                    1
                    + BookingService::ADDITIONAL_PLACE_RATIO * $additionalPlaces
                    + BookingService::CHILDREN_PLACE_RATIO * $childrenPlaces)
            );
        }
        $period = CarbonPeriod::create($start, $end);
        $dates = collect($period->toArray());
        $amount = 0.;
        $res = $this->usePrices($prices, $dates, $amount);
        if (!$res) {
            throw new NoPricesException();
        }
        return (int)round($amount * (1 + BookingService::ADDITIONAL_PLACE_RATIO * $additionalPlaces + BookingService::CHILDREN_PLACE_RATIO * $childrenPlaces));
    }

    /**
     * Проход по ценам и датам
     *
     * @param Collection $prices
     * @param Collection $dates
     * @param int|float $amount
     * @param int $datesOffset
     * @return bool - удалось ли рассчитать цену
     */
    protected function usePrices(Collection $prices, Collection $dates, int|float &$amount, int $datesOffset = 0): bool
    {
        $firstPrice = $prices->first();
        $lastDateOffset = $datesOffset + $firstPrice->package->nights;
        if (
            $datesOffset < $dates->count() - 1
            && $dates->has($datesOffset)
            && $dates->count() - 1 >= $firstPrice->package->nights
            && $dates[$datesOffset] < $firstPrice->period->end
        ) {
            $date = $dates[$datesOffset];
            if (
                (
                    $firstPrice->package->isAnyDay
                    || (
                        $date->dayOfWeekIso >= $firstPrice->package->days_start->value % 7
                        && $date->dayOfWeekIso % 7 < $firstPrice->package->days_end->value
                    )
                )
                && $dates->has($lastDateOffset)
                && (
                    $firstPrice->package->nights === 1
                    || ($date->diffInDays($dates[$lastDateOffset]) === $firstPrice->package->nights
                        && $firstPrice->package->isAnyDay
                        || (
                            $date->dayOfWeekIso === $firstPrice->package->days_start->value
                            && $dates[$lastDateOffset]->dayOfWeekIso === $firstPrice->package->days_end->value
                        )
                    )
                )

            ) {
                if (Carbon::make($firstPrice->period->end)->between($date, $dates[$lastDateOffset], false)) {
                    $priceWithSamePackage = $prices->first(fn(Price $price) => $price->package->id === $firstPrice->package->id && $price->id !== $firstPrice->id
                    );
                    if ($priceWithSamePackage) {
                        $daysInFirstPeriod = $date->diffInDays($date->copy()->lastOfMonth());
                        $daysInSecondPeriod = $priceWithSamePackage->package->nights - $daysInFirstPeriod;
                        $amount += $firstPrice->rate / $firstPrice->package->nights * $daysInFirstPeriod;
                        $amount += $priceWithSamePackage->rate / $priceWithSamePackage->package->nights * $daysInSecondPeriod;
                        $dates->splice($datesOffset, $daysInFirstPeriod);
                        $dates->splice(0, $daysInSecondPeriod);
                    } else {
                        $prices->shift();
                        $datesOffset = 0;
                    }
                } else {
                    $amount += $firstPrice->rate;
                    $dates->splice($datesOffset, $firstPrice->package->nights);
                    $datesOffset = 0;
                }
            } else {
                $datesOffset++;
            }
        } else {
            $prices->shift();
            $datesOffset = 0;
        }
        if ($dates->count() === 1) {
            return true;
        }
        if ($prices->isNotEmpty()) {
            return $this->usePrices($prices, $dates, $amount, $datesOffset);
        } else {
            return false;
        }
    }

    /**
     * Создание бронирования
     *
     * @param array $fields
     * @return Booking
     * @throws CottageIsBookedException
     * @throws NoPricesException
     * @throws WrongBookingPriceException
     */
    public function createBooking(array $fields): Booking
    {
        if ($this->isCottageBooked($fields['cottage_id'],
            $fields['start'],
            $fields['end'],
        )) {
            throw new CottageIsBookedException();
        }
        if ($fields['amount'] != $this->calculatePrice(
                cottageId: $fields['cottage_id'],
                start: $fields['start'],
                end: $fields['end'],
                additionalPlaces: $fields['additional_places'],
                childrenPlaces: $fields['children_places'])
        ) {
            throw new WrongBookingPriceException();
        }
        if (!array_key_exists('customer_profile_id', $fields)) {
            $customerProfileFields = [
                'full_name' => $fields['full_name'],
                'phone' => $fields['phone'],
                'email' => $fields['email'],
                'document_number' => $fields['document_number'],
                'document_issued_by' => $fields['document_issued_by'],
                'document_issued_at' => $fields['document_issued_at'],
                'address' => $fields['address'],
                'birthdate' => $fields['birthdate'],
                'news_subscription' => $fields['news_subscription'],
            ];
            $customerProfile = CustomerProfile::updateOrCreate(
                ['email' => $fields['email']],
                $customerProfileFields
            );
            $fields['customer_profile_id'] = $customerProfile->id;
        }
        $fields['contract_number'] = $this->generateContractNumber();
        $fields['pay_before'] = Date::tomorrow();
        $fields['status'] = BookingStatus::DRAFT;
        $booking = Booking::create($fields);
        SendBookingConfirmation::dispatch($booking);
        return $booking;
    }

    /**
     * Генерация номера договора
     *
     * @return string
     */
    protected function generateContractNumber(): string
    {
        $currentDateString = Date::now()->format('Ymd');
        $lastContract = Booking::query()
                               ->select('contract_number')
                               ->where('contract_number', 'like', "$currentDateString-")
                               ->orderBy('contract_number', 'desc')
                               ->first();
        if ($lastContract) {
            $number = (int)(explode('-', $lastContract['contract_number'])[1]) + 1;
            $contractNumber = $currentDateString
                              . '-'
                              . str_pad((string)++$number, 4, '0', STR_PAD_LEFT);
        } else {
            $contractNumber = $currentDateString . '-0001';
        }
        return $contractNumber;
    }


    /**
     * @param int|string $cottageId
     * @param string|null $start
     * @param string|null $end
     * @return bool
     */
    public function isCottageBooked(int|string $cottageId, ?string $start = null, ?string $end = null): bool
    {
        return $this->bookingsQueryBuilder->isCottageBooked($cottageId, $start, $end);
    }
}
