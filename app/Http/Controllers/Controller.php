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
     * Get current employee's user ID for database compatibility
     * Maps Employee to User ID since database still uses users table foreign keys
     */
    protected function getCurrentUserId()
    {
        $employee = Auth::user();
        if (!$employee) {
            return null;
        }
        
        // Map employee to user ID for database compatibility
        if ($employee->user_id) {
            $user = \App\Models\User::where('user_id', $employee->user_id)
                ->orWhere('email', $employee->login_work_email)
                ->first();
            
            if (!$user) {
                // Create user record if it doesn't exist for database compatibility
                $user = \App\Models\User::create([
                    'name' => $employee->name,
                    'email' => $employee->login_work_email ?? $employee->user_id . '@travelshravel.com',
                    'password' => $employee->password,
                    'user_id' => $employee->user_id,
                    'role' => $employee->role ?? 'Sales',
                    'status' => 'Active',
                ]);
            }
            
            return $user ? $user->id : null;
        }
        
        return null;
    }
}
