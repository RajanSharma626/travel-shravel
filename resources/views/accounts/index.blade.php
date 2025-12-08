@extends('layouts.app')
@section('title', 'Accounts | Travel Shravel')
@section('content')
    <div class="hk-pg-wrapper pb-0">
        <div class="hk-pg-body py-0">
            <div class="contactapp-wrap">
                <div class="contactapp-content">
                    <div class="contactapp-detail-wrap">
                        <header class="contact-header">
                            <div class="w-100 align-items-center justify-content-between d-flex contactapp-title link-dark">
                                <h1>Accounts</h1>
                                @can('export reports')
                                <div>
                                    <a href="{{ route('api.accounts.export') }}" class="btn btn-primary btn-sm">
                                        <i data-feather="download" class="me-1" style="width: 16px; height: 16px;"></i>
                                        Export
                                    </a>
                                </div>
                                @endcan
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

                                <!-- Statistics Cards -->
                                <div class="row g-3 mb-4">
                                    <div class="col-md-4">
                                        <div class="card border-0 shadow-sm">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1">
                                                        <h6 class="text-muted mb-1 small">Total Revenue</h6>
                                                        <h4 class="mb-0 fw-bold text-success">₹{{ number_format($totalRevenue, 2) }}</h4>
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                        <i data-feather="trending-up" class="text-success" style="width: 40px; height: 40px;"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card border-0 shadow-sm">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1">
                                                        <h6 class="text-muted mb-1 small">Total Cost</h6>
                                                        <h4 class="mb-0 fw-bold text-danger">₹{{ number_format($totalCost, 2) }}</h4>
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                        <i data-feather="trending-down" class="text-danger" style="width: 40px; height: 40px;"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card border-0 shadow-sm">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1">
                                                        <h6 class="text-muted mb-1 small">Net Profit</h6>
                                                        <h4 class="mb-0 fw-bold {{ $netProfit >= 0 ? 'text-success' : 'text-danger' }}">₹{{ number_format($netProfit, 2) }}</h4>
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                        <i data-feather="dollar-sign" class="{{ $netProfit >= 0 ? 'text-success' : 'text-danger' }}" style="width: 40px; height: 40px;"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <form method="GET" action="{{ route('accounts.index') }}" class="row g-3 mb-4"
                                    id="accountsFiltersForm">
                                    <div class="col-md-4 col-lg-3">
                                        <label for="search" class="form-label">Search</label>
                                        <div class="d-flex">
                                            <input type="text" name="search" id="search"
                                                class="form-control form-control-sm"
                                                placeholder="Enter name, ref no., or phone"
                                                value="{{ $filters['search'] ?? '' }}">
                                            <button type="submit" class="btn btn-primary btn-sm ms-2 d-flex"> <i
                                                    class="ri-search-line me-1"></i> Filter</button>
                                        </div>
                                    </div>
                                    @if (!empty($filters['search']) || !empty($filters['payment_status']))
                                        <div class="col-md-3 col-lg-2 align-self-end ms-auto">
                                            <a href="{{ route('accounts.index') }}"
                                                class="btn btn-outline-danger w-100 btn-sm">Clear
                                                Filters</a>
                                        </div>
                                    @endif
                                </form>

                                <table class="table table-striped small table-bordered w-100 mb-5" id="accountsTable">
                                    <thead>
                                        <tr>
                                            <th>Ref No.</th>
                                            <th>Customer Name</th>
                                            <th>Phone</th>
                                            <th>Total Paid</th>
                                            <th>Total Cost</th>
                                            <th>Profit</th>
                                            <th>Last Remark</th>
                                            <th>Created On</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($leads as $lead)
                                            @php
                                                $totalPaid = $lead->payments->where('status', 'received')->sum('amount');
                                                $totalCost = $lead->costComponents->sum('amount');
                                                $profit = ($lead->selling_price ?? 0) - $totalCost;
                                            @endphp
                                            <tr data-lead-id="{{ $lead->id }}">
                                                <td><strong>{{ $lead->tsq }}</strong></td>
                                                <td>
                                                    <a href="{{ route('bookings.form', $lead) }}"
                                                        class="text-primary text-decoration-none fw-semibold">
                                                        {{ $lead->customer_name }}
                                                    </a>
                                                </td>
                                                <td>{{ $lead->primary_phone ?? $lead->phone }}</td>
                                                <td>
                                                    <span class="fw-semibold text-success">₹{{ number_format($totalPaid, 2) }}</span>
                                                </td>
                                                <td>
                                                    <span class="fw-semibold text-danger">₹{{ number_format($totalCost, 2) }}</span>
                                                </td>
                                                <td>
                                                    <span class="fw-semibold {{ $profit >= 0 ? 'text-success' : 'text-danger' }}">
                                                        ₹{{ number_format($profit, 2) }}
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
                                                            <a href="{{ route('bookings.form', $lead) }}"
                                                                class="btn btn-icon btn-flush-dark btn-rounded flush-soft-hover"
                                                                data-bs-toggle="tooltip" data-placement="top"
                                                                title="Booking File">
                                                                <span class="icon">
                                                                    <span class="feather-icon">
                                                                        <i data-feather="file-text"></i>
                                                                    </span>
                                                                </span>
                                                            </a>

                                                            @can('create costs')
                                                                <button type="button"
                                                                    class="btn btn-icon btn-flush-dark btn-rounded flush-soft-hover cost-breakdown-btn"
                                                                    data-lead-id="{{ $lead->id }}"
                                                                    data-lead-tsq="{{ $lead->tsq }}"
                                                                    data-lead-name="{{ $lead->customer_name }}"
                                                                    data-bs-toggle="tooltip"
                                                                    data-placement="top" title="Cost Breakdown">
                                                                    <span class="icon">
                                                                        <span class="feather-icon">
                                                                            <i data-feather="dollar-sign"></i>
                                                                        </span>
                                                                    </span>
                                                                </button>
                                                            @endcan
                                                            @can('create payments')
                                                                <button type="button"
                                                                    class="btn btn-icon btn-flush-dark btn-rounded flush-soft-hover add-payment-btn"
                                                                    data-lead-id="{{ $lead->id }}"
                                                                    data-lead-tsq="{{ $lead->tsq }}"
                                                                    data-lead-name="{{ $lead->customer_name }}"
                                                                    data-bs-toggle="tooltip"
                                                                    data-placement="top" title="Add Payment">
                                                                    <span class="icon">
                                                                        <span class="feather-icon">
                                                                            <i data-feather="credit-card"></i>
                                                                        </span>
                                                                    </span>
                                                                </button>
                                                            @endcan
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="9" class="text-center">No accounts found</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                <!-- Pagination -->
                                @if($leads->hasPages())
                                <div class="d-flex justify-content-between align-items-center mt-4 mb-3 px-3">
                                    <div class="text-muted small">
                                        Showing {{ $leads->firstItem() ?? 0 }} to {{ $leads->lastItem() ?? 0 }} of {{ $leads->total() }} entries
                                    </div>
                                    <div>
                                        {{ $leads->links('pagination::bootstrap-5') }}
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footer')
    </div>

    <!-- View Lead Modal - Same as bookings page -->
    <div class="modal fade" id="viewLeadModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="viewLeadModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-light border-bottom">
                    <div class="flex-grow-1">
                        <h5 class="modal-title fw-bold mb-1" id="viewLeadModalLabel">
                            <i data-feather="user" class="me-2" style="width: 20px; height: 20px;"></i>
                            <span id="viewLeadModalTitle">Lead Details</span>
                        </h5>
                        <small class="text-muted" id="viewLeadMeta"></small>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div id="viewLeadAlert" class="alert d-none mb-3" role="alert"></div>

                    <div id="viewLeadLoader" class="text-center py-5">
                        <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;"></div>
                        <p class="mt-3 text-muted mb-0">Loading lead details...</p>
                    </div>

                    <div id="viewLeadContent" class="d-none">
                        <!-- Customer Information -->
                        <div class="mb-4 border rounded-3 p-3 bg-light">
                            <h6 class="text-uppercase text-muted small fw-semibold mb-3">Customer Information</h6>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label">First Name</label>
                                    <input type="text" id="viewFirstName" class="form-control form-control-sm"
                                        readonly>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Last Name</label>
                                    <input type="text" id="viewLastName" class="form-control form-control-sm"
                                        readonly>
                                </div>
                            </div>
                        </div>

                        <!-- Contact Information -->
                        <div class="mb-4 border rounded-3 p-3">
                            <h6 class="text-uppercase text-muted small fw-semibold mb-3">Contact Information</h6>
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label class="form-label">Primary Number</label>
                                    <input type="text" id="viewPrimaryPhone" class="form-control form-control-sm"
                                        readonly>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Secondary Number</label>
                                    <input type="text" id="viewSecondaryPhone" class="form-control form-control-sm"
                                        readonly>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Emergency No.</label>
                                    <input type="text" id="viewOtherPhone" class="form-control form-control-sm"
                                        readonly>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" id="viewEmail" class="form-control form-control-sm" readonly>
                                </div>
                            </div>
                            <div class="row g-3 mt-1">
                                <div class="col-md-12">
                                    <label class="form-label">Address</label>
                                    <input type="text" id="viewAddressLine" class="form-control form-control-sm"
                                        readonly>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">City</label>
                                    <input type="text" id="viewCity" class="form-control form-control-sm" readonly>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">State</label>
                                    <input type="text" id="viewState" class="form-control form-control-sm" readonly>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Country</label>
                                    <input type="text" id="viewCountry" class="form-control form-control-sm" readonly>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Pin Code</label>
                                    <input type="text" id="viewPinCode" class="form-control form-control-sm" readonly>
                                </div>
                            </div>
                        </div>

                        <!-- Travel Preferences -->
                        <div class="mb-4 border rounded-3 p-3 bg-light">
                            <h6 class="text-uppercase text-muted small fw-semibold mb-3">Travel Preferences</h6>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label">Service</label>
                                    <input type="text" id="viewService" class="form-control form-control-sm" readonly>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Destination</label>
                                    <input type="text" id="viewDestination" class="form-control form-control-sm"
                                        readonly>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Travel Date</label>
                                    <input type="text" id="viewTravelDate" class="form-control form-control-sm"
                                        readonly>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Adults</label>
                                    <input type="text" id="viewAdults" class="form-control form-control-sm" readonly>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Children (2-5 yrs)</label>
                                    <input type="text" id="viewChildren25" class="form-control form-control-sm"
                                        readonly>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Children (6-11 yrs)</label>
                                    <input type="text" id="viewChildren611" class="form-control form-control-sm"
                                        readonly>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Infants (below 2 yrs)</label>
                                    <input type="text" id="viewInfants" class="form-control form-control-sm" readonly>
                                </div>
                            </div>
                        </div>

                        <!-- Assignment -->
                        <div class="mb-4 border rounded-3 p-3">
                            <h6 class="text-uppercase text-muted small fw-semibold mb-3">Assignment</h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Assign To</label>
                                    <input type="text" id="viewAssignedUser" class="form-control form-control-sm"
                                        readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Status</label>
                                    <input type="text" id="viewStatus" class="form-control form-control-sm" readonly>
                                </div>
                            </div>
                        </div>

                        <!-- Recent Remarks -->
                        <div class="card border-0 shadow-sm">
                            <div
                                class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                                <h6 class="mb-0 fw-semibold">
                                    <i data-feather="list" class="me-2 text-warning"
                                        style="width: 18px; height: 18px;"></i>
                                    Recent Remarks
                                </h6>
                                <span class="badge bg-primary rounded-pill px-3 py-2" id="viewLeadRemarksCount">0</span>
                            </div>
                            <div class="card-body p-4" id="viewLeadRemarks" style="max-height: 400px; overflow-y: auto;">
                                <p class="text-muted text-center mb-0 py-3">No remarks yet.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-top">
                    <div class="w-100">
                        <form id="leadRemarkForm">
                            @csrf

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label small mb-1">Add Remark <span
                                            class="text-danger">*</span></label>
                                    <textarea name="remark" class="form-control form-control-sm" rows="2" placeholder="Enter your remark here..."
                                        required></textarea>
                                </div>
                                <div class="col-md-12 d-flex justify-content-end gap-2">
                                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                                        <i data-feather="x" class="me-1" style="width: 14px; height: 14px;"></i>
                                        Close
                                    </button>
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        <i data-feather="send" class="me-1" style="width: 14px; height: 14px;"></i>
                                        Add Remark
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cost Breakdown Modal -->
    <div class="modal fade" id="costBreakdownModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="costBreakdownModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-light border-bottom">
                    <div class="flex-grow-1">
                        <h5 class="modal-title fw-bold mb-1" id="costBreakdownModalLabel">
                            <i data-feather="dollar-sign" class="me-2" style="width: 20px; height: 20px;"></i>
                            Cost Breakdown - <span id="costBreakdownLeadInfo"></span>
                        </h5>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div id="costBreakdownAlert" class="alert d-none mb-3" role="alert"></div>

                    <!-- Add Cost Component Form -->
                    <div class="card border mb-4">
                        <div class="card-header bg-light">
                            <h6 class="mb-0 fw-semibold">Add Cost Component</h6>
                        </div>
                        <div class="card-body">
                            <form id="addCostForm">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Cost Name <span class="text-danger">*</span></label>
                                        <input type="text" name="name" id="costName" class="form-control form-control-sm"
                                            placeholder="e.g. Hotel Booking, Flight Tickets" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Amount <span class="text-danger">*</span></label>
                                        <input type="number" name="amount" id="costAmount" step="0.01" min="0"
                                            class="form-control form-control-sm" placeholder="0.00" required>
                                    </div>
                                    <div class="col-md-2 d-flex align-items-end">
                                        <button type="submit" class="btn btn-primary btn-sm w-100">
                                            <i data-feather="plus" class="me-1" style="width: 14px; height: 14px;"></i>
                                            Add
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Cost Components List -->
                    <div class="card border">
                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                            <h6 class="mb-0 fw-semibold">Cost Components</h6>
                            <span class="badge bg-primary" id="totalCostBadge">₹0.00</span>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0" id="costComponentsTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Name</th>
                                            <th>Amount</th>
                                            <th>Entered By</th>
                                            <th>Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="costComponentsBody">
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-4">No cost components added yet</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-top">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Payment Modal -->
    <div class="modal fade" id="addPaymentModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="addPaymentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-light border-bottom">
                    <div class="flex-grow-1">
                        <h5 class="modal-title fw-bold mb-1" id="addPaymentModalLabel">
                            <i data-feather="credit-card" class="me-2" style="width: 20px; height: 20px;"></i>
                            Add Payment - <span id="addPaymentLeadInfo"></span>
                        </h5>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div id="addPaymentAlert" class="alert d-none mb-3" role="alert"></div>

                    <form id="addPaymentForm">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Amount <span class="text-danger">*</span></label>
                                <input type="number" name="amount" id="paymentAmount" step="0.01" min="0"
                                    class="form-control form-control-sm" placeholder="0.00" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Payment Date <span class="text-danger">*</span></label>
                                <input type="date" name="payment_date" id="paymentDate"
                                    class="form-control form-control-sm" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Payment Method <span class="text-danger">*</span></label>
                                <select name="method" id="paymentMethod" class="form-select form-select-sm" required>
                                    <option value="">-- Select Method --</option>
                                    <option value="cash">Cash</option>
                                    <option value="bank_transfer">Bank Transfer</option>
                                    <option value="cheque">Cheque</option>
                                    <option value="card">Card</option>
                                    <option value="online">Online</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <select name="status" id="paymentStatus" class="form-select form-select-sm" required>
                                    <option value="pending">Pending</option>
                                    <option value="received" selected>Received</option>
                                    <option value="refunded">Refunded</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Reference Number</label>
                                <input type="text" name="reference" id="paymentReference"
                                    class="form-control form-control-sm" placeholder="Transaction/Cheque number">
                            </div>
                        </div>
                        <div class="mt-4 d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">
                                <i data-feather="save" class="me-1" style="width: 16px; height: 16px;"></i>
                                Add Payment
                            </button>
                        </div>
                    </form>

                    <!-- Existing Payments List -->
                    <div class="card border mt-4">
                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                            <h6 class="mb-0 fw-semibold">Payment History</h6>
                            <span class="badge bg-success" id="totalPaidBadge">₹0.00</span>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0" id="paymentsTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Date</th>
                                            <th>Amount</th>
                                            <th>Method</th>
                                            <th>Reference</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="paymentsBody">
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-4">No payments recorded yet</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        $(document).ready(function() {
            const leadsBaseUrl = '/leads';
            
            // Initialize DataTable without search, length menu, ordering, and pagination
            // We use Laravel's server-side pagination instead
            if ($('#accountsTable').length) {
                $('#accountsTable').DataTable({
                    searching: false, // Disable search box
                    lengthChange: false, // Disable entries per page selector
                    ordering: false, // Disable column ordering
                    info: false, // Disable DataTable info (we use Laravel pagination)
                    paging: false, // Disable DataTable pagination (we use Laravel pagination)
                    dom: 'rt' // Only show table (r), table (t) - no info or pagination
                });
            }

            // Safe feather replace function
            const safeFeatherReplace = (container) => {
                if (typeof feather !== 'undefined' && container) {
                    try {
                        feather.replace({}, container);
                    } catch (e) {
                        console.warn('Feather icon replacement failed:', e);
                    }
                }
            };

            // View Lead Modal Elements
            const viewLeadModalEl = document.getElementById('viewLeadModal');
            const viewLeadLoader = document.getElementById('viewLeadLoader');
            const viewLeadContent = document.getElementById('viewLeadContent');
            const viewLeadAlert = document.getElementById('viewLeadAlert');
            const viewLeadMeta = document.getElementById('viewLeadMeta');
            const viewLeadTitle = document.getElementById('viewLeadModalTitle');
            let viewLeadModalInstance = null;
            let currentLeadId = null;

            // Escape HTML function
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

            // Render remarks function
            const renderRemarks = (remarks) => {
                if (!remarks || !remarks.length) {
                    return '<p class="text-muted text-center mb-0 py-4"><i data-feather="message-circle" class="me-2" style="width: 16px; height: 16px;"></i>No remarks yet.</p>';
                }

                return remarks.map((remark, index) => {
                    const followUp = remark.follow_up_date ?
                        `<span class="badge bg-light text-danger border border-danger ms-2 px-2 py-1">
                            <i data-feather="calendar" class="me-1" style="width: 12px; height: 12px;"></i>
                            Follow-up: ${escapeHtml(remark.follow_up_date)}
                        </span>` : '';
                    return `
                        <div class="border rounded-3 p-3 mb-3 bg-white border">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div class="d-flex align-items-start flex-grow-1">
                                    <div class="avatar avatar-rounded rounded-circle me-3 flex-shrink-0" style="background-color: #007d88; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                        <span class="text-white fw-bold" style="font-size: 0.875rem;">
                                            ${escapeHtml((remark.user?.name ?? 'U')[0].toUpperCase())}
                                        </span>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex align-items-center flex-wrap gap-2 mb-1">
                                            <strong class="text-dark">${escapeHtml(remark.user?.name ?? 'Unknown')}</strong>
                                            ${followUp}
                                        </div>
                                        <p class="mb-0 text-dark" style="line-height: 1.6;">${escapeHtml(remark.remark ?? '')}</p>
                                    </div>
                                </div>
                                <small class="text-muted flex-shrink-0 ms-2" style="white-space: nowrap;">${escapeHtml(remark.created_at ?? '')}</small>
                            </div>
                        </div>
                    `;
                }).join('');
            };

            // Reset view lead modal
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
            };

            // Show view lead error
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

            // Load lead details
            const loadLeadDetails = async (leadId) => {
                if (!leadId || !leadsBaseUrl) {
                    showViewLeadError('Invalid lead.');
                    return Promise.reject('Invalid lead.');
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
                    window.currentLeadData = lead;

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

                    // Populate Customer Information
                    const viewFirstName = document.getElementById('viewFirstName');
                    const viewMiddleName = document.getElementById('viewMiddleName');
                    const viewLastName = document.getElementById('viewLastName');
                    if (viewFirstName) viewFirstName.value = lead.first_name || '';
                    if (viewLastName) viewLastName.value = lead.last_name || '';

                    // Populate Contact Information
                    const viewPrimaryPhone = document.getElementById('viewPrimaryPhone');
                    const viewSecondaryPhone = document.getElementById('viewSecondaryPhone');
                    const viewOtherPhone = document.getElementById('viewOtherPhone');
                    const viewEmail = document.getElementById('viewEmail');
                    if (viewPrimaryPhone) viewPrimaryPhone.value = lead.primary_phone || '';
                    if (viewSecondaryPhone) viewSecondaryPhone.value = lead.secondary_phone || '';
                    if (viewOtherPhone) viewOtherPhone.value = lead.other_phone || '';
                    if (viewEmail) viewEmail.value = lead.email || '';

                    // Populate Address fields
                    const viewAddressLine = document.getElementById('viewAddressLine');
                    const viewCity = document.getElementById('viewCity');
                    const viewState = document.getElementById('viewState');
                    const viewCountry = document.getElementById('viewCountry');
                    const viewPinCode = document.getElementById('viewPinCode');
                    if (viewAddressLine) viewAddressLine.value = lead.address_line || '';
                    if (viewCity) viewCity.value = lead.city || '';
                    if (viewState) viewState.value = lead.state || '';
                    if (viewCountry) viewCountry.value = lead.country || '';
                    if (viewPinCode) viewPinCode.value = lead.pin_code || '';

                    // Populate Travel Preferences
                    const viewLeadService = document.getElementById('viewService');
                    const viewLeadDestination = document.getElementById('viewDestination');
                    const viewLeadTravelDate = document.getElementById('viewTravelDate');
                    if (viewLeadService) {
                        viewLeadService.value = lead.service ?? 'N/A';
                    }
                    if (viewLeadDestination) {
                        viewLeadDestination.value = lead.destination ?? 'N/A';
                    }
                    if (viewLeadTravelDate) {
                        viewLeadTravelDate.value = lead.travel_date ?? 'N/A';
                    }
                    const viewAdults = document.getElementById('viewAdults');
                    const viewChildren25 = document.getElementById('viewChildren25');
                    const viewChildren611 = document.getElementById('viewChildren611');
                    const viewInfants = document.getElementById('viewInfants');
                    if (viewAdults) viewAdults.value = lead.adults ?? 0;
                    if (viewChildren25) viewChildren25.value = lead.children_2_5 ?? 0;
                    if (viewChildren611) viewChildren611.value = lead.children_6_11 ?? 0;
                    if (viewInfants) viewInfants.value = lead.infants ?? 0;

                    // Populate Assignment
                    const viewLeadAssignedUser = document.getElementById('viewAssignedUser');
                    if (viewLeadAssignedUser) {
                        viewLeadAssignedUser.value = lead.assigned_user ?? 'Unassigned';
                    }
                    const viewStatus = document.getElementById('viewStatus');
                    if (viewStatus) {
                        viewStatus.value = lead.status_label ?? lead.status ?? 'N/A';
                    }

                    const viewLeadRemarksCount = document.getElementById('viewLeadRemarksCount');
                    const viewLeadRemarksContainer = document.getElementById('viewLeadRemarks');
                    if (viewLeadRemarksCount) {
                        viewLeadRemarksCount.textContent = data.remarks?.length ?? 0;
                    }
                    if (viewLeadRemarksContainer) {
                        viewLeadRemarksContainer.innerHTML = renderRemarks(data.remarks || []);
                    }

                    // Initialize Feather icons after content is loaded
                    safeFeatherReplace(viewLeadContent);
                    
                    return Promise.resolve(data);
                } catch (error) {
                    console.error(error);
                    showViewLeadError(error.message || 'Unexpected error occurred.');
                    return Promise.reject(error);
                }
            };

            // Store loadLeadDetails on window for access in global event handler
            window.loadLeadDetails = loadLeadDetails;

            // Remark form submission
            const remarkForm = document.getElementById('leadRemarkForm');
            if (remarkForm) {
                remarkForm.addEventListener('submit', async (event) => {
                    event.preventDefault();
                    if (!currentLeadId || !leadsBaseUrl) {
                        return;
                    }

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

                        // Show success message
                        if (viewLeadAlert) {
                            viewLeadAlert.classList.remove('d-none');
                            viewLeadAlert.classList.remove('alert-danger');
                            viewLeadAlert.classList.add('alert-success');
                            viewLeadAlert.textContent = payload?.message || 'Remark added successfully!';
                        }

                        remarkForm.reset();

                        // Reload remarks
                        if (typeof window.loadLeadDetails === 'function') {
                            window.loadLeadDetails(currentLeadId);
                        }
                    } catch (error) {
                        if (viewLeadAlert) {
                            viewLeadAlert.classList.remove('d-none');
                            viewLeadAlert.classList.remove('alert-success');
                            viewLeadAlert.classList.add('alert-danger');
                            viewLeadAlert.textContent = error.message || 'Unable to add remark.';
                        }
                    }
                });
            }

            // Initialize modal instance
            if (viewLeadModalEl && typeof bootstrap !== 'undefined') {
                if (!viewLeadModalInstance) {
                    viewLeadModalInstance = new bootstrap.Modal(viewLeadModalEl, {
                        backdrop: 'static',
                        keyboard: false
                    });
                    window.viewLeadModalInstance = viewLeadModalInstance;
                }
            }

            // View Lead click handler removed - Accounts department only sees Booking File

            if (viewLeadModalEl) {
                viewLeadModalEl.addEventListener('shown.bs.modal', () => {
                    safeFeatherReplace(viewLeadModalEl);
                });

                viewLeadModalEl.addEventListener('hidden.bs.modal', () => {
                    currentLeadId = null;
                    resetViewLeadModal();
                });
            }

            // Initialize feather icons
            if (typeof feather !== 'undefined') {
                feather.replace();
            }

            // Initialize Bootstrap tooltips
            if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
                const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                tooltipTriggerList.map(function (tooltipTriggerEl) {
                    try {
                        return new bootstrap.Tooltip(tooltipTriggerEl);
                    } catch (e) {
                        console.warn('Tooltip initialization failed:', e);
                        return null;
                    }
                });
            }

            // Function to update table row after cost/payment changes
            async function updateTableRow(leadId) {
                try {
                    const response = await fetch(`/leads/${leadId}?modal=1`, {
                        headers: { 'Accept': 'application/json' }
                    });
                    const data = await response.json();
                    const lead = data.lead;
                    
                    if (!lead) return;
                    
                    // Find the table row
                    const row = document.querySelector(`tr[data-lead-id="${leadId}"]`);
                    
                    if (!row) return;
                    
                    // Calculate totals
                    const totalPaid = lead.payments?.filter(p => p.status === 'received')
                        .reduce((sum, p) => sum + parseFloat(p.amount || 0), 0) || 0;
                    const totalCost = lead.cost_components?.reduce((sum, cc) => sum + parseFloat(cc.amount || 0), 0) || 0;
                    const profit = (lead.selling_price || 0) - totalCost;
                    
                    // Update Total Paid cell (4th column, index 3)
                    const paidCell = row.cells[3];
                    if (paidCell) {
                        paidCell.innerHTML = `<span class="fw-semibold text-success">₹${totalPaid.toFixed(2)}</span>`;
                    }
                    
                    // Update Total Cost cell (5th column, index 4)
                    const costCell = row.cells[4];
                    if (costCell) {
                        costCell.innerHTML = `<span class="fw-semibold text-danger">₹${totalCost.toFixed(2)}</span>`;
                    }
                    
                    // Update Profit cell (6th column, index 5)
                    const profitCell = row.cells[5];
                    if (profitCell) {
                        const profitClass = profit >= 0 ? 'text-success' : 'text-danger';
                        profitCell.innerHTML = `<span class="fw-semibold ${profitClass}">₹${profit.toFixed(2)}</span>`;
                    }
                    
                    // Update statistics cards
                    updateStatisticsCards();
                } catch (error) {
                    console.error('Error updating table row:', error);
                }
            }

            // Function to update statistics cards
            async function updateStatisticsCards() {
                try {
                    const response = await fetch('/api/accounts/dashboard', {
                        headers: { 'Accept': 'application/json' }
                    });
                    const data = await response.json();
                    
                    // Update Total Revenue card
                    if (data.total_revenue !== undefined) {
                        const cards = document.querySelectorAll('.card');
                        cards.forEach(card => {
                            const h6 = card.querySelector('h6');
                            if (h6 && h6.textContent.includes('Total Revenue')) {
                                const h4 = card.querySelector('h4');
                                if (h4) h4.textContent = `₹${parseFloat(data.total_revenue).toFixed(2)}`;
                            }
                        });
                    }
                    
                    // Update Total Cost card
                    if (data.total_cost !== undefined) {
                        const cards = document.querySelectorAll('.card');
                        cards.forEach(card => {
                            const h6 = card.querySelector('h6');
                            if (h6 && h6.textContent.includes('Total Cost')) {
                                const h4 = card.querySelector('h4');
                                if (h4) h4.textContent = `₹${parseFloat(data.total_cost).toFixed(2)}`;
                            }
                        });
                    }
                    
                    // Update Net Profit card
                    if (data.net_profit !== undefined) {
                        const cards = document.querySelectorAll('.card');
                        cards.forEach(card => {
                            const h6 = card.querySelector('h6');
                            if (h6 && h6.textContent.includes('Net Profit')) {
                                const h4 = card.querySelector('h4');
                                if (h4) {
                                    const profit = parseFloat(data.net_profit);
                                    h4.textContent = `₹${profit.toFixed(2)}`;
                                    h4.className = `mb-0 fw-bold ${profit >= 0 ? 'text-success' : 'text-danger'}`;
                                    const icon = card.querySelector('i[data-feather="dollar-sign"]');
                                    if (icon) {
                                        icon.className = profit >= 0 ? 'text-success' : 'text-danger';
                                    }
                                }
                            }
                        });
                    }
                } catch (error) {
                    console.error('Error updating statistics:', error);
                }
            }

            // Cost Breakdown Modal
            const costBreakdownModalEl = document.getElementById('costBreakdownModal');
            const costBreakdownModal = costBreakdownModalEl ? new bootstrap.Modal(costBreakdownModalEl) : null;
            let currentCostLeadId = null;
            const addCostForm = document.getElementById('addCostForm');
            const costComponentsBody = document.getElementById('costComponentsBody');
            const totalCostBadge = document.getElementById('totalCostBadge');

            // Open Cost Breakdown Modal
            document.addEventListener('click', function(e) {
                const btn = e.target.closest('.cost-breakdown-btn');
                if (btn) {
                    e.preventDefault();
                    currentCostLeadId = btn.dataset.leadId;
                    const leadInfo = `${btn.dataset.leadTsq} - ${btn.dataset.leadName}`;
                    document.getElementById('costBreakdownLeadInfo').textContent = leadInfo;
                    
                    if (costBreakdownModal) {
                        costBreakdownModal.show();
                        loadCostComponents(currentCostLeadId);
                    }
                }
            });

            // Load Cost Components
            async function loadCostComponents(leadId) {
                try {
                    const response = await fetch(`/leads/${leadId}?modal=1`, {
                        headers: { 'Accept': 'application/json' }
                    });
                    const data = await response.json();
                    const lead = data.lead;
                    
                    if (lead && lead.cost_components) {
                        renderCostComponents(lead.cost_components);
                        const total = lead.cost_components.reduce((sum, cc) => sum + parseFloat(cc.amount || 0), 0);
                        if (totalCostBadge) totalCostBadge.textContent = `₹${total.toFixed(2)}`;
                    } else {
                        if (costComponentsBody) costComponentsBody.innerHTML = '<tr><td colspan="5" class="text-center text-muted py-4">No cost components added yet</td></tr>';
                        if (totalCostBadge) totalCostBadge.textContent = '₹0.00';
                    }
                } catch (error) {
                    console.error('Error loading cost components:', error);
                }
            }

            // Render Cost Components
            function renderCostComponents(components) {
                if (!costComponentsBody) return;
                
                if (!components || components.length === 0) {
                    costComponentsBody.innerHTML = '<tr><td colspan="5" class="text-center text-muted py-4">No cost components added yet</td></tr>';
                    return;
                }

                costComponentsBody.innerHTML = components.map(cc => {
                    let dateStr = 'N/A';
                    if (cc.created_at) {
                        try {
                            const date = new Date(cc.created_at);
                            if (!isNaN(date.getTime())) {
                                dateStr = date.toLocaleDateString('en-GB', { day: '2-digit', month: '2-digit', year: 'numeric' });
                            }
                        } catch (e) {
                            dateStr = cc.created_at;
                        }
                    }
                    return `
                    <tr>
                        <td>${escapeHtml(cc.name || '')}</td>
                        <td class="fw-semibold">₹${parseFloat(cc.amount || 0).toFixed(2)}</td>
                        <td>${escapeHtml(cc.entered_by?.name || 'N/A')}</td>
                        <td>${dateStr}</td>
                        <td>
                            <button class="btn btn-sm btn-outline-danger delete-cost-btn" data-cost-id="${cc.id}" type="button">
                                <i data-feather="trash-2" style="width: 14px; height: 14px;"></i>
                            </button>
                        </td>
                    </tr>
                `;
                }).join('');
                
                safeFeatherReplace(costComponentsBody);
            }

            // Add Cost Component
            if (addCostForm) {
                addCostForm.addEventListener('submit', async (e) => {
                    e.preventDefault();
                    if (!currentCostLeadId) return;

                    const formData = new FormData(addCostForm);
                    const alertEl = document.getElementById('costBreakdownAlert');

                    try {
                        const response = await fetch(`/api/accounts/${currentCostLeadId}/add-cost`, {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || formData.get('_token')
                            },
                            body: formData
                        });

                        const data = await response.json();

                        if (!response.ok) {
                            throw new Error(data.message || 'Failed to add cost component');
                        }

                        if (alertEl) {
                            alertEl.classList.remove('d-none', 'alert-danger');
                            alertEl.classList.add('alert-success');
                            alertEl.textContent = 'Cost component added successfully!';
                            // Auto-hide after 3 seconds
                            setTimeout(() => {
                                alertEl.classList.add('d-none');
                            }, 3000);
                        }

                        addCostForm.reset();
                        loadCostComponents(currentCostLeadId);
                        updateTableRow(currentCostLeadId);
                    } catch (error) {
                        if (alertEl) {
                            alertEl.classList.remove('d-none', 'alert-success');
                            alertEl.classList.add('alert-danger');
                            alertEl.textContent = error.message || 'Failed to add cost component';
                        }
                    }
                });
            }

            // Delete Cost Component
            document.addEventListener('click', async function(e) {
                const btn = e.target.closest('.delete-cost-btn');
                if (btn) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    if (!confirm('Are you sure you want to delete this cost component?')) {
                        return;
                    }
                    
                    const costId = btn.dataset.costId;
                    const alertEl = document.getElementById('costBreakdownAlert');
                    
                    // Disable button during deletion
                    btn.disabled = true;
                    const originalHTML = btn.innerHTML;
                    btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status"></span>';
                    
                    try {
                        const response = await fetch(`/leads/${currentCostLeadId}/cost-components/${costId}`, {
                            method: 'DELETE',
                            headers: {
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
                            }
                        });

                        if (!response.ok) {
                            const errorData = await response.json().catch(() => ({ message: 'Failed to delete cost component' }));
                            throw new Error(errorData.message || 'Failed to delete cost component');
                        }

                        const data = await response.json();

                        // Show success message
                        if (alertEl) {
                            alertEl.classList.remove('d-none', 'alert-danger');
                            alertEl.classList.add('alert-success');
                            alertEl.textContent = data.message || 'Cost component deleted successfully!';
                            setTimeout(() => {
                                alertEl.classList.add('d-none');
                            }, 3000);
                        }
                        
                        // Reload cost components list immediately
                        await loadCostComponents(currentCostLeadId);
                        
                        // Update table row
                        updateTableRow(currentCostLeadId);
                    } catch (error) {
                        console.error('Error deleting cost component:', error);
                        
                        // Re-enable button
                        btn.disabled = false;
                        btn.innerHTML = originalHTML;
                        
                        // Show error message
                        if (alertEl) {
                            alertEl.classList.remove('d-none', 'alert-success');
                            alertEl.classList.add('alert-danger');
                            alertEl.textContent = error.message || 'Failed to delete cost component';
                        }
                    }
                }
            });

            // Add Payment Modal
            const addPaymentModalEl = document.getElementById('addPaymentModal');
            const addPaymentModal = addPaymentModalEl ? new bootstrap.Modal(addPaymentModalEl) : null;
            let currentPaymentLeadId = null;
            const addPaymentForm = document.getElementById('addPaymentForm');
            const paymentsBody = document.getElementById('paymentsBody');
            const totalPaidBadge = document.getElementById('totalPaidBadge');

            // Set default payment date to today
            if (document.getElementById('paymentDate')) {
                document.getElementById('paymentDate').valueAsDate = new Date();
            }

            // Open Add Payment Modal
            document.addEventListener('click', function(e) {
                const btn = e.target.closest('.add-payment-btn');
                if (btn) {
                    e.preventDefault();
                    currentPaymentLeadId = btn.dataset.leadId;
                    const leadInfo = `${btn.dataset.leadTsq} - ${btn.dataset.leadName}`;
                    document.getElementById('addPaymentLeadInfo').textContent = leadInfo;
                    
                    if (addPaymentModal) {
                        addPaymentModal.show();
                        loadPayments(currentPaymentLeadId);
                    }
                }
            });

            // Load Payments
            async function loadPayments(leadId) {
                try {
                    const response = await fetch(`/leads/${leadId}?modal=1`, {
                        headers: { 'Accept': 'application/json' }
                    });
                    const data = await response.json();
                    const lead = data.lead;
                    
                    if (lead && lead.payments) {
                        renderPayments(lead.payments);
                        const total = lead.payments
                            .filter(p => p.status === 'received')
                            .reduce((sum, p) => sum + parseFloat(p.amount || 0), 0);
                        if (totalPaidBadge) totalPaidBadge.textContent = `₹${total.toFixed(2)}`;
                    } else {
                        if (paymentsBody) paymentsBody.innerHTML = '<tr><td colspan="5" class="text-center text-muted py-4">No payments recorded yet</td></tr>';
                        if (totalPaidBadge) totalPaidBadge.textContent = '₹0.00';
                    }
                } catch (error) {
                    console.error('Error loading payments:', error);
                }
            }

            // Render Payments
            function renderPayments(payments) {
                if (!paymentsBody) return;
                
                if (!payments || payments.length === 0) {
                    paymentsBody.innerHTML = '<tr><td colspan="6" class="text-center text-muted py-4">No payments recorded yet</td></tr>';
                    return;
                }

                const statusColors = {
                    'pending': 'warning',
                    'received': 'success',
                    'refunded': 'danger'
                };

                paymentsBody.innerHTML = payments.map(p => {
                    const statusColor = statusColors[p.status] || 'secondary';
                    const paymentDate = p.payment_date ? new Date(p.payment_date).toISOString().split('T')[0] : '';
                    const displayDate = p.payment_date ? new Date(p.payment_date).toLocaleDateString() : 'N/A';
                    return `
                        <tr data-payment-id="${p.id}">
                            <td>${displayDate}</td>
                            <td class="fw-semibold">₹${parseFloat(p.amount || 0).toFixed(2)}</td>
                            <td>${escapeHtml(p.method || '').replace('_', ' ')}</td>
                            <td>${escapeHtml(p.reference || 'N/A')}</td>
                            <td><span class="badge bg-${statusColor}">${escapeHtml(p.status || '')}</span></td>
                            <td>
                                <div class="d-flex gap-1">
                                    <button class="btn btn-sm btn-outline-primary edit-payment-btn" 
                                        data-payment-id="${p.id}"
                                        data-payment-amount="${p.amount}"
                                        data-payment-date="${paymentDate}"
                                        data-payment-method="${p.method}"
                                        data-payment-reference="${escapeHtml(p.reference || '')}"
                                        data-payment-status="${p.status}"
                                        data-bs-toggle="tooltip" 
                                        title="Edit Payment">
                                        <i data-feather="edit" style="width: 14px; height: 14px;"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger delete-payment-btn" 
                                        data-payment-id="${p.id}"
                                        data-bs-toggle="tooltip" 
                                        title="Delete Payment">
                                        <i data-feather="trash-2" style="width: 14px; height: 14px;"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    `;
                }).join('');
                
                safeFeatherReplace(paymentsBody);
                
                // Initialize tooltips for new buttons
                if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
                    const tooltipTriggerList = [].slice.call(paymentsBody.querySelectorAll('[data-bs-toggle="tooltip"]'));
                    tooltipTriggerList.map(function (tooltipTriggerEl) {
                        try {
                            return new bootstrap.Tooltip(tooltipTriggerEl);
                        } catch (e) {
                            return null;
                        }
                    });
                }
            }


            // Edit Payment Handler
            let currentEditPaymentId = null;
            document.addEventListener('click', async function(e) {
                const btn = e.target.closest('.edit-payment-btn');
                if (btn) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    const paymentId = btn.dataset.paymentId;
                    currentEditPaymentId = paymentId;
                    
                    // Populate form with payment data
                    document.getElementById('paymentAmount').value = btn.dataset.paymentAmount || '';
                    document.getElementById('paymentDate').value = btn.dataset.paymentDate || '';
                    document.getElementById('paymentMethod').value = btn.dataset.paymentMethod || '';
                    document.getElementById('paymentStatus').value = btn.dataset.paymentStatus || '';
                    document.getElementById('paymentReference').value = btn.dataset.paymentReference || '';
                    
                    // Change form mode to "edit"
                    const submitBtn = addPaymentForm.querySelector('button[type="submit"]');
                    if (submitBtn) {
                        submitBtn.innerHTML = '<i data-feather="save" class="me-1" style="width: 16px; height: 16px;"></i> Update Payment';
                        submitBtn.dataset.mode = 'edit';
                    }
                    addPaymentForm.dataset.paymentId = paymentId;
                    document.getElementById('addPaymentModalLabel').innerHTML = '<i data-feather="edit" class="me-2" style="width: 20px; height: 20px;"></i> Edit Payment - <span id="addPaymentLeadInfo"></span>';
                    
                    // Show modal
                    if (addPaymentModal) {
                        addPaymentModal.show();
                    }
                    
                    safeFeatherReplace(addPaymentModalEl);
                }
            });

            // Update form submission to handle both add and edit
            if (addPaymentForm) {
                const originalHandler = addPaymentForm.onsubmit;
                addPaymentForm.addEventListener('submit', async (e) => {
                    e.preventDefault();
                    if (!currentPaymentLeadId) return;

                    const formData = new FormData(addPaymentForm);
                    const alertEl = document.getElementById('addPaymentAlert');
                    const submitBtn = addPaymentForm.querySelector('button[type="submit"]');
                    const isEditMode = submitBtn?.dataset.mode === 'edit' || addPaymentForm.dataset.paymentId;

                    try {
                        let url = `/api/accounts/${currentPaymentLeadId}/add-payment`;
                        let method = 'POST';
                        
                        if (isEditMode && currentEditPaymentId) {
                            // Update existing payment
                            url = `/leads/${currentPaymentLeadId}/payments/${currentEditPaymentId}`;
                            method = 'PUT';
                            formData.append('_method', 'PUT');
                        }

                        const response = await fetch(url, {
                            method: method === 'PUT' ? 'POST' : method,
                            headers: {
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || formData.get('_token')
                            },
                            body: formData
                        });

                        const data = await response.json();

                        if (!response.ok) {
                            throw new Error(data.message || (isEditMode ? 'Failed to update payment' : 'Failed to add payment'));
                        }

                        if (alertEl) {
                            alertEl.classList.remove('d-none', 'alert-danger');
                            alertEl.classList.add('alert-success');
                            alertEl.textContent = data.message || (isEditMode ? 'Payment updated successfully!' : 'Payment added successfully!');
                            setTimeout(() => {
                                alertEl.classList.add('d-none');
                            }, 3000);
                        }

                        addPaymentForm.reset();
                        document.getElementById('paymentDate').valueAsDate = new Date();
                        
                        // Reset form mode to "add"
                        if (submitBtn) {
                            submitBtn.innerHTML = '<i data-feather="save" class="me-1" style="width: 16px; height: 16px;"></i> Add Payment';
                            submitBtn.dataset.mode = 'add';
                        }
                        addPaymentForm.dataset.paymentId = '';
                        currentEditPaymentId = null;
                        document.getElementById('addPaymentModalLabel').innerHTML = '<i data-feather="credit-card" class="me-2" style="width: 20px; height: 20px;"></i> Add Payment - <span id="addPaymentLeadInfo"></span>';
                        
                        loadPayments(currentPaymentLeadId);
                        updateTableRow(currentPaymentLeadId);
                    } catch (error) {
                        if (alertEl) {
                            alertEl.classList.remove('d-none', 'alert-success');
                            alertEl.classList.add('alert-danger');
                            alertEl.textContent = error.message || (isEditMode ? 'Failed to update payment' : 'Failed to add payment');
                        }
                    }
                });
            }

            // Delete Payment Handler
            document.addEventListener('click', async function(e) {
                const btn = e.target.closest('.delete-payment-btn');
                if (btn) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    if (!confirm('Are you sure you want to delete this payment? This action cannot be undone.')) {
                        return;
                    }
                    
                    const paymentId = btn.dataset.paymentId;
                    const alertEl = document.getElementById('addPaymentAlert');
                    
                    // Disable button during deletion
                    btn.disabled = true;
                    const originalHTML = btn.innerHTML;
                    btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status"></span>';
                    
                    try {
                        const response = await fetch(`/leads/${currentPaymentLeadId}/payments/${paymentId}`, {
                            method: 'DELETE',
                            headers: {
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
                            }
                        });

                        if (!response.ok) {
                            const errorData = await response.json().catch(() => ({ message: 'Failed to delete payment' }));
                            throw new Error(errorData.message || 'Failed to delete payment');
                        }

                        const data = await response.json();

                        // Show success message
                        if (alertEl) {
                            alertEl.classList.remove('d-none', 'alert-danger');
                            alertEl.classList.add('alert-success');
                            alertEl.textContent = data.message || 'Payment deleted successfully!';
                            setTimeout(() => {
                                alertEl.classList.add('d-none');
                            }, 3000);
                        }
                        
                        // Reload payments list immediately
                        await loadPayments(currentPaymentLeadId);
                        
                        // Update table row
                        updateTableRow(currentPaymentLeadId);
                    } catch (error) {
                        console.error('Error deleting payment:', error);
                        
                        // Re-enable button
                        btn.disabled = false;
                        btn.innerHTML = originalHTML;
                        
                        // Show error message
                        if (alertEl) {
                            alertEl.classList.remove('d-none', 'alert-success');
                            alertEl.classList.add('alert-danger');
                            alertEl.textContent = error.message || 'Failed to delete payment';
                        }
                    }
                }
            });

            // Initialize modals when shown
            if (costBreakdownModalEl) {
                costBreakdownModalEl.addEventListener('shown.bs.modal', () => {
                    safeFeatherReplace(costBreakdownModalEl);
                });
            }

            if (addPaymentModalEl) {
                addPaymentModalEl.addEventListener('shown.bs.modal', () => {
                    safeFeatherReplace(addPaymentModalEl);
                });
            }
        });
    </script>
    @endpush
@endsection

