<?php

namespace App\Repositories\Reservations;

interface ReservationRepositoryInterface
{
    /**
     * @return mixed
     */
    public function list(int $startPoint, int $endPoint);

    /**
     * @param array $bookingDetails
     * @return void
     */
    public function book(int $lineId, int $startPoint, int $endPoint): void;
}
