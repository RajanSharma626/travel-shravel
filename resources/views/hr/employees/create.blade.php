@extends('layouts.app')

@section('title', 'Add Employee | Travel Shravel')

@section('content')
    <div class="hk-pg-wrapper pb-0">
        <div class="hk-pg-body py-0">
            <div class="contactapp-wrap">
                <div class="contactapp-content">
                    <div class="contactapp-detail-wrap">
                        <header class="contact-header">
                            <div class="w-100 align-items-center justify-content-between d-flex contactapp-title link-dark">
                                <h1>Add Employee</h1>
                                <a href="{{ route('hr.employees.index') }}" class="btn btn-outline-secondary btn-sm">Back to List</a>
                            </div>
                        </header>

                        <div class="contact-body">
                            <div data-simplebar class="nicescroll-bar">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <strong>There were some problems with your submission:</strong>
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form action="{{ route('hr.employees.store') }}" method="POST" class="row g-4">
                                    @csrf

                                    {{-- Official Profile --}}
                                    <div class="col-12">
                                        <div class="card border shadow-sm">
                                            <div class="card-header py-2 d-flex align-items-center justify-content-between">
                                                <h6 class="mb-0 text-uppercase text-muted small fw-semibold">Official Profile</h6>
                                    </div>
                                            <div class="card-body py-3">
                                                <div class="row g-3">
                                                    <div class="col-md-3">
                                        <label class="form-label">Employee ID</label>
                                        <input type="text" name="employee_id" class="form-control form-control-sm"
                                               value="{{ old('employee_id') }}" placeholder="Auto if blank">
                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="form-label">Salutation</label>
                                                        <select name="salutation" class="form-select form-select-sm">
                                                            <option value="">Select</option>
                                                            <option value="Mr" {{ old('salutation') == 'Mr' ? 'selected' : '' }}>Mr</option>
                                                            <option value="Ms" {{ old('salutation') == 'Ms' ? 'selected' : '' }}>Ms</option>
                                                            <option value="Mrs" {{ old('salutation') == 'Mrs' ? 'selected' : '' }}>Mrs</option>
                                                            <option value="Dr" {{ old('salutation') == 'Dr' ? 'selected' : '' }}>Dr</option>
                                                            <option value="Prof" {{ old('salutation') == 'Prof' ? 'selected' : '' }}>Prof</option>
                                                            <option value="Other" {{ old('salutation') == 'Other' ? 'selected' : '' }}>Other</option>
                                                        </select>
                                    </div>
                                                    <div class="col-md-3">
                                        <label class="form-label">Name <span class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control form-control-sm"
                                            value="{{ old('name') }}" required>
                                    </div>
                                                    <div class="col-md-3">
                                        <label class="form-label">Date of Birth</label>
                                        <input type="date" name="date_of_birth" class="form-control form-control-sm"
                                               value="{{ old('date_of_birth') }}">
                                    </div>

                                                    <div class="col-md-3">
                                                        <label class="form-label">Marital Status</label>
                                                        <select name="marital_status" class="form-select form-select-sm">
                                                            <option value="">Select</option>
                                                            <option value="Single" {{ old('marital_status') == 'Single' ? 'selected' : '' }}>Single</option>
                                                            <option value="Married" {{ old('marital_status') == 'Married' ? 'selected' : '' }}>Married</option>
                                                            <option value="Divorced" {{ old('marital_status') == 'Divorced' ? 'selected' : '' }}>Divorced</option>
                                                            <option value="Widowed" {{ old('marital_status') == 'Widowed' ? 'selected' : '' }}>Widowed</option>
                                                            <option value="Other" {{ old('marital_status') == 'Other' ? 'selected' : '' }}>Other</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3">
                                        <label class="form-label">Department</label>
                                        <select name="department" class="form-select form-select-sm">
                                            <option value="">-- Select Department --</option>
                                            <option value="Sales" {{ old('department') == 'Sales' ? 'selected' : '' }}>Sales</option>
                                            <option value="Operation" {{ old('department') == 'Operation' ? 'selected' : '' }}>Operation</option>
                                            <option value="Accounts" {{ old('department') == 'Accounts' ? 'selected' : '' }}>Accounts</option>
                                            <option value="Post Sales" {{ old('department') == 'Post Sales' ? 'selected' : '' }}>Post Sales</option>
                                            <option value="Delivery" {{ old('department') == 'Delivery' ? 'selected' : '' }}>Delivery</option>
                                            <option value="HR" {{ old('department') == 'HR' ? 'selected' : '' }}>HR</option>
                                        </select>
                                    </div>
                                                    <div class="col-md-3">
                                        <label class="form-label">Designation</label>
                                        <input type="text" name="designation" class="form-control form-control-sm"
                                               value="{{ old('designation') }}">
                                    </div>
                                                    <div class="col-md-3">
                                        <label class="form-label">Reporting Manager</label>
                                                        <select name="reporting_manager" class="form-select form-select-sm">
                                                            <option value="">Select</option>
                                                            <option value="Sales Manager" {{ old('reporting_manager') == 'Sales Manager' ? 'selected' : '' }}>Sales Manager</option>
                                                            <option value="Operation Manager" {{ old('reporting_manager') == 'Operation Manager' ? 'selected' : '' }}>Operation Manager</option>
                                                            <option value="Accounts Manager" {{ old('reporting_manager') == 'Accounts Manager' ? 'selected' : '' }}>Accounts Manager</option>
                                                            <option value="Post Sales Manager" {{ old('reporting_manager') == 'Post Sales Manager' ? 'selected' : '' }}>Post Sales Manager</option>
                                                            <option value="Delivery Manager" {{ old('reporting_manager') == 'Delivery Manager' ? 'selected' : '' }}>Delivery Manager</option>
                                                            <option value="HR Manager" {{ old('reporting_manager') == 'HR Manager' ? 'selected' : '' }}>HR Manager</option>
                                                            <option value="Admin" {{ old('reporting_manager') == 'Admin' ? 'selected' : '' }}>Admin</option>
                                                            <option value="Other" {{ old('reporting_manager') == 'Other' ? 'selected' : '' }}>Other</option>
                                                        </select>
                                    </div>

                                                    <div class="col-md-3">
                                        <label class="form-label">Blood Group</label>
                                        <input type="text" name="blood_group" class="form-control form-control-sm"
                                               value="{{ old('blood_group') }}">
                                    </div>
                                                    <div class="col-md-3">
                                        <label class="form-label">Branch / Location</label>
                                        <input type="text" name="branch_location" class="form-control form-control-sm"
                                            value="{{ old('branch_location') }}">
                                    </div>
                                                    <div class="col-md-3">
                                        <label class="form-label">Date of Joining</label>
                                        <input type="date" name="doj" class="form-control form-control-sm"
                                            value="{{ old('doj') }}">
                                    </div>
                                                    <div class="col-md-3">
                                        <label class="form-label">Date of Leaving</label>
                                        <input type="date" name="dol" class="form-control form-control-sm"
                                            value="{{ old('dol') }}">
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-label">Employment Type</label>
                                        <select name="employment_type" class="form-select form-select-sm">
                                            <option value="">Select</option>
                                            <option value="Contract" {{ old('employment_type') == 'Contract' ? 'selected' : '' }}>Contract</option>
                                            <option value="Permanent" {{ old('employment_type') == 'Permanent' ? 'selected' : '' }}>Permanent</option>
                                            <option value="Intern" {{ old('employment_type') == 'Intern' ? 'selected' : '' }}>Intern</option>
                                            <option value="Consultant" {{ old('employment_type') == 'Consultant' ? 'selected' : '' }}>Consultant</option>
                                            <option value="Other" {{ old('employment_type') == 'Other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Employment Status</label>
                                        <select name="employment_status" class="form-select form-select-sm">
                                            <option value="">Select</option>
                                            <option value="Active" {{ old('employment_status') == 'Active' ? 'selected' : '' }}>Active</option>
                                            <option value="Resigned" {{ old('employment_status') == 'Resigned' ? 'selected' : '' }}>Resigned</option>
                                            <option value="Terminated" {{ old('employment_status') == 'Terminated' ? 'selected' : '' }}>Terminated</option>
                                            <option value="On Notice" {{ old('employment_status') == 'On Notice' ? 'selected' : '' }}>On Notice</option>
                                            <option value="On Hold" {{ old('employment_status') == 'On Hold' ? 'selected' : '' }}>On Hold</option>
                                        </select>
                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="form-label">Starting Salary</label>
                                                        <input type="number" step="0.01" name="starting_salary" class="form-control form-control-sm"
                                                               value="{{ old('starting_salary') }}">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="form-label">Last Withdrawn Salary</label>
                                                        <input type="number" step="0.01" name="last_withdrawn_salary" class="form-control form-control-sm"
                                                               value="{{ old('last_withdrawn_salary') }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Login Details --}}
                                    <div class="col-12">
                                        <div class="card border shadow-sm">
                                            <div class="card-header py-2">
                                                <h6 class="mb-0 text-uppercase text-muted small fw-semibold">Login Details</h6>
                                            </div>
                                            <div class="card-body py-3">
                                                <div class="row g-3">
                                                    <div class="col-md-3">
                                        <label class="form-label">User ID</label>
                                        <input type="text" name="user_id" class="form-control form-control-sm"
                                               value="{{ old('user_id') }}" placeholder="sales1 / ops1 / ps1">
                                    </div>
                                                    <div class="col-md-3">
                                        <label class="form-label">Work E-mail</label>
                                        <input type="email" name="email" class="form-control form-control-sm"
                                               value="{{ old('email') }}">
                                    </div>
                                                    <div class="col-md-3">
                                        <label class="form-label">Password</label>
                                        <input type="password" name="password" class="form-control form-control-sm"
                                               value="{{ old('password') }}" placeholder="Enter password">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label fw-semibold">Role <span class="text-danger">*</span></label>
                                        <select name="role" class="form-select form-select-sm" required>
                                            <option value="">-- Select Role --</option>
                                            <option value="Admin" {{ old('role') == 'Admin' ? 'selected' : '' }}>Admin</option>
                                            <option value="Manager" {{ old('role') == 'Manager' ? 'selected' : '' }}>Manager</option>
                                            <option value="User" {{ old('role') == 'User' ? 'selected' : '' }}>User</option>
                                        </select>
                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Basic Information --}}
                                    <div class="col-12">
                                        <div class="card border shadow-sm">
                                            <div class="card-header py-2">
                                                <h6 class="mb-0 text-uppercase text-muted small fw-semibold">Basic Information</h6>
                                            </div>
                                            <div class="card-body py-3">
                                                <div class="row g-3">
                                                    <div class="col-md-3">
                                        <label class="form-label">Previous Employer</label>
                                        <input type="text" name="previous_employer" class="form-control form-control-sm"
                                               value="{{ old('previous_employer') }}">
                                    </div>
                                                    <div class="col-md-3">
                                        <label class="form-label">Contact Person</label>
                                        <input type="text" name="previous_employer_contact_person" class="form-control form-control-sm"
                                               value="{{ old('previous_employer_contact_person') }}">
                                    </div>
                                                    <div class="col-md-3">
                                        <label class="form-label">Contact Number</label>
                                        <input type="text" name="previous_employer_contact_number" class="form-control form-control-sm"
                                               value="{{ old('previous_employer_contact_number') }}">
                                    </div>
                                                    <div class="col-md-3">
                                        <label class="form-label">Reason for Leaving</label>
                                        <input type="text" name="reason_for_leaving" class="form-control form-control-sm"
                                               value="{{ old('reason_for_leaving') }}">
                                    </div>

                                                    <div class="col-md-3">
                                        <label class="form-label">Highest Qualification</label>
                                        <input type="text" name="highest_qualification" class="form-control form-control-sm"
                                               value="{{ old('highest_qualification') }}">
                                    </div>
                                                    <div class="col-md-3">
                                        <label class="form-label">Specialization</label>
                                        <input type="text" name="specialization" class="form-control form-control-sm"
                                               value="{{ old('specialization') }}">
                                    </div>
                                                    <div class="col-md-3">
                                        <label class="form-label">Year of Passing</label>
                                        <input type="text" name="year_of_passing" class="form-control form-control-sm"
                                               value="{{ old('year_of_passing') }}">
                                    </div>
                                                    <div class="col-md-3">
                                        <label class="form-label">Work Experience</label>
                                        <input type="text" name="work_experience" class="form-control form-control-sm"
                                               value="{{ old('work_experience') }}">
                                    </div>

                                                    <div class="col-md-3">
                                        <label class="form-label">Father / Mother's Name</label>
                                        <input type="text" name="father_mother_name" class="form-control form-control-sm"
                                               value="{{ old('father_mother_name') }}">
                                    </div>
                                                    <div class="col-md-3">
                                        <label class="form-label">Father / Mother's Contact</label>
                                        <input type="text" name="father_mother_contact_number" class="form-control form-control-sm"
                                               value="{{ old('father_mother_contact_number') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Nominee Name</label>
                                        <input type="text" name="nominee_name" class="form-control form-control-sm"
                                               value="{{ old('nominee_name') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Nominee Contact</label>
                                        <input type="text" name="nominee_contact_number" class="form-control form-control-sm"
                                               value="{{ old('nominee_contact_number') }}">
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-label">Aadhar Number</label>
                                        <input type="text" name="aadhar_number" class="form-control form-control-sm"
                                               value="{{ old('aadhar_number') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">PAN Number</label>
                                        <input type="text" name="pan_number" class="form-control form-control-sm"
                                               value="{{ old('pan_number') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Passport Number</label>
                                        <input type="text" name="passport_number" class="form-control form-control-sm"
                                               value="{{ old('passport_number') }}">
                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Addresses --}}
                                    <div class="col-12">
                                        <div class="card border shadow-sm">
                                            <div class="card-header py-2">
                                                <h6 class="mb-0 text-uppercase text-muted small fw-semibold">Addresses</h6>
                                            </div>
                                            <div class="card-body py-3">
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                        <label class="form-label">Present Address</label>
                                        <textarea name="present_address" rows="2" class="form-control form-control-sm">{{ old('present_address') }}</textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Permanent Address</label>
                                        <textarea name="permanent_address" rows="2" class="form-control form-control-sm">{{ old('permanent_address') }}</textarea>
                                        <div class="form-check mt-1">
                                            <input class="form-check-input" type="checkbox" name="permanent_same_as_present" value="1"
                                                   id="permanentSameAsPresent" {{ old('permanent_same_as_present') ? 'checked' : '' }}>
                                            <label class="form-check-label small" for="permanentSameAsPresent">
                                                Same as Present?
                                            </label>
                                        </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Incentive & Performance --}}
                                    <div class="col-12">
                                        <div class="card border shadow-sm">
                                            <div class="card-header py-2">
                                                <h6 class="mb-0 text-uppercase text-muted small fw-semibold">Incentive & Performance</h6>
                                            </div>
                                            <div class="card-body py-3">
                                                <div class="row g-3">
                                                    <div class="col-md-3">
                                        <label class="form-label">Incentive Eligibility</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="incentive_eligibility" value="1"
                                                   id="incentiveEligibility" {{ old('incentive_eligibility') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="incentiveEligibility">Yes</label>
                                        </div>
                                    </div>
                                                    <div class="col-md-3">
                                        <label class="form-label">Incentive Type</label>
                                        <input type="text" name="incentive_type" class="form-control form-control-sm"
                                               value="{{ old('incentive_type') }}" placeholder="Fixed / %age">
                                    </div>
                                                    <div class="col-md-3">
                                        <label class="form-label">Monthly Target</label>
                                        <input type="text" name="monthly_target" class="form-control form-control-sm"
                                               value="{{ old('monthly_target') }}">
                                    </div>
                                                    <div class="col-md-3">
                                        <label class="form-label">Incentive Payout Date</label>
                                        <input type="text" name="incentive_payout_date" class="form-control form-control-sm"
                                               value="{{ old('incentive_payout_date') }}" placeholder="e.g. 21 of every month">
                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Statutory & Payroll Details --}}
                                    <div class="col-12">
                                        <div class="card border shadow-sm">
                                            <div class="card-header py-2">
                                                <h6 class="mb-0 text-uppercase text-muted small fw-semibold">Statutory & Payroll Details</h6>
                                            </div>
                                            <div class="card-body py-3">
                                                <div class="row g-3">
                                                    <div class="col-md-3">
                                        <label class="form-label">Bank Name</label>
                                        <input type="text" name="bank_name" class="form-control form-control-sm"
                                               value="{{ old('bank_name') }}">
                                    </div>
                                                    <div class="col-md-3">
                                        <label class="form-label">Account Number</label>
                                        <input type="text" name="account_number" class="form-control form-control-sm"
                                               value="{{ old('account_number') }}">
                                    </div>
                                                    <div class="col-md-3">
                                        <label class="form-label">IFSC Code</label>
                                        <input type="text" name="ifsc_code" class="form-control form-control-sm"
                                               value="{{ old('ifsc_code') }}">
                                    </div>
                                                    <div class="col-md-3">
                                        <label class="form-label">Salary Structure</label>
                                        <input type="text" name="salary_structure" class="form-control form-control-sm"
                                               value="{{ old('salary_structure') }}" placeholder="CTC / Gross / Net">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">PF Number</label>
                                        <input type="text" name="pf_number" class="form-control form-control-sm"
                                               value="{{ old('pf_number') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">ESIC Number</label>
                                        <input type="text" name="esic_number" class="form-control form-control-sm"
                                               value="{{ old('esic_number') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">UAN Number</label>
                                        <input type="text" name="uan_number" class="form-control form-control-sm"
                                               value="{{ old('uan_number') }}">
                                    </div>

                                                    <div class="col-md-3">
                                        <label class="form-label">Exit Initiated By</label>
                                        <input type="text" name="exit_initiated_by" class="form-control form-control-sm"
                                               value="{{ old('exit_initiated_by') }}" placeholder="Employee / HR">
                                    </div>
                                                    <div class="col-md-3">
                                        <label class="form-label">Resignation Date</label>
                                        <input type="text" name="resignation_date" class="form-control form-control-sm"
                                               value="{{ old('resignation_date') }}">
                                    </div>
                                                    <div class="col-md-3">
                                        <label class="form-label">Notice Period</label>
                                        <input type="text" name="notice_period" class="form-control form-control-sm"
                                               value="{{ old('notice_period') }}">
                                    </div>
                                                    <div class="col-md-3">
                                        <label class="form-label">Last Working Day</label>
                                        <input type="text" name="last_working_day" class="form-control form-control-sm"
                                               value="{{ old('last_working_day') }}">
                                    </div>
                                                    <div class="col-md-3">
                                        <label class="form-label">Exit Interview Notes</label>
                                        <input type="text" name="exit_interview_notes" class="form-control form-control-sm"
                                               value="{{ old('exit_interview_notes') }}">
                                    </div>
                                                    <div class="col-md-9">
                                                        <div class="row g-2">
                                                            <div class="col-md-3">
                                                                <div class="form-check mt-4">
                                                                    <input class="form-check-input" type="checkbox" name="service_certificate_issued" value="1"
                                                                           id="serviceCertificateIssued" {{ old('service_certificate_issued') ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="serviceCertificateIssued">
                                                                        Service Certificate Issued
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label class="form-label">Issuing Date</label>
                                                                <input type="text" name="service_certificate_issue_date" class="form-control form-control-sm"
                                                                       value="{{ old('service_certificate_issue_date') }}">
                                                            </div>
                                    <div class="col-md-6">
                                                                <label class="form-label d-block">Assets & Dues</label>
                                                                <div class="d-flex flex-wrap gap-3">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="checkbox" name="handed_over_laptop" value="1"
                                                                               id="handedOverLaptop" {{ old('handed_over_laptop') ? 'checked' : '' }}>
                                                                        <label class="form-check-label" for="handedOverLaptop">Laptop</label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="checkbox" name="handed_over_mobile" value="1"
                                                                               id="handedOverMobile" {{ old('handed_over_mobile') ? 'checked' : '' }}>
                                                                        <label class="form-check-label" for="handedOverMobile">Mobile</label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="checkbox" name="handed_over_id_card" value="1"
                                                                               id="handedOverIdCard" {{ old('handed_over_id_card') ? 'checked' : '' }}>
                                                                        <label class="form-check-label" for="handedOverIdCard">ID Card</label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="checkbox" name="all_dues_cleared" value="1"
                                                                               id="allDuesCleared" {{ old('all_dues_cleared') ? 'checked' : '' }}>
                                                                        <label class="form-check-label" for="allDuesCleared">All Dues Cleared?</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 mt-4">
                                        <div class="d-flex justify-content-end gap-2">
                                            <a href="{{ route('hr.employees.index') }}" class="btn btn-light border btn-sm">Cancel</a>
                                            <button type="submit" class="btn btn-primary btn-sm">Save Employee</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footer')
    </div>
@endsection

