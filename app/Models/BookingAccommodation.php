<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingAccommodation extends Model
{
    use HasFactory;

    protected $fillable = [
        'lead_id',
        'destination',
        'location',
        'stay_at',
        'checkin_date',
        'checkout_date',
        'room_type',
        'meal_plan',
        'booking_status',
    ];

    protected $casts = [
        'checkin_date' => 'date',
        'checkout_date' => 'date',
    ];

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }
}
