<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\v1;

use App\Exceptions\CottageIsBookedException;
use App\Exceptions\NoPricesException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Booking\GetContractRequest;
use App\Http\Requests\Price\GetPriceRequest;
use App\Http\Requests\Booking\GetBookedDatesRequest;
use App\Http\Requests\Booking\IndexBookingRequest;
use App\Http\Requests\Booking\StoreBookingRequest;
use App\Http\Resources\BookingResource;
use App\Http\Resources\BookedDateResource;
use App\Models\Booking;
use App\QueryBuilders\BookingsQueryBuilder;
use App\Services\BookingService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Nette\Schema\ValidationException;

class BookingController extends Controller
{
    public function __construct(
        protected BookingService       $bookingService,
        protected BookingsQueryBuilder $bookingsQueryBuilder
    )
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @param IndexBookingRequest $request
     * @return AnonymousResourceCollection
     */
    public function index(IndexBookingRequest $request): AnonymousResourceCollection
    {
        $cottageId = $request->validated('cottage');
        $start = $request->validated('start');
        $end = $request->validated('end');
        if ($cottageId) {
            $bookings = $this->bookingsQueryBuilder
                ->getByCottageAndDates($cottageId, $start, $end, withRelations: true);
        } else {
            $bookings = $this->bookingsQueryBuilder
                ->getAllWithRelations();
        }
        return BookingResource::collection($bookings);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookingRequest $request): JsonResponse
    {
        try {
            $booking = $this->bookingService->createBooking($request->validated('booking'));
        } catch (\Exception $exception) {
            return response()->json([
                'error' => $exception->getMessage()
            ], $exception->getCode() ?: 500);
        }
        return response()->json([
            'message' => 'Коттедж успешно забронирован',
            'booking' => BookingResource::make($booking)
        ], 201);
    }

    /**
     * Получить цену на коттедж в указанные даты
     *
     * @param GetPriceRequest $request
     * @return JsonResponse
     */
    public function getPrice(GetPriceRequest $request): JsonResponse
    {
        try {
            $price = $this->bookingService
                ->calculatePrice(
                    cottageId: $request->validated('cottage_id'),
                    start: $request->validated('start'),
                    end: $request->validated('end'),
                    additionalPlaces: $request->validated('additional_places'),
                    childrenPlaces: $request->validated('children_places')
                );
            return response()->json([
                'status' => 'true',
                'data' => [
                    'price' => $price
                ]
            ]);
        } catch (ValidationException|CottageIsBookedException|NoPricesException $exception) {
            return response()->json([
                'status' => 'false',
                'message' => $exception->getMessage()
            ], $exception->getCode());
        }
    }

    public function getBookedDates(GetBookedDatesRequest $request): AnonymousResourceCollection
    {

        $bookings = $this->bookingsQueryBuilder->getByCottageAndDates(
            cottageId: $request->validated('cottage_id'),
            start: $request->validated('start'),
            end: $request->validated('end'),
        );
        return BookedDateResource::collection($bookings);
    }

    /**
     * Display the specified resource.
     *
     * @param Booking $booking
     * @return BookingResource
     */
    public function getByContractNumber(string $contractNumber): BookingResource
    {
        $booking = $this->bookingsQueryBuilder->getByContractNumber($contractNumber);
        return new BookingResource($booking);
    }

    public function isCottageBooked(GetBookedDatesRequest $request): JsonResponse
    {
        $isBooked = $this->bookingService->isCottageBooked(
            cottageId: $request->validated('cottage_id'),
            start: $request->validated('start'),
            end: $request->validated('end'));
        $data = [
            'isBooked' => $isBooked
        ];
        if ($isBooked) {
            $data['message'] = 'Коттедж уже забронирован в выбранные даты';
        }
        return response()->json([
            'status' => 'true',
            'data' => $data
        ]);
    }

    public function getContract(GetContractRequest $request)
    {
        $contractNumber = $request->validated('contract_no');
        $booking = $this->bookingsQueryBuilder->getByContractNumber($contractNumber);
        return Pdf::loadView('pdf.booking.contract', [
            'booking' => $booking,
            'profile' => $booking->customerProfile,
            'cottage' => $booking->cottage,
        ])->download("$contractNumber.pdf");
    }
}
