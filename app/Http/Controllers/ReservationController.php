<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\ListReservationsRequest;
use App\Http\Requests\API\StoreReservationRequest;
use App\Http\Responses\ResponsesInterface;
use App\Repositories\Reservations\ReservationRepositoryInterface;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * @var ResponsesInterface $responder
     */
    protected ResponsesInterface $responder;

    /**
     * @var ReservationRepositoryInterface
     */
    private ReservationRepositoryInterface $reservationRepository;

    /**
     * ReservationController constructor.
     * @param ResponsesInterface $responder
     */
    public function __construct(ResponsesInterface $responder, ReservationRepositoryInterface $reservationRepository)
    {
        $this->middleware('auth:api');

        $this->responder = $responder;
        $this->reservationRepository = $reservationRepository;
    }

    /**
     * @return mixed
     */
    public function index(ListReservationsRequest $request)
    {
        $tickets = $this->reservationRepository->list(
            ... array_values($request->only(['start_point', 'end_point']))
        );

        return $this->responder->respond(['data' => $tickets]);
    }

    /**
     * @param StoreReservationRequest $request
     * @return mixed
     */
    public function store(StoreReservationRequest $request)
    {
        $proceed = false;

        foreach ($this->reservationRepository->list($request->start_point, $request->end_point) as $trip) {
            if ($trip['startingPoint']['id'] == $request->start_point && $trip['endingPoint']['id'] == $request->end_point) {
                $proceed = true;
                break;
            }
        }

        if (!$proceed)
            return $this->responder->respondWithValidationError('This trip is fully completed.');

        $this->reservationRepository->book(
            ...array_values($request->only(['line_id', 'start_point', 'end_point']))
        );

        return $this->responder->respondWithResourceCreatedSuccessfully('Reservation');
    }
}
