@extends('layouts.app')
@section('title', 'Leads | Travel Shravel')
@section('content')
    <div class="hk-pg-wrapper pb-0">
        <div class="hk-pg-body py-0">
            <div class="contactapp-wrap">
                <div class="contactapp-content">
                    <div class="contactapp-detail-wrap">
                        <header class="contact-header">
                            <div class="w-100 align-items-center justify-content-between d-flex contactapp-title link-dark">
                                <h1>Leads List</h1>
                                <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="modal"
                                    data-bs-target="#addLeadModal">+ Add Lead</button>
                            </div>
                        </header>

                        <div class="contact-body">
                            <div data-simplebar class="nicescroll-bar">
                                @if (session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @endif

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

                                <form method="GET" action="{{ route('leads.index') }}" class="row g-3 mb-4"
                                    id="leadFiltersForm">
                                    <div class="col-md-4 col-lg-3">
                                        <label for="status" class="form-label">Status</label>
                                        <select name="status" id="status" class="form-select form-select-sm">
                                            <option value="">-- All --</option>
                                            @foreach ($statuses as $key => $label)
                                                <option value="{{ $key }}" @selected(($filters['status'] ?? '') === $key)>
                                                    {{ $label }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4 col-lg-3">
                                        <label for="search" class="form-label">Search</label>
                                        <div class="d-flex">
                                            <input type="text" name="search" id="search"
                                                class="form-control form-control-sm"
                                                placeholder="Enter name, ref no., or phone"
                                                value="{{ $filters['search'] ?? '' }}">
                                            <button type="submit" class="btn btn-primary btn-sm ms-2 d-flex"> <i class="ri-search-line me-1"></i>  Filter</button>
                                        </div>
                                    </div>
                                    @if ($filters['status'] || $filters['search'])
                                        <div class="col-md-3 col-lg-2 align-self-end ms-auto">
                                            <a href="{{ route('leads.index') }}"
                                                class="btn btn-outline-danger w-100 btn-sm">Clear
                                                Filters</a>
                                        </div>
                                    @endif
                                </form>

                                <table class="table table-striped small table-bordered w-100 mb-5" id="leadsTable">
                                    <thead>
                                        <tr>
                                            <th>Ref No.</th>
                                            <th>Customer Name</th>
                                            <th>Phone</th>
                                            <th>Status</th>
                                            <th>Last Remark</th>
                                            <th>Created On</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($leads as $lead)
                                            <tr>
                                                <td><strong>{{ $lead->tsq }}</strong></td>
                                                <td>
                                                    <a href="#" class="text-primary text-decoration-none fw-semibold view-lead-btn lead-name-link" data-lead-id="{{ $lead->id }}">
                                                        {{ $lead->customer_name }}
                                                    </a>
                                                </td>
                                                <td>{{ $lead->primary_phone ?? $lead->phone }}</td>
                                                <td>
                                                    @php 
                                                        $statusColors = [
                                                            'new' => 'bg-info text-white',
                                                            'contacted' => 'bg-primary text-white',
                                                            'follow_up' => 'bg-warning text-dark',
                                                            'priority' => 'bg-danger text-white',
                                                            'booked' => 'bg-success text-white',
                                                            'closed' => 'bg-secondary text-white',
                                                        ];
                                                        $color =
                                                            $statusColors[$lead->status] ?? 'bg-primary text-white';
                                                    @endphp
                                                    <span class="badge {{ $color }}">
                                                        {{ ucfirst(str_replace('_', ' ', $lead->status)) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @if ($lead->latest_remark)
                                                        <div class="text-truncate" style="max-width: 200px;"
                                                            title="{{ $lead->latest_remark->remark }}">
                                                            {{ Str::limit($lead->latest_remark->remark, 50) }}
                                                        </div>
                                                        <small class="text-muted">
                                                            by {{ $lead->latest_remark->user->name ?? 'N/A' }}
                                                            @if ($lead->latest_remark->created_at)
                                                                - {{ $lead->latest_remark->created_at->format('d M, Y') }}
                                                            @endif
                                                        </small>
                                                    @else
                                                        <span class="text-muted">No remarks yet</span>
                                                    @endif
                                                </td>
                                                <td>{{ $lead->created_at->format('d M, Y') }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="d-flex">
                                                            <a href="#" 
                                                                class="btn btn-icon btn-flush-dark btn-rounded flush-soft-hover view-lead-btn" 
                                                                data-lead-id="{{ $lead->id }}"
                                                                data-bs-toggle="tooltip" 
                                                                data-placement="top" 
                                                                title="View Lead">
                                                                <span class="icon">
                                                                    <span class="feather-icon">
                                                                        <i data-feather="eye"></i>
                                                                    </span>
                                                                </span>
                                                            </a>
                                                            
                                                            @can('edit leads')
                                                            <a href="#"
                                                                class="btn btn-icon btn-flush-dark btn-rounded flush-soft-hover assign-user-btn"
                                                                data-lead-id="{{ $lead->id }}"
                                                                data-lead-name="{{ $lead->customer_name }}"
                                                                data-current-user="{{ $lead->assignedUser?->name ?? 'Unassigned' }}"
                                                                data-bs-toggle="tooltip"
                                                                data-placement="top"
                                                                title="Assign Agent">
                                                                <span class="icon">
                                                                    <span class="feather-icon">
                                                                        <i data-feather="user-plus"></i>
                                                                    </span>
                                                                </span>
                                                            </a>
                                                            @endcan
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="10" class="text-center">No leads found</td>
                                            </tr>
                                        @endforelse
                                    </tbody>  
                                </table>

                                <div class="d-flex justify-content-center">
                                    {{ $leads->links('pagination::bootstrap-5') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footer')
    </div>

    <!-- Add Lead Modal -->
    <div class="modal fade" id="addLeadModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addLeadModalLabel">Add Lead</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('leads.store') }}" method="POST" id="addLeadForm">
                        @csrf
                        <input type="hidden" name="children" id="children_total" value="{{ old('children', 0) }}">

                        <div class="mb-4 border rounded-3 p-3 bg-light">
                            <h6 class="text-uppercase text-muted small fw-semibold mb-3">Customer Information</h6>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label">First Name <span class="text-danger">*</span></label>
                                    <input type="text" name="first_name" placeholder="e.g. Ramesh" class="form-control form-control-sm"
                                        value="{{ old('first_name') }}" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Middle Name</label>
                                    <input type="text" name="middle_name" placeholder="Optional" class="form-control form-control-sm"
                                        value="{{ old('middle_name') }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Last Name</label>
                                    <input type="text" name="last_name" placeholder="e.g. Kumar" class="form-control form-control-sm" value="{{ old('last_name') }}">
                                </div>
                            </div>
                        </div>

                        <div class="mb-4 border rounded-3 p-3">
                            <h6 class="text-uppercase text-muted small fw-semibold mb-3">Contact Information</h6>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label">Primary Number <span class="text-danger">*</span></label>
                                    <input type="text" name="primary_phone" placeholder="+91 98765 43210" class="form-control form-control-sm"
                                        value="{{ old('primary_phone') }}" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Secondary Number</label>
                                    <input type="text" name="secondary_phone" placeholder="Alternate contact" class="form-control form-control-sm"
                                        value="{{ old('secondary_phone') }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Other Number</label>
                                    <input type="text" name="other_phone" placeholder="Emergency contact" class="form-control form-control-sm"
                                        value="{{ old('other_phone') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" placeholder="customer@email.com" class="form-control form-control-sm" value="{{ old('email') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Address</label>
                                    <input type="text" name="address" placeholder="Street, City, Country" class="form-control form-control-sm" value="{{ old('address') }}">
                                </div>
                            </div>
                        </div>

                        <div class="mb-4 border rounded-3 p-3 bg-light">
                            <h6 class="text-uppercase text-muted small fw-semibold mb-3">Travel Preferences</h6>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label">Service <span class="text-danger">*</span></label>
                                    <select name="service_id" class="form-select form-select-sm" required>
                                        <option value="">-- Select Service --</option>
                                        @foreach ($services as $service)
                                            <option value="{{ $service->id }}"
                                                {{ (string) old('service_id') === (string) $service->id ? 'selected' : '' }}>
                                                {{ $service->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Destination <span class="text-danger">*</span></label>
                                    <select name="destination_id" class="form-select form-select-sm" required>
                                        <option value="">-- Select Destination --</option>
                                        @foreach ($destinations as $destination)
                                            <option value="{{ $destination->id }}"
                                                {{ (string) old('destination_id') === (string) $destination->id ? 'selected' : '' }}>
                                                {{ $destination->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Travel Date</label>
                                    <input type="date" name="travel_date" class="form-control form-control-sm"
                                        value="{{ old('travel_date') }}">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Adults <span class="text-danger">*</span></label>
                                    <input type="number" name="adults" class="form-control form-control-sm" min="1"
                                        value="{{ old('adults', 1) }}" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Children (2-5 yrs)</label>
                                    <input type="number" name="children_2_5" class="form-control form-control-sm" min="0"
                                        value="{{ old('children_2_5', 0) }}">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Children (6-11 yrs)</label>
                                    <input type="number" name="children_6_11" class="form-control form-control-sm" min="0"
                                        value="{{ old('children_6_11', 0) }}">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Infants (below 2 yrs)</label>
                                    <input type="number" name="infants" class="form-control form-control-sm" min="0"
                                        value="{{ old('infants', 0) }}">
                                </div>
                            </div>
                        </div>

                        <div class="mb-4 border rounded-3 p-3">
                            <h6 class="text-uppercase text-muted small fw-semibold mb-3">Assignment</h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Assign To</label>
                                    <select name="assigned_user_id" class="form-select form-select-sm">
                                        <option value="">-- Select User --</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}"
                                                {{ (string) old('assigned_user_id', Auth::id()) === (string) $user->id ? 'selected' : '' }}>
                                                {{ $user->name }} ({{ $user->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Status <span class="text-danger">*</span></label>
                                    <select name="status" class="form-select form-select-sm" required>
                                        @foreach ($statuses as $key => $label)
                                            <option value="{{ $key }}"
                                                {{ old('status', 'new') === $key ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Add Lead</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- View Lead Modal -->
    <div class="modal fade" id="viewLeadModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="viewLeadModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-light border-bottom">
                    <div class="flex-grow-1">
                        <h5 class="modal-title fw-bold mb-1" id="viewLeadModalLabel">
                            <i data-feather="user" class="me-2" style="width: 20px; height: 20px;"></i>
                            <span id="viewLeadModalTitle">Lead Details</span>
                        </h5>
                        <small class="text-muted" id="viewLeadMeta"></small>
                    </div>
                    <span id="viewLeadStatus" class="badge bg-secondary me-3" style="font-size: 0.875rem; padding: 0.5rem 0.75rem;">-</span>
                    @can('edit leads')
                    <button type="button" class="btn btn-sm btn-outline-primary mx-2" id="editLeadBtn" title="Edit Lead">
                        <i data-feather="edit" class="me-1" style="width: 16px; height: 16px;"></i>
                        Edit
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-secondary mx-2 d-none" id="cancelEditBtn" title="Cancel Edit">
                        <i data-feather="x" class="me-1" style="width: 16px; height: 16px;"></i>
                        Cancel
                    </button>
                    @endcan
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div id="viewLeadAlert" class="alert d-none mb-3" role="alert"></div>

                    <div id="viewLeadLoader" class="text-center py-5">
                        <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;"></div>
                        <p class="mt-3 text-muted mb-0">Loading lead details...</p>
                    </div>

                    <div id="viewLeadContent" class="d-none">
                        <!-- Lead Information Cards -->
                        <div class="row g-4 mb-4">
                            <!-- Customer Information -->
                            <div class="col-md-6">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-header bg-white border-bottom">
                                        <h6 class="mb-0 fw-semibold">
                                            <i data-feather="user" class="me-2 text-primary" style="width: 18px; height: 18px;"></i>
                                            Customer Information
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3 pb-3 border-bottom">
                                            <h4 class="fw-bold mb-1 text-dark" id="viewLeadCustomer">-</h4>
                                            <div class="text-muted small" id="viewLeadTSQ"></div>
                                        </div>
                                        <div class="d-flex flex-column gap-2">
                                            <div class="d-flex align-items-center" id="viewLeadPhoneContainer">
                                                <i data-feather="phone" class="text-muted me-2" style="width: 16px; height: 16px;"></i>
                                                <span class="small" id="viewLeadPhones"></span>
                                            </div>
                                            <div class="d-flex align-items-center d-none" id="viewLeadEmailContainer">
                                                <i data-feather="mail" class="text-muted me-2" style="width: 16px; height: 16px;"></i>
                                                <span class="small" id="viewLeadEmail"></span>
                                            </div>
                                            <div class="d-flex align-items-start d-none" id="viewLeadAddressContainer">
                                                <i data-feather="map-pin" class="text-muted me-2 mt-1" style="width: 16px; height: 16px;"></i>
                                                <span class="small" id="viewLeadAddress"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Travel & Assignment Information -->
                            <div class="col-md-6">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-header bg-white border-bottom">
                                        <h6 class="mb-0 fw-semibold">
                                            <i data-feather="briefcase" class="me-2 text-info" style="width: 18px; height: 18px;"></i>
                                            Travel & Assignment
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <div class="d-flex align-items-center mb-2">
                                                <span class="text-muted small me-3" style="min-width: 100px;">Service:</span>
                                                <span class="fw-semibold" id="viewLeadService">-</span>
                                            </div>
                                            <div class="d-flex align-items-center mb-2">
                                                <span class="text-muted small me-3" style="min-width: 100px;">Destination:</span>
                                                <span class="fw-semibold" id="viewLeadDestination">-</span>
                                            </div>
                                            <div class="d-flex align-items-center mb-2">
                                                <span class="text-muted small me-3" style="min-width: 100px;">Travel Date:</span>
                                                <span class="fw-semibold" id="viewLeadTravelDate">-</span>
                                            </div>
                                            <div class="d-flex align-items-center mb-3">
                                                <span class="text-muted small me-3" style="min-width: 100px;">Assigned To:</span>
                                                <span class="fw-semibold" id="viewLeadAssignedUser">-</span>
                                            </div>
                                        </div>
                                        <div class="pt-3 border-top">
                                            <div class="text-muted small mb-2">Travelers:</div>
                                            <div id="viewLeadTravelers"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Add Remark Form -->
                        <div class="card mb-4 border-0 shadow-sm">
                            <div class="card-header bg-white border-bottom">
                                <h6 class="mb-0 fw-semibold">
                                    <i data-feather="message-square" class="me-2 text-success" style="width: 18px; height: 18px;"></i>
                                    Add Remark
                                </h6>
                            </div>
                            <div class="card-body">
                                <div id="leadRemarkAlert" class="alert d-none" role="alert"></div>
                                <form id="leadRemarkForm">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Remark <span class="text-danger">*</span></label>
                                        <textarea name="remark" class="form-control" rows="4" placeholder="Enter your remark here..." required></textarea>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">
                                                <i data-feather="calendar" class="me-1" style="width: 14px; height: 14px;"></i>
                                                Follow-up Date
                                            </label>
                                            <input type="date" name="follow_up_date" class="form-control">
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end mt-4">
                                        <button type="submit" class="btn btn-primary px-4">
                                            <i data-feather="send" class="me-1" style="width: 16px; height: 16px;"></i>
                                            Add Remark
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Recent Remarks -->
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                                <h6 class="mb-0 fw-semibold">
                                    <i data-feather="list" class="me-2 text-warning" style="width: 18px; height: 18px;"></i>
                                    Recent Remarks
                                </h6>
                                <span class="badge bg-primary rounded-pill px-3 py-2" id="viewLeadRemarksCount">0</span>
                            </div>
                            <div class="card-body p-4" id="viewLeadRemarks" style="max-height: 400px; overflow-y: auto;">
                                <p class="text-muted text-center mb-0 py-3">No remarks yet.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Edit Lead Form -->
                    <div id="editLeadContent" class="d-none">
                        <div id="editLeadAlert" class="alert d-none mb-3" role="alert"></div>
                        <form id="editLeadForm">
                            @csrf
                            @method('PUT')
                            
                            <!-- Customer Information -->
                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-header bg-white border-bottom">
                                    <h6 class="mb-0 fw-semibold">
                                        <i data-feather="user" class="me-2 text-primary" style="width: 18px; height: 18px;"></i>
                                        Customer Information
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label class="form-label fw-semibold">First Name <span class="text-danger">*</span></label>
                                            <input type="text" name="first_name" id="editFirstName" class="form-control" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label fw-semibold">Middle Name</label>
                                            <input type="text" name="middle_name" id="editMiddleName" class="form-control">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label fw-semibold">Last Name</label>
                                            <input type="text" name="last_name" id="editLastName" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Contact Information -->
                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-header bg-white border-bottom">
                                    <h6 class="mb-0 fw-semibold">
                                        <i data-feather="phone" class="me-2 text-info" style="width: 18px; height: 18px;"></i>
                                        Contact Information
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label class="form-label fw-semibold">Primary Number <span class="text-danger">*</span></label>
                                            <input type="text" name="primary_phone" id="editPrimaryPhone" class="form-control" maxlength="20" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label fw-semibold">Secondary Number</label>
                                            <input type="text" name="secondary_phone" id="editSecondaryPhone" class="form-control" maxlength="20">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label fw-semibold">Other Number</label>
                                            <input type="text" name="other_phone" id="editOtherPhone" class="form-control" maxlength="20">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                                            <input type="email" name="email" id="editEmail" class="form-control" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Address</label>
                                            <input type="text" name="address" id="editAddress" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Travel Information -->
                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-header bg-white border-bottom">
                                    <h6 class="mb-0 fw-semibold">
                                        <i data-feather="briefcase" class="me-2 text-success" style="width: 18px; height: 18px;"></i>
                                        Travel Information
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Service <span class="text-danger">*</span></label>
                                            <select name="service_id" id="editServiceId" class="form-select" required>
                                                <option value="">-- Select Service --</option>
                                                @foreach ($services as $service)
                                                    <option value="{{ $service->id }}">{{ $service->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Destination <span class="text-danger">*</span></label>
                                            <select name="destination_id" id="editDestinationId" class="form-select" required>
                                                <option value="">-- Select Destination --</option>
                                                @foreach ($destinations as $destination)
                                                    <option value="{{ $destination->id }}">{{ $destination->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Travel Date</label>
                                            <input type="date" name="travel_date" id="editTravelDate" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Travelers Information -->
                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-header bg-white border-bottom">
                                    <h6 class="mb-0 fw-semibold">
                                        <i data-feather="users" class="me-2 text-warning" style="width: 18px; height: 18px;"></i>
                                        Travelers Information
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-3">
                                            <label class="form-label fw-semibold">Adults</label>
                                            <input type="number" name="adults" id="editAdults" class="form-control" min="0" value="0">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label fw-semibold">Children (2-5y)</label>
                                            <input type="number" name="children_2_5" id="editChildren25" class="form-control" min="0" value="0">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label fw-semibold">Children (6-11y)</label>
                                            <input type="number" name="children_6_11" id="editChildren611" class="form-control" min="0" value="0">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label fw-semibold">Infants (below 2 yrs)</label>
                                            <input type="number" name="infants" id="editInfants" class="form-control" min="0" value="0">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Assignment -->
                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-header bg-white border-bottom">
                                    <h6 class="mb-0 fw-semibold">
                                        <i data-feather="user-check" class="me-2 text-danger" style="width: 18px; height: 18px;"></i>
                                        Assignment
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Assign To</label>
                                            <select name="assigned_user_id" id="editAssignedUserId" class="form-select">
                                                <option value="">-- Select User --</option>
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                                            <select name="status" id="editStatus" class="form-select" required>
                                                @foreach ($statuses as $key => $label)
                                                    <option value="{{ $key }}">{{ $label }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <button type="button" class="btn btn-secondary px-4" id="cancelEditFormBtn">
                                    <i data-feather="x" class="me-1" style="width: 16px; height: 16px;"></i>
                                    Cancel
                                </button>
                                <button type="submit" class="btn btn-primary px-4">
                                    <i data-feather="save" class="me-1" style="width: 16px; height: 16px;"></i>
                                    Update Lead
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer bg-light border-top">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
                        <i data-feather="x" class="me-1" style="width: 16px; height: 16px;"></i>
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Assign User Modal -->
    <div class="modal fade" id="assignUserModal" tabindex="-1" aria-labelledby="assignUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-light border-bottom">
                    <h5 class="modal-title fw-bold" id="assignUserModalLabel">
                        <i data-feather="user-plus" class="me-2" style="width: 20px; height: 20px;"></i>
                        Assign Lead to User
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="assignUserAlert" class="alert d-none" role="alert"></div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Lead</label>
                        <input type="text" class="form-control" id="assignUserLeadName" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Current Assignment</label>
                        <input type="text" class="form-control" id="assignUserCurrentUser" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Assign To <span class="text-danger">*</span></label>
                        <select class="form-select" id="assignUserSelect" required>
                            <option value="">-- Select User --</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer bg-light border-top">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="assignUserSubmitBtn">
                        <i data-feather="check" class="me-1" style="width: 16px; height: 16px;"></i>
                        Assign
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
    <style>
        .lead-name-link {
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .lead-name-link:hover {
            text-decoration: underline !important;
            opacity: 0.8;
        }
    </style>
    @endpush

    @push('scripts')
    <script>
        $(document).ready(function() {
            const leadsTable = $('#leadsTable').DataTable({
                scrollX: true,
                autoWidth: false,
                searching: false,
                lengthChange: false,
                info: false,
                paging: true,
                drawCallback: function() {
                    // Initialize Feather icons after each table draw
                    if (typeof feather !== 'undefined') {
                        feather.replace();
                    }
                    // Initialize Bootstrap tooltips after each table draw
                    if (typeof bootstrap !== 'undefined') {
                        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                        tooltipTriggerList.map(function (tooltipTriggerEl) {
                            return new bootstrap.Tooltip(tooltipTriggerEl);
                        });
                    }
                }
            });

            // Initialize Feather icons on page load
            if (typeof feather !== 'undefined') {
                feather.replace();
            }

            // Initialize Bootstrap tooltips on page load
            if (typeof bootstrap !== 'undefined') {
                const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
            }



            const addLeadForm = document.getElementById('addLeadForm');
            const addLeadModalEl = document.getElementById('addLeadModal');
            const draftStorageKey = 'travel_shravel_lead_draft';
            const leadsBaseUrl = @json(url('/leads'));

            const updateChildrenTotal = () => {
                if (!addLeadForm) return;
                const child2_5 = parseInt(addLeadForm.elements['children_2_5']?.value || '0', 10);
                const child6_11 = parseInt(addLeadForm.elements['children_6_11']?.value || '0', 10);
                if (addLeadForm.elements['children']) {
                    addLeadForm.elements['children'].value = (child2_5 || 0) + (child6_11 || 0);
                }
            };

            const hasDraftData = () => {
                if (!window.localStorage) return false;
                const stored = localStorage.getItem(draftStorageKey);
                if (!stored) return false;
                try {
                    const parsed = JSON.parse(stored);
                    return parsed && Object.keys(parsed).length > 0;
                } catch (error) {
                    localStorage.removeItem(draftStorageKey);
                    return false;
                }
            };

            const saveDraft = () => {
                if (!addLeadForm || !window.localStorage) return;
                const formData = {};
                Array.from(addLeadForm.elements).forEach((el) => {
                    if (!el.name || el.disabled) {
                        return;
                    }
                    if (el.type === 'checkbox' || el.type === 'radio') {
                        if (el.checked) {
                            formData[el.name] = el.value;
                        }
                    } else {
                        formData[el.name] = el.value;
                    }
                });
                localStorage.setItem(draftStorageKey, JSON.stringify(formData));
            };

            const restoreDraft = () => {
                if (!addLeadForm || !window.localStorage) return;
                const stored = localStorage.getItem(draftStorageKey);
                if (!stored) return;

                try {
                    const data = JSON.parse(stored);
                    Object.entries(data).forEach(([name, value]) => {
                        const field = addLeadForm.elements[name];
                        if (!field) return;
                        if (field instanceof RadioNodeList) {
                            field.value = value;
                        } else {
                            field.value = value;
                        }
                    });
                } catch (error) {
                    console.error('Failed to parse lead draft', error);
                }
                updateChildrenTotal();
            };

            if (addLeadForm) {
                addLeadForm.querySelectorAll('input, select, textarea').forEach((field) => {
                    field.addEventListener('input', () => {
                        if (field.name === 'children_2_5' || field.name === 'children_6_11') {
                            updateChildrenTotal();
                        }
                        saveDraft();
                    });
                    field.addEventListener('change', () => {
                        if (field.name === 'children_2_5' || field.name === 'children_6_11') {
                            updateChildrenTotal();
                        }
                        saveDraft();
                    });
                });

                addLeadForm.addEventListener('submit', () => {
                    updateChildrenTotal();
                    if (window.localStorage) {
                        localStorage.removeItem(draftStorageKey);
                    }
                });
            }

            if (addLeadModalEl && typeof bootstrap !== 'undefined') {
                addLeadModalEl.addEventListener('shown.bs.modal', () => {
                    restoreDraft();
                    updateChildrenTotal();
                });

                if (hasDraftData()) {
                    const modalInstance = bootstrap.Modal.getOrCreateInstance(addLeadModalEl);
                    modalInstance.show();
                }
            } else {
                restoreDraft();
                updateChildrenTotal();
            }

            const viewLeadModalEl = document.getElementById('viewLeadModal');
            const viewLeadLoader = document.getElementById('viewLeadLoader');
            const viewLeadContent = document.getElementById('viewLeadContent');
            const viewLeadAlert = document.getElementById('viewLeadAlert');
            const viewLeadMeta = document.getElementById('viewLeadMeta');
            const viewLeadStatus = document.getElementById('viewLeadStatus');
            const viewLeadCustomer = document.getElementById('viewLeadCustomer');
            const viewLeadTitle = document.getElementById('viewLeadModalLabel');
            const viewLeadTSQ = document.getElementById('viewLeadTSQ');
            const viewLeadPhones = document.getElementById('viewLeadPhones');
            const viewLeadPhoneContainer = document.getElementById('viewLeadPhoneContainer');
            const viewLeadEmail = document.getElementById('viewLeadEmail');
            const viewLeadAddress = document.getElementById('viewLeadAddress');
            const viewLeadEmailContainer = document.getElementById('viewLeadEmailContainer');
            const viewLeadAddressContainer = document.getElementById('viewLeadAddressContainer');
            const viewLeadService = document.getElementById('viewLeadService');
            const viewLeadDestination = document.getElementById('viewLeadDestination');
            const viewLeadTravelDate = document.getElementById('viewLeadTravelDate');
            const viewLeadAssignedUser = document.getElementById('viewLeadAssignedUser');
            const viewLeadTravelers = document.getElementById('viewLeadTravelers');
            const viewLeadRemarksContainer = document.getElementById('viewLeadRemarks');
            const viewLeadRemarksCount = document.getElementById('viewLeadRemarksCount');
            const remarkForm = document.getElementById('leadRemarkForm');
            const remarkAlert = document.getElementById('leadRemarkAlert');
            let viewLeadModalInstance = null;
            let currentLeadId = null;

            const escapeHtml = (unsafe) => {
                if (unsafe === null || unsafe === undefined) {
                    return '';
                }
                return String(unsafe).replace(/[&<>"']/g, function(match) {
                    const map = {
                        '&': '&amp;',
                        '<': '&lt;',
                        '>': '&gt;',
                        '"': '&quot;',
                        "'": '&#039;',
                    };
                    return map[match] || match;
                });
            };

            const toggleText = (element, container, prefix, value) => {
                if (!element) return;
                if (value) {
                    element.textContent = prefix ? `${prefix} ${value}` : value;
                    if (container) {
                        container.classList.remove('d-none');
                    }
                    element.classList.remove('d-none');
                } else {
                    element.textContent = '';
                    if (container) {
                        container.classList.add('d-none');
                    }
                    element.classList.add('d-none');
                }
            };

            const renderPhoneNumbers = (primary, secondary, other) => {
                const phones = [];
                if (primary) phones.push({ number: primary, label: 'Primary' });
                if (secondary) phones.push({ number: secondary, label: 'Secondary' });
                if (other) phones.push({ number: other, label: 'Other' });

                if (phones.length === 0) {
                    return '';
                }

                // Clean phone number for tel: link (remove spaces, dashes, etc.)
                const cleanPhone = (phone) => {
                    return phone.replace(/[\s\-\(\)]/g, '');
                };

                return phones.map((phone, index) => {
                    const cleaned = cleanPhone(phone.number);
                    return `<a href="tel:${cleaned}" class="text-decoration-none text-primary fw-semibold">${escapeHtml(phone.number)}</a>${index < phones.length - 1 ? '<span class="text-muted">, </span>' : ''}`;
                }).join('');
            };

            const renderTravelerBadges = (lead) => {
                return `
                    <div class="d-flex flex-wrap gap-2">
                        <span class="badge bg-primary text-white px-3 py-2">
                            <i data-feather="users" class="me-1" style="width: 14px; height: 14px;"></i>
                            Adults: ${lead.adults ?? 0}
                        </span>
                        <span class="badge bg-info text-white px-3 py-2">
                            <i data-feather="smile" class="me-1" style="width: 14px; height: 14px;"></i>
                            2-5 yrs: ${lead.children_2_5 ?? 0}
                        </span>
                        <span class="badge bg-success text-white px-3 py-2">
                            <i data-feather="smile" class="me-1" style="width: 14px; height: 14px;"></i>
                            6-11 yrs: ${lead.children_6_11 ?? 0}
                        </span>
                        <span class="badge bg-warning text-dark px-3 py-2">
                            <i data-feather="heart" class="me-1" style="width: 14px; height: 14px;"></i>
                            Infants: ${lead.infants ?? 0}
                        </span>
                    </div>
                `;
            };

            const renderRemarks = (remarks) => {
                if (!remarks || !remarks.length) {
                    return '<p class="text-muted text-center mb-0 py-3">No remarks yet.</p>';
                }

                return remarks.map((remark, index) => {
                    const followUp = remark.follow_up_date ? 
                        `<span class="badge bg-danger text-white ms-2 px-2 py-1">
                            <i data-feather="calendar" class="me-1" style="width: 12px; height: 12px;"></i>
                            Follow-up: ${escapeHtml(remark.follow_up_date)}
                        </span>` : '';
                    return `
                        <div class="border rounded-3 p-3 mb-3 bg-light ${index === 0 ? 'border-primary' : ''}">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-rounded rounded-circle avatar-xs me-2" style="background-color: #007d88;">
                                        <span class="initial-wrap text-white fw-bold" style="font-size: 0.75rem;">
                                            ${escapeHtml((remark.user?.name ?? 'U')[0].toUpperCase())}
                                        </span>
                                    </div>
                                    <div>
                                        <strong class="d-block">${escapeHtml(remark.user?.name ?? 'Unknown')}</strong>
                                        ${followUp}
                                    </div>
                                </div>
                                <small class="text-muted">${escapeHtml(remark.created_at ?? '')}</small>
                            </div>
                            <p class="mb-0 mt-2 text-dark">${escapeHtml(remark.remark ?? '')}</p>
                        </div>
                    `;
                }).join('');
            };

            const resetViewLeadModal = () => {
                if (viewLeadLoader) {
                    viewLeadLoader.classList.remove('d-none');
                }
                if (viewLeadContent) {
                    viewLeadContent.classList.add('d-none');
                }
                if (viewLeadAlert) {
                    viewLeadAlert.classList.add('d-none');
                    viewLeadAlert.textContent = '';
                    viewLeadAlert.classList.remove('alert-danger', 'alert-success');
                }
                if (remarkAlert) {
                    remarkAlert.classList.add('d-none');
                    remarkAlert.textContent = '';
                    remarkAlert.classList.remove('alert-danger', 'alert-success');
                }
                if (remarkForm) {
                    remarkForm.reset();
                    remarkForm.dataset.leadId = '';
                }
            };

            const showViewLeadError = (message) => {
                if (viewLeadAlert) {
                    viewLeadAlert.classList.remove('d-none');
                    viewLeadAlert.classList.remove('alert-success');
                    viewLeadAlert.classList.add('alert-danger');
                    viewLeadAlert.textContent = message;
                }
                if (viewLeadLoader) {
                    viewLeadLoader.classList.add('d-none');
                }
                if (viewLeadContent) {
                    viewLeadContent.classList.add('d-none');
                }
            };

            const loadLeadDetails = async (leadId) => {
                if (!leadId || !leadsBaseUrl) {
                    showViewLeadError('Invalid lead.');
                    return;
                }

                currentLeadId = leadId;
                resetViewLeadModal();

                try {
                    const response = await fetch(`${leadsBaseUrl}/${leadId}?modal=1`, {
                        headers: {
                            'Accept': 'application/json',
                },
            });

                    if (!response.ok) {
                        throw new Error('Unable to load lead details.');
                    }

                    const data = await response.json();
                    const lead = data.lead;

                    if (!lead) {
                        throw new Error('Lead details not found.');
                    }

                    // Store lead data for editing
                    currentLeadData = lead;

                    if (viewLeadLoader) {
                        viewLeadLoader.classList.add('d-none');
                    }
                    if (viewLeadContent) {
                        viewLeadContent.classList.remove('d-none');
                    }

                    if (viewLeadTitle) {
                        viewLeadTitle.textContent = `${lead.tsq ?? 'Lead'} - ${lead.customer_name ?? ''}`;
                    }
                    if (viewLeadMeta) {
                        viewLeadMeta.textContent = lead.created_at ? `Created on ${lead.created_at}` : '';
                    }
                    if (viewLeadStatus) {
                        const statusClass = `badge ${lead.status_color ?? 'bg-secondary text-white'}`;
                        viewLeadStatus.className = statusClass;
                        viewLeadStatus.textContent = lead.status_label ?? lead.status ?? '-';
                    }
                    if (viewLeadCustomer) {
                        viewLeadCustomer.textContent = lead.customer_name ?? '-';
                    }
                    if (viewLeadTSQ) {
                        viewLeadTSQ.textContent = lead.tsq ? `TSQ: ${lead.tsq}` : '';
                        viewLeadTSQ.classList.toggle('d-none', !lead.tsq);
                    }

                    // Render phone numbers as comma-separated tel: links
                    if (viewLeadPhones && viewLeadPhoneContainer) {
                        const phoneHtml = renderPhoneNumbers(lead.primary_phone, lead.secondary_phone, lead.other_phone);
                        if (phoneHtml) {
                            viewLeadPhones.innerHTML = phoneHtml;
                            viewLeadPhoneContainer.classList.remove('d-none');
                        } else {
                            viewLeadPhones.innerHTML = '';
                            viewLeadPhoneContainer.classList.add('d-none');
                        }
                    }

                    toggleText(viewLeadEmail, viewLeadEmailContainer, 'Email:', lead.email);
                    toggleText(viewLeadAddress, viewLeadAddressContainer, 'Address:', lead.address);

                    if (viewLeadService) {
                        viewLeadService.textContent = lead.service ?? 'N/A';
                    }
                    if (viewLeadDestination) {
                        viewLeadDestination.textContent = lead.destination ?? 'N/A';
                    }
                    if (viewLeadTravelDate) {
                        viewLeadTravelDate.textContent = lead.travel_date ?? 'N/A';
                    }
                    if (viewLeadAssignedUser) {
                        viewLeadAssignedUser.textContent = lead.assigned_user ?? 'Unassigned';
                    }
                    if (viewLeadTravelers) {
                        viewLeadTravelers.innerHTML = renderTravelerBadges(lead);
                    }

                    if (viewLeadRemarksCount) {
                        viewLeadRemarksCount.textContent = data.remarks?.length ?? 0;
                    }
                    if (viewLeadRemarksContainer) {
                        viewLeadRemarksContainer.innerHTML = renderRemarks(data.remarks || []);
                    }

                    if (remarkForm) {
                        remarkForm.dataset.leadId = lead.id;
                    }

                    // Initialize Feather icons after content is loaded
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
                } catch (error) {
                    console.error(error);
                    showViewLeadError(error.message || 'Unexpected error occurred.');
                }
            };

            // Store loadLeadDetails on window for access in global event handler
            window.loadLeadDetails = loadLeadDetails;

            // Initialize modal instance first and store on window for access
            if (viewLeadModalEl && typeof bootstrap !== 'undefined') {
                if (!viewLeadModalInstance) {
                    viewLeadModalInstance = new bootstrap.Modal(viewLeadModalEl, {
                        backdrop: 'static',
                        keyboard: false
                    });
                    // Store on window for access in event handler
                    window.viewLeadModalInstance = viewLeadModalInstance;
                }
            }

            // Use event delegation on document to catch clicks on dynamically created buttons
            // This must be outside the conditional to work with DataTable
            // Use a named function to prevent duplicate listeners
            if (!window.viewLeadClickHandler) {
                window.viewLeadClickHandler = function(event) {
                    // Check if the clicked element or its parent has the view-lead-btn class
                    const button = event.target.closest('.view-lead-btn');
                    if (!button) {
                        return;
                    }

                    event.preventDefault();
                    event.stopPropagation();

                    const leadId = button.dataset.leadId || button.getAttribute('data-lead-id');
                    
                    if (!leadId) {
                        console.error('No lead ID found on button', button);
                        return;
                    }

                    // Get modal element
                    const modalEl = document.getElementById('viewLeadModal');
                    if (!modalEl) {
                        console.error('View lead modal element not found');
                        return;
                    }

                    // Get or create modal instance
                    let modalInstance = window.viewLeadModalInstance || viewLeadModalInstance;
                    if (!modalInstance && typeof bootstrap !== 'undefined') {
                        modalInstance = new bootstrap.Modal(modalEl, {
                            backdrop: 'static',
                            keyboard: false
                        });
                        window.viewLeadModalInstance = modalInstance;
                        viewLeadModalInstance = modalInstance;
                    }

                    if (modalInstance) {
                        modalInstance.show();
                        // Use window.loadLeadDetails which was stored from document.ready
                        if (typeof window.loadLeadDetails === 'function') {
                            window.loadLeadDetails(leadId);
                        } else {
                            console.error('loadLeadDetails function not found on window');
                        }
                    } else {
                        console.error('Bootstrap modal not available');
                    }
                };

                // Attach the event listener with capture phase
                document.addEventListener('click', window.viewLeadClickHandler, true);
            }

            if (viewLeadModalEl) {
                viewLeadModalEl.addEventListener('shown.bs.modal', () => {
                    // Initialize Feather icons when modal is shown
                    if (typeof feather !== 'undefined') {
                        feather.replace();
                    }
                });

                viewLeadModalEl.addEventListener('hidden.bs.modal', () => {
                    currentLeadId = null;
                    currentLeadData = null;
                    resetViewLeadModal();
                    // Reset to view mode if in edit mode
                    const viewContent = document.getElementById('viewLeadContent');
                    const editContent = document.getElementById('editLeadContent');
                    const editBtn = document.getElementById('editLeadBtn');
                    const cancelBtn = document.getElementById('cancelEditBtn');
                    const modalTitle = document.getElementById('viewLeadModalTitle');
                    if (viewContent) viewContent.classList.remove('d-none');
                    if (editContent) editContent.classList.add('d-none');
                    if (editBtn) editBtn.classList.remove('d-none');
                    if (cancelBtn) cancelBtn.classList.add('d-none');
                    if (modalTitle) modalTitle.textContent = 'Lead Details';
                });
            }

            if (remarkForm) {
                remarkForm.addEventListener('submit', async (event) => {
                    event.preventDefault();
                    if (!currentLeadId || !leadsBaseUrl) {
                        return;
                    }

                    remarkAlert.classList.add('d-none');
                    remarkAlert.classList.remove('alert-danger', 'alert-success');

                    const formData = new FormData(remarkForm);

                    try {
                        const response = await fetch(`${leadsBaseUrl}/${currentLeadId}/remarks`, {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json',
                            },
                            body: formData,
                        });

                        const payload = await response.json();

                        if (!response.ok) {
                            const message = payload?.message || Object.values(payload?.errors || {})[0]?.[0] || 'Failed to add remark.';
                            throw new Error(message);
                        }

                        remarkAlert.classList.remove('d-none');
                        remarkAlert.classList.add('alert-success');
                        remarkAlert.textContent = payload?.message || 'Remark added successfully!';
                        remarkForm.reset();
                        if (typeof window.loadLeadDetails === 'function') {
                            window.loadLeadDetails(currentLeadId);
                        }
                    } catch (error) {
                        remarkAlert.classList.remove('d-none');
                        remarkAlert.classList.add('alert-danger');
                        remarkAlert.textContent = error.message || 'Unable to add remark.';
                    }
                });
            }

            // Edit Lead Functionality
            const editLeadBtn = document.getElementById('editLeadBtn');
            const cancelEditBtn = document.getElementById('cancelEditBtn');
            const cancelEditFormBtn = document.getElementById('cancelEditFormBtn');
            const editLeadContent = document.getElementById('editLeadContent');
            const editLeadForm = document.getElementById('editLeadForm');
            const editLeadAlert = document.getElementById('editLeadAlert');
            const viewLeadModalTitle = document.getElementById('viewLeadModalTitle');
            let currentEditLeadId = null;
            let currentLeadData = null;

            // Function to populate edit form with lead data
            const populateEditForm = (lead) => {
                if (!lead) return;

                document.getElementById('editFirstName').value = lead.first_name || '';
                document.getElementById('editMiddleName').value = lead.middle_name || '';
                document.getElementById('editLastName').value = lead.last_name || '';
                document.getElementById('editPrimaryPhone').value = lead.primary_phone || '';
                document.getElementById('editSecondaryPhone').value = lead.secondary_phone || '';
                document.getElementById('editOtherPhone').value = lead.other_phone || '';
                document.getElementById('editEmail').value = lead.email || '';
                document.getElementById('editAddress').value = lead.address || '';
                document.getElementById('editServiceId').value = lead.service_id || '';
                document.getElementById('editDestinationId').value = lead.destination_id || '';
                document.getElementById('editTravelDate').value = lead.travel_date_raw || '';
                document.getElementById('editAdults').value = lead.adults || 0;
                document.getElementById('editChildren25').value = lead.children_2_5 || 0;
                document.getElementById('editChildren611').value = lead.children_6_11 || 0;
                document.getElementById('editInfants').value = lead.infants || 0;
                document.getElementById('editAssignedUserId').value = lead.assigned_user_id || '';
                document.getElementById('editStatus').value = lead.status || 'new';
            };

            // Function to switch to edit mode
            const switchToEditMode = () => {
                if (viewLeadContent) viewLeadContent.classList.add('d-none');
                if (editLeadContent) editLeadContent.classList.remove('d-none');
                if (editLeadBtn) editLeadBtn.classList.add('d-none');
                if (cancelEditBtn) cancelEditBtn.classList.remove('d-none');
                if (viewLeadModalTitle) viewLeadModalTitle.textContent = 'Edit Lead';
                if (typeof feather !== 'undefined') feather.replace();
            };

            // Function to switch back to view mode
            const switchToViewMode = () => {
                if (viewLeadContent) viewLeadContent.classList.remove('d-none');
                if (editLeadContent) editLeadContent.classList.add('d-none');
                if (editLeadBtn) editLeadBtn.classList.remove('d-none');
                if (cancelEditBtn) cancelEditBtn.classList.add('d-none');
                if (viewLeadModalTitle) viewLeadModalTitle.textContent = 'Lead Details';
                if (editLeadAlert) {
                    editLeadAlert.classList.add('d-none');
                    editLeadAlert.textContent = '';
                }
            };

            // Edit button click handler
            if (editLeadBtn) {
                editLeadBtn.addEventListener('click', () => {
                    if (currentLeadId && currentLeadData) {
                        currentEditLeadId = currentLeadId;
                        populateEditForm(currentLeadData);
                        switchToEditMode();
                    }
                });
            }

            // Cancel edit button handlers
            if (cancelEditBtn) {
                cancelEditBtn.addEventListener('click', () => {
                    switchToViewMode();
                });
            }

            if (cancelEditFormBtn) {
                cancelEditFormBtn.addEventListener('click', () => {
                    switchToViewMode();
                });
            }

            // Edit form submission
            if (editLeadForm) {
                editLeadForm.addEventListener('submit', async (event) => {
                    event.preventDefault();
                    if (!currentEditLeadId || !leadsBaseUrl) {
                        return;
                    }

                    if (editLeadAlert) {
                        editLeadAlert.classList.add('d-none');
                        editLeadAlert.classList.remove('alert-danger', 'alert-success');
                    }

                    try {
                        const formData = new FormData(editLeadForm);
                        // Ensure _method is set for Laravel method spoofing
                        formData.append('_method', 'PUT');
                        const response = await fetch(`${leadsBaseUrl}/${currentEditLeadId}`, {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json',
                            },
                            body: formData,
                        });

                        const payload = await response.json();

                        if (!response.ok) {
                            const message = payload?.message || Object.values(payload?.errors || {})[0]?.[0] || 'Failed to update lead.';
                            throw new Error(message);
                        }

                        if (editLeadAlert) {
                            editLeadAlert.classList.remove('d-none');
                            editLeadAlert.classList.add('alert-success');
                            editLeadAlert.textContent = payload?.message || 'Lead updated successfully!';
                        }

                        // Reload lead details and switch back to view mode
                        setTimeout(() => {
                            if (typeof window.loadLeadDetails === 'function') {
                                window.loadLeadDetails(currentEditLeadId);
                            }
                            switchToViewMode();
                        }, 1000);
                    } catch (error) {
                        if (editLeadAlert) {
                            editLeadAlert.classList.remove('d-none');
                            editLeadAlert.classList.add('alert-danger');
                            editLeadAlert.textContent = error.message || 'Unable to update lead.';
                        }
                    }
                });
            }


            // Assign User Modal
            const assignUserModalEl = document.getElementById('assignUserModal');
            const assignUserButtons = document.querySelectorAll('.assign-user-btn');
            const assignUserLeadName = document.getElementById('assignUserLeadName');
            const assignUserCurrentUser = document.getElementById('assignUserCurrentUser');
            const assignUserSelect = document.getElementById('assignUserSelect');
            const assignUserSubmitBtn = document.getElementById('assignUserSubmitBtn');
            const assignUserAlert = document.getElementById('assignUserAlert');
            let assignUserModalInstance = null;
            let currentAssignLeadId = null;

            if (assignUserModalEl && typeof bootstrap !== 'undefined') {
                assignUserModalInstance = new bootstrap.Modal(assignUserModalEl);
            }

            // Handle assign user button clicks
            document.addEventListener('click', function(event) {
                const button = event.target.closest('.assign-user-btn');
                if (!button) {
                    return;
                }

                event.preventDefault();
                event.stopPropagation();

                const leadId = button.dataset.leadId || button.getAttribute('data-lead-id');
                const leadName = button.dataset.leadName || button.getAttribute('data-lead-name');
                const currentUser = button.dataset.currentUser || button.getAttribute('data-current-user');

                if (!leadId) {
                    console.error('No lead ID found on button');
                    return;
                }

                currentAssignLeadId = leadId;

                if (assignUserLeadName) {
                    assignUserLeadName.value = leadName || 'N/A';
                }
                if (assignUserCurrentUser) {
                    assignUserCurrentUser.value = currentUser || 'Unassigned';
                }
                if (assignUserSelect) {
                    assignUserSelect.value = '';
                }
                if (assignUserAlert) {
                    assignUserAlert.classList.add('d-none');
                    assignUserAlert.textContent = '';
                }

                if (assignUserModalInstance) {
                    assignUserModalInstance.show();
                }
            });

            // Handle assign user form submission
            if (assignUserSubmitBtn) {
                assignUserSubmitBtn.addEventListener('click', async function() {
                    if (!currentAssignLeadId || !assignUserSelect || !leadsBaseUrl) {
                        return;
                    }

                    const userId = assignUserSelect.value;
                    if (!userId) {
                        if (assignUserAlert) {
                            assignUserAlert.classList.remove('d-none');
                            assignUserAlert.classList.remove('alert-success');
                            assignUserAlert.classList.add('alert-danger');
                            assignUserAlert.textContent = 'Please select a user to assign.';
                        }
                        return;
                    }

                    if (assignUserAlert) {
                        assignUserAlert.classList.add('d-none');
                        assignUserAlert.classList.remove('alert-danger', 'alert-success');
                    }

                    try {
                        const response = await fetch(`${leadsBaseUrl}/${currentAssignLeadId}/assign-user`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                            },
                            body: JSON.stringify({
                                assigned_user_id: userId
                            })
                        });

                        const payload = await response.json();

                        if (!response.ok) {
                            const message = payload?.message || Object.values(payload?.errors || {})[0]?.[0] || 'Failed to assign user.';
                            throw new Error(message);
                        }

                        if (assignUserAlert) {
                            assignUserAlert.classList.remove('d-none');
                            assignUserAlert.classList.add('alert-success');
                            assignUserAlert.textContent = payload?.message || 'User assigned successfully!';
                        }

                        // Close modal after a short delay
                        setTimeout(() => {
                            if (assignUserModalInstance) {
                                assignUserModalInstance.hide();
                            }
                            // Reload page to update the table
                            window.location.reload();
                        }, 1000);
                    } catch (error) {
                        if (assignUserAlert) {
                            assignUserAlert.classList.remove('d-none');
                            assignUserAlert.classList.add('alert-danger');
                            assignUserAlert.textContent = error.message || 'Unable to assign user.';
                        }
                    }
                });
            }

            // Initialize Feather icons when assign modal is shown
            if (assignUserModalEl) {
                assignUserModalEl.addEventListener('shown.bs.modal', () => {
                    if (typeof feather !== 'undefined') {
                        feather.replace();
                    }
                });
            }
        });
    </script>
    @endpush
    
    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const modalElement = document.getElementById('addLeadModal');
                if (modalElement && typeof bootstrap !== 'undefined') {
                    const addLeadModal = new bootstrap.Modal(modalElement);
                    addLeadModal.show();
                }
            });
        </script>
    @endif
@endsection
