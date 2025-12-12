@extends('layouts.app')

@section('title', 'Employee Details | Travel Shravel')

@section('content')
    <div class="hk-pg-wrapper pb-0">
        <div class="hk-pg-body py-0">
            <div class="contactapp-wrap">
                <div class="contactapp-content">
                    <div class="contactapp-detail-wrap">
                        <header class="contact-header">
                            <div class="w-100 align-items-center justify-content-between d-flex contactapp-title link-dark">
                                <h1>Employee Details</h1>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('hr.employees.edit', $employee) }}" class="btn btn-primary btn-sm">Edit</a>
                                    <a href="{{ route('hr.employees.index') }}" class="btn btn-outline-secondary btn-sm">Back to List</a>
                                </div>
                            </div>
                        </header>

                        <div class="contact-body">
                            <div data-simplebar class="nicescroll-bar">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <h6 class="text-uppercase text-muted small fw-semibold mb-3">Basic Information</h6>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label text-muted">Employee ID</label>
                                        <p class="mb-0"><strong>{{ $employee->employee_id ?? 'N/A' }}</strong></p>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label text-muted">Name</label>
                                        <p class="mb-0"><strong>{{ $employee->name }}</strong></p>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label text-muted">Date of Birth (DOB)</label>
                                        <p class="mb-0">{{ $employee->dob ? $employee->dob->format('d M, Y') : 'N/A' }}</p>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label text-muted">Department</label>
                                        <p class="mb-0">{{ $employee->department ?? 'N/A' }}</p>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label text-muted">Designation</label>
                                        <p class="mb-0">{{ $employee->designation ?? 'N/A' }}</p>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label text-muted">Reporting Manager</label>
                                        <p class="mb-0">{{ $employee->reporting_manager ?? 'N/A' }}</p>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label text-muted">Branch / Location</label>
                                        <p class="mb-0">{{ $employee->branch_location ?? 'N/A' }}</p>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label text-muted">Date of Joining (DOJ)</label>
                                        <p class="mb-0">{{ $employee->doj ? $employee->doj->format('d M, Y') : 'N/A' }}</p>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label text-muted">Date of Leaving (DOL)</label>
                                        <p class="mb-0">
                                            @if ($employee->dol)
                                                {{ $employee->dol->format('d M, Y') }}
                                            @else
                                                <span class="badge badge-soft-success">Active</span>
                                            @endif
                                        </p>
                                    </div>

                                    <div class="col-12 mt-4">
                                        <h6 class="text-uppercase text-muted small fw-semibold mb-3">Contact Details</h6>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label text-muted">Emergency Contact</label>
                                        <p class="mb-0">{{ $employee->emergency_contact ?? 'N/A' }}</p>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label text-muted">Work Email</label>
                                        <p class="mb-0">{{ $employee->work_email ?? 'N/A' }}</p>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label text-muted">CRM Access (User ID)</label>
                                        <p class="mb-0">{{ $employee->crm_access_user_id ?? 'N/A' }}</p>
                                    </div>

                                    <div class="col-12 mt-4">
                                        <div class="d-flex justify-content-end gap-2">
                                            <a href="{{ route('hr.employees.index') }}" class="btn btn-light border">Back to List</a>
                                            <a href="{{ route('hr.employees.edit', $employee) }}" class="btn btn-primary">Edit Employee</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footer')
    </div>
@endsection

