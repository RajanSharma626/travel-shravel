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
        'first_name',
        'middle_name',
        'last_name',
        'phone',
        'primary_phone',
        'secondary_phone',
        'other_phone',
        'email',
        'address',
        'travel_date',
        'adults',
        'children',
        'children_2_5',
        'children_6_11',
        'infants',
        'assigned_user_id',
        'selling_price',
        'booked_value',
        'status'
    ];

    protected $casts = [
        'travel_date' => 'date',
    ];

    protected static function booted()
    {
        static::saving(function (Lead $lead) {
            $names = array_filter([
                $lead->first_name,
                $lead->middle_name,
                $lead->last_name,
            ]);

            if (!empty($names)) {
                $lead->customer_name = trim(implode(' ', $names));
            }

            if ($lead->primary_phone) {
                $lead->phone = $lead->primary_phone;
            }
        });
    }

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

    public function histories()
    {
        return $this->hasMany(LeadHistory::class);
    }

    public function remarks()
    {
        return $this->hasMany(LeadRemark::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function costComponents()
    {
        return $this->hasMany(CostComponent::class);
    }

    public function operation()
    {
        return $this->hasOne(Operation::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function delivery()
    {
        return $this->hasOne(Delivery::class);
    }

    public function incentives()
    {
        return $this->hasMany(Incentive::class);
    }

    // Helper methods
    public function getTotalPaidAttribute()
    {
        return $this->payments()->where('status', 'paid')->sum('amount');
    }

    public function getTotalCostAttribute()
    {
        return $this->costComponents()->sum('amount');
    }

    public function getProfitAttribute()
    {
        return ($this->selling_price ?? 0) - ($this->operation?->nett_cost ?? $this->total_cost);
    }
}
