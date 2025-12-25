<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return redirect('/');
        }
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,user_id',
            'password' => 'required|min:6',
        ]);

        // Find employee by user_id
        $user = User::where('user_id', $request->user_id)->first();

        if (!$user) {
            return back()->with('error', 'Invalid User ID or Password');
        }

        // Check if employee has a password set
        if (!$user->password) {
            return back()->with('error', 'Password not set. Please contact admin.');
        }

        // Verify password
        if (!Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Invalid User ID or Password');
        }

        // Check employment status (allow null/empty as active for backward compatibility)
        if ($user->status && $user->status !== 'Active') {
            return back()->with('error', 'Your account is inactive. Please contact admin.');
        }

        // Sync Spatie role from employee role
        if ($user->role) {
            try {
                // Remove all existing roles
                $user->syncRoles([]);
                // Assign the role from employee
                $user->assignRole($user->role);
            } catch (\Exception $e) {
                // Role might not exist in Spatie, that's okay - we'll use the role field
            }
        }

        // Log in the employee directly
        $remember = $request->has('remember');
        Auth::login($user, $remember);

        // Redirect based on employee role
        $user = Auth::user();
        $role = $user->role ?? $user->getRoleNameAttribute();

            switch ($role) {
                case 'Admin':
            case 'Developer':
                    return redirect('/');
            case 'Sales Manager':
            case 'Sales':
                    return redirect('/leads');
            case 'Operation Manager':
            case 'Operation':
                return redirect('/operations');
            case 'Accounts Manager':
            case 'Accounts':
                return redirect('/accounts');
            case 'Post Sales Manager':
            case 'Post Sales':
                return redirect('/post-sales');
            case 'Delivery Manager':
            case 'Delivery':
                return redirect('/deliveries');
            case 'HR':
                return redirect('/hr/employees');
            default:
                    return redirect('/leads');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
