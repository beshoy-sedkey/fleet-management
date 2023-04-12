<?php

namespace App\Repositories\Reservations;

use App\Models\Line;
use App\Models\Stop;
use App\Services\SeatsCalculator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class ReservationRepository implements ReservationRepositoryInterface
{
    use SeatsCalculator;

    /**
     * @return mixed
     */
    public function list(int $startPoint, int $endPoint)
    {
        $lines = Stop::whereIn('id', [$startPoint, $endPoint])->with('line')->get()->pluck('line')->unique();

        $trips = [];
        $lines->each(function ($line) use ($startPoint, $endPoint, &$trips) {
            $linePaths = $this->getLinePaths($line, $startPoint, $endPoint, true);

            $occupiedSeats = $this->getOccupiedSeats($linePaths, $line);

            $availableSeats = $line->seats - $occupiedSeats;
            if ($availableSeats > 0)
                $trips[] = $this->getTripDetails($startPoint, $endPoint, $availableSeats, $line);
        });

        return $trips;
    }

    /**
     * @param array $bookingDetails
     * @return void
     */
    public function book(int $lineId, int $startPoint, int $endPoint): void
    {
        $line = Line::find($lineId);

        $linePaths = $this->getLinePaths($line, $startPoint, $endPoint);

        foreach ($linePaths as $linePath)
            Auth::user()->reservations()->create(['line_id' => $lineId, 'stop_id' => $linePath]);
    }
}
