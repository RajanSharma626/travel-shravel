<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Get current user ID
     */
    protected function getCurrentUserId()
    {
        return Auth::id();
    }

    /**
     * Get department-specific stages
     */
    protected function getDepartmentStages($department)
    {
        $stages = [
            'Operations' => ['Pending', 'In Progress', 'Vouchered', 'Monitoring', 'Closed'],
            'Operation' => ['Pending', 'In Progress', 'Vouchered', 'Monitoring', 'Closed'],
            'Operation Manager' => ['Pending', 'In Progress', 'Vouchered', 'Monitoring', 'Closed'],
            'Ticketing' => ['Pending', 'Booked', 'Issued'],
            'Visa' => ['Pending', 'In Progress', 'Granted', 'Refused'],
            'Insurance' => ['Pending', 'In Progress', 'Booked', 'Closed'],
            'Delivery' => ['Pending', 'In Progress', 'QC Passed', 'Delivered', 'Feedback', 'Closed'],
            'Delivery Manager' => ['Pending', 'In Progress', 'QC Passed', 'Delivered', 'Feedback', 'Closed'],
        ];

        // Map department/role to stage type
        $stageMap = [
            'Operations' => 'operations_stage',
            'Operation' => 'operations_stage',
            'Operation Manager' => 'operations_stage',
            'Ticketing' => 'ticketing_stage',
            'Visa' => 'visa_stage',
            'Insurance' => 'insurance_stage',
            'Delivery' => 'delivery_stage',
            'Delivery Manager' => 'delivery_stage',
        ];

        $stageKey = $stageMap[$department] ?? 'operations_stage';
        $stageOptions = $stages[$department] ?? $stages['Operations'];

        return [
            'stage_key' => $stageKey,
            'stages' => $stageOptions,
            'department' => $department
        ];
    }

    /**
     * Get user's department for stage dropdown
     */
    protected function getUserDepartment()
    {
        $employee = Auth::user();
        $role = $employee->role ?? $employee->getRoleNameAttribute();
        $department = $employee->department;

        // Map role to department for stages
        if (in_array($role, ['Operation', 'Operation Manager'])) {
            return 'Operations';
        } elseif (in_array($role, ['Delivery', 'Delivery Manager'])) {
            return 'Delivery';
        } elseif ($department) {
            return $department;
        }

        return $role ?? 'Operations';
    }
}
