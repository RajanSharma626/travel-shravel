<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HRController extends Controller
{
    /**
     * Check if user has Admin or HR role
     */
    private function checkAccess()
    {
        $user = Auth::user();
        
        if (!$user) {
            abort(403, 'You must be logged in to access this resource.');
        }
        
        // Check Spatie roles
        $hasSpatieRole = $user->hasRole('Admin') || $user->hasRole('HR') || $user->hasRole('Developer');
        
        // Also check role field for backward compatibility
        $roleField = $user->role ?? $user->getRoleNameAttribute();
        $hasRoleField = in_array($roleField, ['Admin', 'HR', 'Developer']);
        
        // Allow access if any check passes
        if ($hasSpatieRole || $hasRoleField) {
            return; // Allow access
        }
        
        abort(403, 'You do not have permission to access this resource. Your role: ' . ($roleField ?? 'none'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->checkAccess();

        $query = User::with('empBasicInfo');

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('employee_id', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('department', 'like', "%{$search}%")
                  ->orWhere('designation', 'like', "%{$search}%");
            });
        }

        // Filter by department
        if ($request->has('department') && $request->department) {
            $query->where('department', $request->department);
        }

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $employees = $query->orderBy('created_at', 'desc')->paginate(25);

        $departments = User::distinct()->pluck('department')->filter();

        return view('hr.employees.index', compact('employees', 'departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->checkAccess();

        return view('hr.employees.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->checkAccess();

        $validated = $request->validate([
            'employee_id' => 'nullable|string|max:255|unique:users,employee_id',
            'salutation' => 'nullable|string|max:50',
            'name' => 'required|string|max:255',
            'dob' => 'nullable|date',
            'marital_status' => 'nullable|string|max:50',
            'department' => 'nullable|string|max:255',
            'designation' => 'nullable|string|max:255',
            'reporting_manager' => 'nullable|string|max:255',
            'branch_location' => 'nullable|string|max:255',
            'blood_group' => 'nullable|string|max:10',
            'doj' => 'nullable|date',
            'employment_type' => 'nullable|string|max:50',
            'employment_status' => 'nullable|string|max:50',
            'starting_salary' => 'nullable|numeric',
            'last_withdrawn_salary' => 'nullable|numeric',
            'email' => 'nullable|email|max:255|unique:users,email',
            'user_id' => 'nullable|string|max:255|unique:users,user_id',
            'password' => 'required|string|min:6|max:255',
            'role' => 'nullable|in:Admin,Sales Manager,Sales,Operation Manager,Operation,Accounts Manager,Accounts,Post Sales Manager,Post Sales,Delivery Manager,Delivery,HR,Developer',
            'status' => 'nullable|string|max:50',
        ]);

        // Generate employee_id if not provided
        if (empty($validated['employee_id'])) {
            $validated['employee_id'] = 'EMP' . str_pad(User::max('id') + 1 ?? 1, 6, '0', STR_PAD_LEFT);
        }

        // Hash password
        $validated['password'] = bcrypt($validated['password']);

        $user = User::create($validated);

        // Create basic info profile if any related data exists (optional, could just create empty)
        $user->empBasicInfo()->create([
            'marital_status' => $validated['marital_status'] ?? null,
            // ... other fields if added to form
        ]);

        // Sync Spatie role
        if ($user->role) {
            try {
                $user->syncRoles([]);
                $user->assignRole($user->role);
            } catch (\Exception $e) {
                // Role might not exist, that's okay
            }
        }

        return redirect()->route('hr.employees.index')
            ->with('success', 'User created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $employee)
    {
        $this->checkAccess();

        return view('hr.employees.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $employee)
    {
        $this->checkAccess();

        return view('hr.employees.edit', compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $employee)
    {
        $this->checkAccess();

        $validated = $request->validate([
            'employee_id' => 'nullable|string|max:255|unique:users,employee_id,' . $employee->id,
            'salutation' => 'nullable|string|max:50',
            'name' => 'required|string|max:255',
            'dob' => 'nullable|date',
            'marital_status' => 'nullable|string|max:50',
            'department' => 'nullable|string|max:255',
            'designation' => 'nullable|string|max:255',
            'reporting_manager' => 'nullable|string|max:255',
            'branch_location' => 'nullable|string|max:255',
            'blood_group' => 'nullable|string|max:10',
            'doj' => 'nullable|date',
            'employment_type' => 'nullable|string|max:50',
            'employment_status' => 'nullable|string|max:50',
            'starting_salary' => 'nullable|numeric',
            'last_withdrawn_salary' => 'nullable|numeric',
            'email' => 'nullable|email|max:255|unique:users,email,' . $employee->id,
            'user_id' => 'nullable|string|max:255|unique:users,user_id,' . $employee->id,
            'password' => 'nullable|string|min:6|max:255',
            'role' => 'nullable|in:Admin,Sales Manager,Sales,Operation Manager,Operation,Accounts Manager,Accounts,Post Sales Manager,Post Sales,Delivery Manager,Delivery,HR,Developer',
            'status' => 'nullable|string|max:50',
        ]);

        // Hash password if provided, otherwise remove from array to keep existing password
        if (!empty($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        $employee->update($validated);
        $employee->refresh();

        // Sync Spatie role
        if ($employee->role) {
            try {
                $employee->syncRoles([]);
                $employee->assignRole($employee->role);
            } catch (\Exception $e) {
                // Role might not exist, that's okay
            }
        }

        return redirect()->route('hr.employees.index')
            ->with('success', 'User updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $employee)
    {
        $this->checkAccess();

        $employee->delete();

        return redirect()->route('hr.employees.index')
            ->with('success', 'User deleted successfully!');
    }
}
