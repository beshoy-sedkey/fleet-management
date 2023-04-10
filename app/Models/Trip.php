<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Trip extends Model
{
    use HasFactory;
    protected $fillable = ['from_city_id', 'to_city_id'];
    /**
     * fromCity
     *
     * @return BelongsTo
     */
    public function fromCity(): BelongsTo
    {
        return $this->belongsTo(City::class, 'from_city_id');
    }
    /**
     * toCity
     *
     * @return BelongsTo
     */
    public function toCity(): BelongsTo
    {
        return $this->belongsTo(City::class, 'to_city_id');
    }
}
