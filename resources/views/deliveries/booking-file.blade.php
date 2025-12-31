@extends('layouts.app')
@section('title', 'Delivery Booking File | Travel Shravel')
@section('content')
    <div class="hk-pg-wrapper pb-0">
        <div class="hk-pg-body py-0">
            <div class="contactapp-wrap">
                <div class="contactapp-content">
                    <div class="contactapp-detail-wrap">
                        <header class="contact-header">
                            <div class="w-100 align-items-center justify-content-between d-flex contactapp-title link-dark">
                                <div>
                                    <h1>Booking File - {{ $lead->tsq }}</h1>
                                    <small class="text-muted">{{ $lead->customer_name }}</small>
                                </div>
                                <div>
                                    <a href="{{ $backUrl ?? route('deliveries.index') }}" class="btn btn-secondary btn-sm">
                                        <i data-feather="arrow-left" style="width: 14px; height: 14px;"></i>
                                        Back to Deliveries
                                    </a>
                                </div>
                            </div>
                        </header>

                        <div class="contact-body">
                            <div data-simplebar class="nicescroll-bar">
                                @if (session('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @endif

                                @if ($errors->any())
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <strong>There were some problems with your submission:</strong>
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @endif

                                <!-- Customer Details Section -->
                                <div class="mb-4 border rounded-3 p-3">
                                    <h6 class="text-uppercase text-muted small fw-semibold mb-3">
                                        <i data-feather="user" class="me-1" style="width: 14px; height: 14px;"></i>
                                        Customer Details
                                    </h6>
                                    <div class="row g-3">
                                        <div class="col-md-3">
                                            <label class="form-label">Ref No.</label>
                                            <input type="text" value="{{ $lead->tsq }}"
                                                class="form-control form-control-sm" readonly disabled
                                                style="background-color: #f8f9fa; cursor: not-allowed;">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Customer Name</label>
                                            <input type="text" value="{{ $lead->customer_name }}"
                                                class="form-control form-control-sm" readonly disabled
                                                style="background-color: #f8f9fa; cursor: not-allowed;">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Travel Date</label>
                                            <input type="text"
                                                value="{{ $lead->travel_date ? $lead->travel_date->format('d M, Y') : 'N/A' }}"
                                                class="form-control form-control-sm" readonly disabled
                                                style="background-color: #f8f9fa; cursor: not-allowed;">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Return Date</label>
                                            <input type="text"
                                                value="{{ $lead->return_date ? $lead->return_date->format('d M, Y') : 'N/A' }}"
                                                class="form-control form-control-sm" readonly disabled
                                                style="background-color: #f8f9fa; cursor: not-allowed;">
                                        </div>
                                    </div>
                                </div>

                                <!-- Remarks Section (Own Remarks Only) -->
                                <div class="mb-4 border rounded-3 p-3">
                                    <h6 class="text-uppercase text-muted small fw-semibold mb-3">
                                        <i data-feather="message-circle" class="me-1" style="width: 14px; height: 14px;"></i>
                                        My Remarks
                                    </h6>
                                    
                                    <!-- Add Remark Form -->
                                    <form id="addRemarkForm" method="POST" action="{{ route('leads.booking-file-remarks.store', $lead) }}">
                                        <input type="hidden" name="department" value="Delivery">
                                        @csrf
                                        <div class="row g-3 align-items-end">
                                            <div class="col-md-5">
                                                <label class="form-label">Remark <span class="text-danger">*</span></label>
                                                <textarea name="remark" class="form-control form-control-sm" rows="2" required placeholder="Enter your remark..."></textarea>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Follow-up Date & Time</label>
                                                <input type="datetime-local" name="follow_up_at" class="form-control form-control-sm">
                                            </div>
                                            <div class="col-md-3">
                                                <button type="submit" class="btn btn-sm btn-primary w-100">
                                                    <i data-feather="save" style="width: 14px; height: 14px;"></i>
                                                    Add Remark
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <!-- Delivery Details Section -->
                                @if($lead->delivery)
                                <div class="mb-4 border rounded-3 p-3">
                                    <h6 class="text-uppercase text-muted small fw-semibold mb-3">
                                        <i data-feather="package" class="me-1" style="width: 14px; height: 14px;"></i>
                                        Delivery Details
                                    </h6>
                                    <div class="row g-3">
                                        <div class="col-md-3">
                                            <label class="form-label">Assigned To</label>
                                            <input type="text" value="{{ $lead->delivery->assignedTo->name ?? 'Unassigned' }}"
                                                class="form-control form-control-sm" readonly disabled
                                                style="background-color: #f8f9fa; cursor: not-allowed;">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Delivery Method</label>
                                            <input type="text" value="{{ ucfirst(str_replace('_', ' ', $lead->delivery->delivery_method ?? 'N/A')) }}"
                                                class="form-control form-control-sm" readonly disabled
                                                style="background-color: #f8f9fa; cursor: not-allowed;">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Courier ID</label>
                                            <input type="text" value="{{ $lead->delivery->courier_id ?? 'N/A' }}"
                                                class="form-control form-control-sm" readonly disabled
                                                style="background-color: #f8f9fa; cursor: not-allowed;">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Delivered At</label>
                                            <input type="text"
                                                value="{{ $lead->delivery->delivered_at ? $lead->delivery->delivered_at->format('d M, Y h:i A') : 'N/A' }}"
                                                class="form-control form-control-sm" readonly disabled
                                                style="background-color: #f8f9fa; cursor: not-allowed;">
                                        </div>
                                    </div>
                                </div>
                                @endif

                                <!-- Status Update Section -->
                                <div class="mb-4 border rounded-3 p-3">
                                    <h6 class="text-uppercase text-muted small fw-semibold mb-3">
                                        <i data-feather="edit-3" class="me-1" style="width: 14px; height: 14px;"></i>
                                        Status Update
                                    </h6>
                                    @if($lead->delivery)
                                    <form method="POST" action="{{ route('leads.deliveries.update', [$lead, $lead->delivery]) }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Delivery Status</label>
                                                <select name="delivery_status" class="form-select form-select-sm" required>
                                                    <option value="Pending" {{ ($lead->delivery->delivery_status ?? 'Pending') == 'Pending' ? 'selected' : '' }}>Pending</option>
                                                    <option value="In_Process" {{ ($lead->delivery->delivery_status ?? '') == 'In_Process' ? 'selected' : '' }}>In Process</option>
                                                    <option value="Delivered" {{ ($lead->delivery->delivery_status ?? '') == 'Delivered' ? 'selected' : '' }}>Delivered</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Courier ID</label>
                                                <input type="text" name="courier_id" class="form-control form-control-sm" value="{{ $lead->delivery->courier_id ?? '' }}" placeholder="Enter courier ID">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Delivery Method</label>
                                                <select name="delivery_method" class="form-select form-select-sm">
                                                    <option value="">-- Select --</option>
                                                    <option value="soft_copy" {{ ($lead->delivery->delivery_method ?? '') == 'soft_copy' ? 'selected' : '' }}>Soft Copy</option>
                                                    <option value="courier" {{ ($lead->delivery->delivery_method ?? '') == 'courier' ? 'selected' : '' }}>Courier</option>
                                                    <option value="hand_delivery" {{ ($lead->delivery->delivery_method ?? '') == 'hand_delivery' ? 'selected' : '' }}>Hand Delivery</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 d-flex align-items-end">
                                                <button type="submit" class="btn btn-sm btn-primary">
                                                    <i data-feather="save" style="width: 14px; height: 14px;"></i>
                                                    Update Status
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                    @else
                                    <p class="text-muted mb-0">No delivery record found. Delivery must be created by Operations first.</p>
                                    @endif
                                </div>

                                <!-- History Section -->
                                <div class="mb-4 border rounded-3 p-3">
                                    <h6 class="text-uppercase text-muted small fw-semibold mb-3">
                                        <i data-feather="clock" class="me-1" style="width: 14px; height: 14px;"></i>
                                        History
                                    </h6>
                                    <div style="max-height: 400px; overflow-y: auto;">
                                        @php
                                            $lead->load('bookingFileRemarks.user');
                                            $currentDepartment = 'Delivery';
                                            // Check if user is admin
                                            $isAdmin = Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Developer');
                                            // If admin, show all remarks; otherwise, show only own remarks
                                            $remarksQuery = $lead->bookingFileRemarks()->where('department', $currentDepartment);
                                            if (!$isAdmin) {
                                                $remarksQuery->where('user_id', Auth::id());
                                            }
                                            $allRemarks = $remarksQuery->orderBy('created_at', 'desc')->get();
                                        @endphp
                                        @if($allRemarks->count() > 0)
                                            <div class="timeline">
                                                @foreach($allRemarks as $remark)
                                                    <div class="border rounded-3 p-3 mb-3 bg-white">
                                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                                            <div class="d-flex align-items-start flex-grow-1">
                                                                <div class="avatar avatar-rounded rounded-circle me-3 flex-shrink-0" style="background-color: #007d88; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                                                    <span class="text-white fw-bold" style="font-size: 0.875rem;">
                                                                        {{ strtoupper(substr($remark->user->name ?? 'U', 0, 1)) }}
                                                                    </span>
                                                                </div>
                                                                <div class="flex-grow-1">
                                                                    <div class="d-flex align-items-center gap-2 mb-1">
                                                                        <strong class="text-dark">{{ $remark->user->name ?? 'Unknown' }}</strong>
                                                                        <small class="text-muted">{{ $remark->created_at->format('d M, Y h:i A') }}</small>
                                                                        @if($remark->follow_up_at)
                                                                            <span class="badge bg-danger">Follow-up: {{ $remark->follow_up_at->format('d M, Y h:i A') }}</span>
                                                                        @endif
                                                                    </div>
                                                                    <p class="mb-0 text-dark" style="line-height: 1.6;">{{ $remark->remark }}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <p class="text-muted text-center mb-0 py-4">
                                                <i data-feather="message-circle" class="me-2" style="width: 16px; height: 16px;"></i>
                                                No remarks available.
                                            </p>
                                        @endif
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


    @push('scripts')
    <script>
        $(document).ready(function() {
            // Initialize feather icons
            if (typeof feather !== 'undefined') {
                feather.replace();
            }

        });
    </script>
    @endpush
@endsection
