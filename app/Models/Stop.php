<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Stop extends Model
{
    use HasFactory;
    protected $fillable = ['trip_id', 'city_id', 'stop_sequence'];

    /**
     * city
     *
     * @return BelongsTo
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class, 'city_id');
    }
    /**
     * city
     *
     * @return BelongsTo
     */
    public function trip(): BelongsTo
    {
        return $this->belongsTo(Trip::class, 'trip_id');
    }
}
