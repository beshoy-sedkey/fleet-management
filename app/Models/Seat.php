<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Seat extends Model
{
    use HasFactory;
    protected $fillable = ['bus_id', 'number', 'is_booked'];

    /**
     * city
     *
     * @return BelongsTo
     */
    public function bus(): BelongsTo
    {
        return $this->belongsTo(Bus::class, 'bus_id');
    }
}
