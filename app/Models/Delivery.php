<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Delivery extends Model
{
    use HasFactory;

    protected $fillable = [
        'lead_id',
        'assigned_to',
        'status',
        'attachments',
        'courier_id',
        'tracking_info',
        'expected_delivery_date',
        'actual_delivery_date',
        'delivery_notes',
    ];

    protected $casts = [
        'expected_delivery_date' => 'date',
        'actual_delivery_date' => 'date',
        'attachments' => 'array',
    ];

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
