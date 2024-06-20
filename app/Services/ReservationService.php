<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\ReservationStatus;
use App\Exceptions\CottageIsReservedException;
use App\Exceptions\NoPricesException;
use App\Exceptions\WrongReservationAmountException;
use App\Models\CustomerProfile;
use App\Models\Reservation;
use App\QueryBuilders\PricesQueryBuilder;
use App\QueryBuilders\ReservationsQueryBuilder;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Date;

/**
 *
 */
class ReservationService
{
    public function __construct(
        protected PricesQueryBuilder       $pricesQueryBuilder,
        protected ReservationsQueryBuilder $reservationsQueryBuilder
    )
    {
    }

    /**
     * @param int|string $cottage_id
     * @param string $start
     * @param string $end
     * @return int
     * @throws NoPricesException
     */
    public function calculateAmount(int|string $cottage_id, string $start, string $end): int
    {
        $prices = $this->pricesQueryBuilder->getByCottageAndDates($cottage_id, CarbonImmutable::make($start), CarbonImmutable::make($end));
        if ($prices->isEmpty()) {
            throw new NoPricesException(code: 409);
        }
        return 1234;//заглушка
    }

    /**
     * @throws WrongReservationAmountException
     * @throws NoPricesException
     * @throws CottageIsReservedException
     */
    public function createReservation(array $fields): Reservation
    {
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
        $is_free = empty($this->getReservedDates(
            $fields['cottage_id'],
            $fields['start'],
            $fields['end'],
            [ReservationStatus::DRAFT, ReservationStatus::CONFIRMED]
        ));
        if (!$is_free) {
            throw new CottageIsReservedException();
        }
        if ($fields['amount'] != $this->calculateAmount($fields['amount'], $fields['start'], $fields['end'])) {
            throw new WrongReservationAmountException();
        }
        $customerProfile = CustomerProfile::updateOrCreate(
            ['email' => $fields['email']],
            $customerProfileFields
        );
        $fields['customer_profile_id'] = $customerProfile->id;
        $fields['contract_number'] = $this->generateContractNumber();
        $fields['pay_before'] = Date::tomorrow();
        $fields['status'] = ReservationStatus::DRAFT;
        return Reservation::create($fields);
    }

    /**
     * @return string
     */
    protected function generateContractNumber(): string
    {
        $currentDateString = Date::now()->format('Ymd');
        $lastContract = Reservation::query()
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
     * @param array $statuses
     * @return Collection|Builder
     */
    protected function getReservedDates(int|string $cottageId, ?string $start = null, ?string $end = null, array $statuses = []): Collection|Builder
    {
        return $this->reservationsQueryBuilder->getByCottageAndDates($cottageId, $start, $end, $statuses);
    }
}
