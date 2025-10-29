<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'lead_id',
        'amount',
        'method',
        'paid_on',
        'due_date',
        'status',
        'notes',
    ];

    protected $casts = [
        'paid_on' => 'date',
        'due_date' => 'date',
        'amount' => 'decimal:2',
    ];

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }
}
