<?php

namespace App\Services;

use App\Models\Station;
use App\Transformers\CustomDataSerializer;
use App\Transformers\LinesTransformer;
use App\Transformers\StationsTransformer;
use Spatie\Fractal\Fractal;

trait SeatsCalculator
{
    /**
     * @param $line
     * @param int $startPoint
     * @param int $endPoint
     * @param bool $sliding
     * @return mixed
     */
    private function getLinePaths($line, int $startPoint, int $endPoint, bool $sliding = false)
    {
        $twoPointsPriorities = $line->stops->whereIn('id', [$startPoint, $endPoint])
            ->sortBy('priority')->pluck('priority')->toArray();
        $linePaths = $line->stops->where('priority', '>=', $twoPointsPriorities[0])
            ->where('priority', '<=', $twoPointsPriorities[1])->pluck('id');

        return $sliding
            ? $linePaths->sliding(2)->map(fn($path) => array_values($path->toArray()))->toArray()
            : $linePaths->toArray();
    }

    /**
     * @param mixed $linePaths
     * @param $line
     *
     * @return int
     */
    private function getOccupiedSeats(mixed $linePaths, $line): int
    {
        $seats = [];

        foreach ($linePaths as $linePath) {
            $maxOccurrence = 0;
            $line->reservations->groupBy('created_at')->each(function ($reservations) use ($linePath, &$maxOccurrence) {
                if ($reservations->pluck('stop_id')->intersect($linePath)->count() >= count($linePath)) {
                    $maxOccurrence += 1;
                }
            });
            $seats[] = $maxOccurrence;
        }

        return max($seats);
    }

    /**
     * @param int $startPoint
     * @param int $endPoint
     * @param int $availableSeats
     * @param $line
     * @return array
     */
    private function getTripDetails(int $startPoint, int $endPoint, int $availableSeats, $line): array
    {
        return [
            'startingPoint' => Fractal::create(Station::find($startPoint), new StationsTransformer(), CustomDataSerializer::class)->toArray(),
            'endingPoint' => Fractal::create(Station::find($endPoint), new StationsTransformer(), CustomDataSerializer::class)->toArray(),
            'seats' => $availableSeats,
            'line' => Fractal::create($line, new LinesTransformer(), CustomDataSerializer::class)->toArray(),
        ];
    }
}
