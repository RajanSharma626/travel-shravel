<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LeadRemark extends Model
{
    use HasFactory;

    protected $fillable = [
        'lead_id',
        'user_id',
        'remark',
        'follow_up_date',
        'follow_up_time',
        'follow_up_at',
        'visibility',
    ];

    protected $casts = [
        'follow_up_date' => 'date',
        'follow_up_at' => 'datetime',
    ];

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }

    public function user()
    {
        // Keep relationship to User for database compatibility
        return $this->belongsTo(User::class);
    }
    
    /**
     * Get employee who created the remark (accessor)
     */
    public function getEmployeeAttribute()
    {
        $user = $this->user;
        if ($user && $user->user_id) {
            return Employee::where('user_id', $user->user_id)->first();
        }
        return null;
    }
}
