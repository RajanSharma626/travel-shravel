<?php

namespace App\Http\Controllers;

use App\Models\Employee;
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
        if (!$user->hasRole('Admin') && !$user->hasRole('HR') && !$user->hasRole('Developer')) {
            abort(403, 'You do not have permission to access this resource.');
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->checkAccess();

        $query = Employee::query();

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('employee_id', 'like', "%{$search}%")
                  ->orWhere('work_email', 'like', "%{$search}%")
                  ->orWhere('department', 'like', "%{$search}%")
                  ->orWhere('designation', 'like', "%{$search}%");
            });
        }

        // Filter by department
        if ($request->has('department') && $request->department) {
            $query->where('department', $request->department);
        }

        // Filter by status (active = no DOL, inactive = has DOL)
        if ($request->has('status') && $request->status) {
            if ($request->status === 'active') {
                $query->whereNull('dol');
            } elseif ($request->status === 'inactive') {
                $query->whereNotNull('dol');
            }
        }

        $employees = $query->orderBy('created_at', 'desc')->paginate(20);

        $departments = Employee::distinct()->pluck('department')->filter();

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
            'employee_id' => 'nullable|string|max:255|unique:employees,employee_id',
            'name' => 'required|string|max:255',
            'dob' => 'nullable|date',
            'department' => 'nullable|string|max:255',
            'designation' => 'nullable|string|max:255',
            'reporting_manager' => 'nullable|string|max:255',
            'branch_location' => 'nullable|string|max:255',
            'doj' => 'nullable|date',
            'dol' => 'nullable|date',
            'emergency_contact' => 'nullable|string|max:255',
            'work_email' => 'nullable|email|max:255|unique:employees,work_email',
            'crm_access_user_id' => 'nullable|string|max:255',
        ]);

        // Generate employee_id if not provided
        if (empty($validated['employee_id'])) {
            $validated['employee_id'] = 'EMP' . str_pad(Employee::max('id') + 1 ?? 1, 6, '0', STR_PAD_LEFT);
        }

        Employee::create($validated);

        return redirect()->route('hr.employees.index')
            ->with('success', 'Employee created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        $this->checkAccess();

        return view('hr.employees.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        $this->checkAccess();

        return view('hr.employees.edit', compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        $this->checkAccess();

        $validated = $request->validate([
            'employee_id' => 'nullable|string|max:255|unique:employees,employee_id,' . $employee->id,
            'name' => 'required|string|max:255',
            'dob' => 'nullable|date',
            'department' => 'nullable|string|max:255',
            'designation' => 'nullable|string|max:255',
            'reporting_manager' => 'nullable|string|max:255',
            'branch_location' => 'nullable|string|max:255',
            'doj' => 'nullable|date',
            'dol' => 'nullable|date',
            'emergency_contact' => 'nullable|string|max:255',
            'work_email' => 'nullable|email|max:255|unique:employees,work_email,' . $employee->id,
            'crm_access_user_id' => 'nullable|string|max:255',
        ]);

        $employee->update($validated);

        return redirect()->route('hr.employees.index')
            ->with('success', 'Employee updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        $this->checkAccess();

        $employee->delete();

        return redirect()->route('hr.employees.index')
            ->with('success', 'Employee deleted successfully!');
    }
}
