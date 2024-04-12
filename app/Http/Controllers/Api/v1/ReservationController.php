<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Reservation\IndexReservationRequest;
use App\Http\Requests\Reservation\StoreReservationRequest;
use App\Http\Requests\Reservation\UpdateReservationRequest;
use App\Http\Resources\ReservationResource;
use App\Models\Reservation;
use App\QueryBuilders\QueryBuilder;
use App\QueryBuilders\ReservationsQueryBuilder;
use App\Services\ReservationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ReservationController extends Controller
{
    public function __construct(
        protected ReservationService       $reservationService,
        protected ReservationsQueryBuilder $reservationQueryBuilder
    )
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @param IndexReservationRequest $request
     * @return AnonymousResourceCollection
     */
    public function index(IndexReservationRequest $request): AnonymousResourceCollection
    {
        $cottageId = $request->validated('cottage');
        $start = $request->validated('start');
        $end = $request->validated('end');
        if ($cottageId) {
            $reservations = $this->reservationQueryBuilder
                ->getByCottageAndDates($cottageId, $start, $end, withRelations: true);
        } else {
            $reservations = $this->reservationQueryBuilder
                ->getAllWithRelations();
        }
        return ReservationResource::collection($reservations);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReservationRequest $request): JsonResponse
    {
        try {
            $reservation = $this->reservationService->createReservation($request->validated('reservation'));
        } catch (\Exception $exception) {
            return response()->json([
                'error' => $exception->getMessage()
            ], $exception->getCode() ?: 500);
        }
        return response()->json([
            'message' => 'Коттедж успешно забронирован',
            'reservation' => ReservationResource::make($reservation)
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Reservation $reservation
     * @return ReservationResource
     */
    public function show(Reservation $reservation): ReservationResource
    {
        return new ReservationResource($reservation);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reservation $reservation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReservationRequest $request, Reservation $reservation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation)
    {
        //
    }
}
