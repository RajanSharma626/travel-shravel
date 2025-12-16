<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HRController extends Controller
{
    /**
     * Check if employee has Admin or HR role
     */
    private function checkAccess()
    {
        $employee = Auth::user();
        
        if (!$employee) {
            abort(403, 'You must be logged in to access this resource.');
        }
        
        // Check Spatie roles
        $hasSpatieRole = $employee->hasRole('Admin') || $employee->hasRole('HR') || $employee->hasRole('Developer');
        
        // Also check role field for backward compatibility
        $roleField = $employee->role ?? $employee->getRoleNameAttribute();
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

        $employees = $query->orderBy('created_at', 'desc')->paginate(25);

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
            'salutation' => 'nullable|string|max:50',
            'name' => 'required|string|max:255',
            'dob' => 'nullable|date',
            'date_of_birth' => 'nullable|date',
            'marital_status' => 'nullable|string|max:50',
            'department' => 'nullable|string|max:255',
            'designation' => 'nullable|string|max:255',
            'reporting_manager' => 'nullable|string|max:255',
            'branch_location' => 'nullable|string|max:255',
            'blood_group' => 'nullable|string|max:10',
            'doj' => 'nullable|date',
            'dol' => 'nullable|date',
            'date_of_joining' => 'nullable|string|max:255',
            'date_of_leaving' => 'nullable|string|max:255',
            'employment_type' => 'nullable|string|max:50',
            'employment_status' => 'nullable|string|max:50',
            'starting_salary' => 'nullable|numeric',
            'last_withdrawn_salary' => 'nullable|numeric',
            'emergency_contact' => 'nullable|string|max:255',
            'work_email' => 'nullable|email|max:255|unique:employees,work_email',
            'crm_access_user_id' => 'nullable|string|max:255',
            'user_id' => 'nullable|string|max:255|unique:employees,user_id',
            'login_work_email' => 'nullable|email|max:255|unique:employees,login_work_email',
            'password' => 'nullable|string|min:6|max:255',
            'login_access_rights' => 'nullable|string|max:255',
            'role' => 'nullable|in:Admin,Sales Manager,Sales,Operation Manager,Operation,Accounts Manager,Accounts,Post Sales Manager,Post Sales,Delivery Manager,Delivery,HR,Developer',
            'previous_employer' => 'nullable|string|max:255',
            'previous_employer_contact_person' => 'nullable|string|max:255',
            'previous_employer_contact_number' => 'nullable|string|max:255',
            'reason_for_leaving' => 'nullable|string|max:255',
            'highest_qualification' => 'nullable|string|max:255',
            'specialization' => 'nullable|string|max:255',
            'year_of_passing' => 'nullable|string|max:50',
            'work_experience' => 'nullable|string|max:255',
            'father_mother_name' => 'nullable|string|max:255',
            'father_mother_contact_number' => 'nullable|string|max:255',
            'nominee_name' => 'nullable|string|max:255',
            'nominee_contact_number' => 'nullable|string|max:255',
            'aadhar_number' => 'nullable|string|max:255',
            'pan_number' => 'nullable|string|max:255',
            'passport_number' => 'nullable|string|max:255',
            'present_address' => 'nullable|string',
            'permanent_address' => 'nullable|string',
            'permanent_same_as_present' => 'nullable|boolean',
            'incentive_eligibility' => 'nullable|boolean',
            'incentive_type' => 'nullable|string|max:255',
            'monthly_target' => 'nullable|string|max:255',
            'incentive_payout_date' => 'nullable|string|max:255',
            'bank_name' => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:255',
            'ifsc_code' => 'nullable|string|max:255',
            'salary_structure' => 'nullable|string|max:255',
            'pf_number' => 'nullable|string|max:255',
            'esic_number' => 'nullable|string|max:255',
            'uan_number' => 'nullable|string|max:255',
            'exit_initiated_by' => 'nullable|string|max:255',
            'resignation_date' => 'nullable|string|max:255',
            'notice_period' => 'nullable|string|max:255',
            'last_working_day' => 'nullable|string|max:255',
            'exit_interview_notes' => 'nullable|string|max:255',
            'service_certificate_issued' => 'nullable|boolean',
            'service_certificate_issue_date' => 'nullable|string|max:255',
            'handed_over_laptop' => 'nullable|boolean',
            'handed_over_mobile' => 'nullable|boolean',
            'handed_over_id_card' => 'nullable|boolean',
            'all_dues_cleared' => 'nullable|boolean',
        ]);

        // Generate employee_id if not provided
        if (empty($validated['employee_id'])) {
            $validated['employee_id'] = 'EMP' . str_pad(Employee::max('id') + 1 ?? 1, 6, '0', STR_PAD_LEFT);
        }

        // Hash password if provided
        if (!empty($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        $employee = Employee::create($validated);

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
            'salutation' => 'nullable|string|max:50',
            'name' => 'required|string|max:255',
            'dob' => 'nullable|date',
            'date_of_birth' => 'nullable|date',
            'marital_status' => 'nullable|string|max:50',
            'department' => 'nullable|string|max:255',
            'designation' => 'nullable|string|max:255',
            'reporting_manager' => 'nullable|string|max:255',
            'branch_location' => 'nullable|string|max:255',
            'blood_group' => 'nullable|string|max:10',
            'doj' => 'nullable|date',
            'dol' => 'nullable|date',
            'date_of_joining' => 'nullable|string|max:255',
            'date_of_leaving' => 'nullable|string|max:255',
            'employment_type' => 'nullable|string|max:50',
            'employment_status' => 'nullable|string|max:50',
            'starting_salary' => 'nullable|numeric',
            'last_withdrawn_salary' => 'nullable|numeric',
            'emergency_contact' => 'nullable|string|max:255',
            'work_email' => 'nullable|email|max:255|unique:employees,work_email,' . $employee->id,
            'crm_access_user_id' => 'nullable|string|max:255',
            'user_id' => 'nullable|string|max:255|unique:employees,user_id,' . $employee->id,
            'login_work_email' => 'nullable|email|max:255|unique:employees,login_work_email,' . $employee->id,
            'login_access_rights' => 'nullable|string|max:255',
            'role' => 'nullable|in:Admin,Sales Manager,Sales,Operation Manager,Operation,Accounts Manager,Accounts,Post Sales Manager,Post Sales,Delivery Manager,Delivery,HR,Developer',
            'previous_employer' => 'nullable|string|max:255',
            'previous_employer_contact_person' => 'nullable|string|max:255',
            'previous_employer_contact_number' => 'nullable|string|max:255',
            'reason_for_leaving' => 'nullable|string|max:255',
            'highest_qualification' => 'nullable|string|max:255',
            'specialization' => 'nullable|string|max:255',
            'year_of_passing' => 'nullable|string|max:50',
            'work_experience' => 'nullable|string|max:255',
            'father_mother_name' => 'nullable|string|max:255',
            'father_mother_contact_number' => 'nullable|string|max:255',
            'nominee_name' => 'nullable|string|max:255',
            'nominee_contact_number' => 'nullable|string|max:255',
            'aadhar_number' => 'nullable|string|max:255',
            'pan_number' => 'nullable|string|max:255',
            'passport_number' => 'nullable|string|max:255',
            'present_address' => 'nullable|string',
            'permanent_address' => 'nullable|string',
            'permanent_same_as_present' => 'nullable|boolean',
            'incentive_eligibility' => 'nullable|boolean',
            'incentive_type' => 'nullable|string|max:255',
            'monthly_target' => 'nullable|string|max:255',
            'incentive_payout_date' => 'nullable|string|max:255',
            'bank_name' => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:255',
            'ifsc_code' => 'nullable|string|max:255',
            'salary_structure' => 'nullable|string|max:255',
            'pf_number' => 'nullable|string|max:255',
            'esic_number' => 'nullable|string|max:255',
            'uan_number' => 'nullable|string|max:255',
            'exit_initiated_by' => 'nullable|string|max:255',
            'resignation_date' => 'nullable|string|max:255',
            'notice_period' => 'nullable|string|max:255',
            'last_working_day' => 'nullable|string|max:255',
            'exit_interview_notes' => 'nullable|string|max:255',
            'service_certificate_issued' => 'nullable|boolean',
            'service_certificate_issue_date' => 'nullable|string|max:255',
            'handed_over_laptop' => 'nullable|boolean',
            'handed_over_mobile' => 'nullable|boolean',
            'handed_over_id_card' => 'nullable|boolean',
            'all_dues_cleared' => 'nullable|boolean',
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
