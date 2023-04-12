<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Line extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'lines';

    /**
     * @var string[]
     */
    protected $fillable = ['name', 'seats'];

    /**
     * @return HasMany
     */
    public function stops(): HasMany
    {
        return $this->hasMany(Stop::class);
    }

    /**
     * @return HasMany
     */
    public function reservations(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
}
