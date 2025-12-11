<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VendorPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'lead_id',
        'vendor_code',
        'booking_type',
        'location',
        'purchase_cost',
        'due_date',
        'status',
        'paid_amount',
        'pending_amount',
        'payment_mode',
        'ref_no',
        'remarks',
    ];

    protected $casts = [
        'purchase_cost' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'pending_amount' => 'decimal:2',
        'due_date' => 'date',
    ];

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }
}
