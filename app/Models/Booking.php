<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    use HasFactory;
      /**
     * @var string
     */
    protected $table = 'bookings';

    /**
     * @var string[]
     */
    protected $fillable = ['user_id', 'line_id', 'stop_id'];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function line(): BelongsTo
    {
        return $this->belongsTo(Line::class);
    }

    /**
     * @return BelongsTo
     */
    public function stop(): BelongsTo
    {
        return $this->belongsTo(Stop::class);
    }
}
