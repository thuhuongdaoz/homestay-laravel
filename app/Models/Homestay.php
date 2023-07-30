<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Homestay extends Model
{
    use HasFactory;

    protected $fillable = [
            'user_id',
            'name',
            'location_id',
            'address',
            'avatar',
            'images',
            'desc',
//            'restaurant',
//            'free_wifi',
//            'pool',
//            'spa',
//            'bar',
//            'breakfast',
    'utilities',
    ];
    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
    }
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
    /**
     * Get the post that owns the comment.
     */
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }
}
