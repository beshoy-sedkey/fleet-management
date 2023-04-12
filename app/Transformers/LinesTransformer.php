<?php

namespace App\Transformers;

use App\Models\Line;
use League\Fractal\TransformerAbstract;

class LinesTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param Line $line
     * @return array
     */
    public function transform(Line $line)
    {
        return [
            'id' => $line->id,
            'name' => $line->name
        ];
    }
}
