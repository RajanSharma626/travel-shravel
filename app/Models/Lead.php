<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'tsq_number',
        'tsq',
        'service_id',
        'destination_id',
        'customer_name',
        'phone',
        'email',
        'address',
        'travel_date',
        'adults',
        'children',
        'infants',
        'assigned_user_id',
        'selling_price',
        'booked_value',
        'status'
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }
    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_user_id');
    }
}
