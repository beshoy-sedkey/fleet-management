<?php

namespace App\Transformers;

use App\Models\Station;
use League\Fractal\TransformerAbstract;

class StationsTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param Station $station
     * @return array
     */
    public function transform(Station $station)
    {
        return [
            'id' => $station->id,
            'name' => $station->name
        ];
    }
}
