<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'seat_id'];

    /**
     * city
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * city
     *
     * @return BelongsTo
     */
    public function seat(): BelongsTo
    {
        return $this->belongsTo(Seat::class, 'seat_id');
    }
}
