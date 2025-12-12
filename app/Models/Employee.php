<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'name',
        'dob',
        'department',
        'designation',
        'reporting_manager',
        'branch_location',
        'doj',
        'dol',
        'emergency_contact',
        'work_email',
        'crm_access_user_id',
    ];

    protected $casts = [
        'dob' => 'date',
        'doj' => 'date',
        'dol' => 'date',
    ];
}
