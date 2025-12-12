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

                                <form action="{{ route('hr.employees.store') }}" method="POST" class="row g-3">
                                    @csrf

                                    <div class="col-12">
                                        <h6 class="text-uppercase text-muted small fw-semibold mb-3">Basic Information</h6>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label">Employee ID</label>
                                        <input type="text" name="employee_id" class="form-control form-control-sm"
                                            value="{{ old('employee_id') }}" placeholder="Leave empty to auto-generate">
                                        <small class="text-muted">Auto-generated if left empty</small>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label">Name <span class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control form-control-sm"
                                            value="{{ old('name') }}" required>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label">Date of Birth (DOB)</label>
                                        <input type="date" name="dob" class="form-control form-control-sm"
                                            value="{{ old('dob') }}">
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label">Department</label>
                                        <select name="department" class="form-select form-select-sm">
                                            <option value="">-- Select Department --</option>
                                            <option value="Sales" {{ old('department') == 'Sales' ? 'selected' : '' }}>Sales</option>
                                            <option value="Sales Manager" {{ old('department') == 'Sales Manager' ? 'selected' : '' }}>Sales Manager</option>
                                            <option value="Operation" {{ old('department') == 'Operation' ? 'selected' : '' }}>Operation</option>
                                            <option value="Operation Manager" {{ old('department') == 'Operation Manager' ? 'selected' : '' }}>Operation Manager</option>
                                            <option value="Accounts" {{ old('department') == 'Accounts' ? 'selected' : '' }}>Accounts</option>
                                            <option value="Accounts Manager" {{ old('department') == 'Accounts Manager' ? 'selected' : '' }}>Accounts Manager</option>
                                            <option value="Post Sales" {{ old('department') == 'Post Sales' ? 'selected' : '' }}>Post Sales</option>
                                            <option value="Post Sales Manager" {{ old('department') == 'Post Sales Manager' ? 'selected' : '' }}>Post Sales Manager</option>
                                            <option value="Delivery" {{ old('department') == 'Delivery' ? 'selected' : '' }}>Delivery</option>
                                            <option value="Delivery Manager" {{ old('department') == 'Delivery Manager' ? 'selected' : '' }}>Delivery Manager</option>
                                            <option value="HR" {{ old('department') == 'HR' ? 'selected' : '' }}>HR</option>
                                            <option value="Admin" {{ old('department') == 'Admin' ? 'selected' : '' }}>Admin</option>
                                            <option value="Other" {{ old('department') == 'Other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label">Designation</label>
                                        <input type="text" name="designation" class="form-control form-control-sm"
                                            value="{{ old('designation') }}" placeholder="e.g. Manager, Executive">
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label">Reporting Manager</label>
                                        <input type="text" name="reporting_manager" class="form-control form-control-sm"
                                            value="{{ old('reporting_manager') }}">
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label">Branch / Location</label>
                                        <input type="text" name="branch_location" class="form-control form-control-sm"
                                            value="{{ old('branch_location') }}">
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label">Date of Joining (DOJ)</label>
                                        <input type="date" name="doj" class="form-control form-control-sm"
                                            value="{{ old('doj') }}">
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label">Date of Leaving (DOL)</label>
                                        <input type="date" name="dol" class="form-control form-control-sm"
                                            value="{{ old('dol') }}">
                                        <small class="text-muted">Leave empty for active employees</small>
                                    </div>

                                    <div class="col-12 mt-4">
                                        <h6 class="text-uppercase text-muted small fw-semibold mb-3">Contact Details</h6>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Emergency Contact</label>
                                        <input type="text" name="emergency_contact" class="form-control form-control-sm"
                                            value="{{ old('emergency_contact') }}" placeholder="Emergency contact number">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Work Email</label>
                                        <input type="email" name="work_email" class="form-control form-control-sm"
                                            value="{{ old('work_email') }}" placeholder="employee@travelshravel.com">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">CRM Access (User ID)</label>
                                        <input type="text" name="crm_access_user_id" class="form-control form-control-sm"
                                            value="{{ old('crm_access_user_id') }}" placeholder="sales1, ops1, ps1, etc">
                                        <small class="text-muted">CRM user ID for system access</small>
                                    </div>

                                    <div class="col-12 mt-4">
                                        <div class="d-flex justify-content-end gap-2">
                                            <a href="{{ route('hr.employees.index') }}" class="btn btn-light border btn-sm">Cancel</a>
                                            <button type="submit" class="btn btn-primary btn-sm">Add Employee</button>
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

