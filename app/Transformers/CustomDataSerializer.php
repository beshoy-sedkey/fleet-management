<?php

namespace App\Transformers;

use League\Fractal\Serializer\ArraySerializer;

class CustomDataSerializer extends ArraySerializer
{
    /**
     * @param string $resourceKey
     * @param array $data
     * @return array
     */
    public function collection($resourceKey, array $data): array
    {
        return $resourceKey ? [$resourceKey => $data] : $data;
    }

    /**
     * @param string $resourceKey
     * @param array $data
     * @return array
     */
    public function item($resourceKey, array $data): array
    {
        return $resourceKey ? [$resourceKey => $data] : $data;
    }

}
