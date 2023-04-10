<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bus extends Model
{
    use HasFactory;
    protected $fillable = ['trip_id', 'available_seats'];
    /**
     * trip
     *
     * @return BelongsTo
     */
    public function trip(): BelongsTo
    {
        return $this->belongsTo(Trip::class, 'trip_id');
    }
}
