<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Employee extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'employee_id',
        'salutation',
        'name',
        'dob',
        'date_of_birth',
        'marital_status',
        'department',
        'designation',
        'reporting_manager',
        'branch_location',
        'blood_group',
        'doj',
        'dol',
        'date_of_joining',
        'date_of_leaving',
        'employment_type',
        'employment_status',
        'starting_salary',
        'last_withdrawn_salary',
        'emergency_contact',
        'work_email',
        'crm_access_user_id',
        'user_id',
        'login_work_email',
        'password',
        'login_access_rights',
        'role',
        'previous_employer',
        'previous_employer_contact_person',
        'previous_employer_contact_number',
        'reason_for_leaving',
        'highest_qualification',
        'specialization',
        'year_of_passing',
        'work_experience',
        'father_mother_name',
        'father_mother_contact_number',
        'nominee_name',
        'nominee_contact_number',
        'aadhar_number',
        'pan_number',
        'passport_number',
        'present_address',
        'permanent_address',
        'permanent_same_as_present',
        'incentive_eligibility',
        'incentive_type',
        'monthly_target',
        'incentive_payout_date',
        'bank_name',
        'account_number',
        'ifsc_code',
        'salary_structure',
        'pf_number',
        'esic_number',
        'uan_number',
        'exit_initiated_by',
        'resignation_date',
        'notice_period',
        'last_working_day',
        'exit_interview_notes',
        'service_certificate_issued',
        'service_certificate_issue_date',
        'handed_over_laptop',
        'handed_over_mobile',
        'handed_over_id_card',
        'all_dues_cleared',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'dob' => 'date',
        'doj' => 'date',
        'dol' => 'date',
        'date_of_birth' => 'date',
        'service_certificate_issued' => 'boolean',
        'incentive_eligibility' => 'boolean',
        'permanent_same_as_present' => 'boolean',
        'handed_over_laptop' => 'boolean',
        'handed_over_mobile' => 'boolean',
        'handed_over_id_card' => 'boolean',
        'all_dues_cleared' => 'boolean',
        'password' => 'hashed',
    ];

    /**
     * Get the name of the unique identifier for the user.
     * Laravel uses 'id' by default, which is correct for Employee model
     */

    /**
     * Get role name (backward compatibility)
     */
    public function getRoleNameAttribute()
    {
        return $this->roles()->first()?->name ?? $this->attributes['role'] ?? null;
    }
    
    /**
     * Check if user has a specific role (backward compatibility)
     * This method checks both Spatie roles and the role field
     */
    public function hasRoleName($role): bool
    {
        // Check Spatie roles first
        if ($this->roles()->where('name', $role)->exists()) {
            return true;
        }
        
        // Also check the role field for backward compatibility
        return $this->attributes['role'] === $role;
    }
}
