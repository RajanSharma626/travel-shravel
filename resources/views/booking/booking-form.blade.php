@extends('layouts.app')
@section('title', 'Booking File | Travel Shravel')
@section('content')
    <div class="hk-pg-wrapper pb-0">
        <div class="hk-pg-body py-0">
            <div class="contactapp-wrap">
                <div class="contactapp-content">
                    <div class="contactapp-detail-wrap">
                        <header class="contact-header">
                            <div class="w-100 align-items-center justify-content-between d-flex contactapp-title link-dark">
                                <div class="d-flex align-items-center gap-3 flex-grow-1">
                                    <a href="{{ $backUrl ?? route('bookings.index') }}"
                                        class="btn btn-icon btn-flush-dark btn-rounded flush-soft-hover">
                                        <span class="icon">
                                            <span class="feather-icon">
                                                <i data-feather="arrow-left"></i>
                                            </span>
                                        </span>
                                    </a>
                                    <div>
                                        <h1 class="mb-0">Booking File</h1>
                                        <p class="text-muted mb-0 small">TSQ: {{ $lead->tsq }}</p>
                                    </div>
                                </div>
                                @can('edit leads')
                                    <button type="button" class="btn btn-sm btn-outline-primary ms-2" data-bs-toggle="modal"
                                        data-bs-target="#reassignLeadModal">
                                        <i data-feather="user-check" class="me-1" style="width: 14px; height: 14px;"></i>
                                        Re-assign
                                    </button>
                                @endcan
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

                                @php
                                    $isViewOnly = $isViewOnly ?? false;
                                    $disabledAttr = $isViewOnly ? 'readonly disabled' : '';
                                    $disabledStyle = $isViewOnly
                                        ? 'style="background-color: #f8f9fa; cursor: not-allowed;"'
                                        : '';
                                @endphp

                                <form id="bookingFileForm" method="POST" action="{{ route('leads.update', $lead) }}"
                                    @if ($isViewOnly) onsubmit="return false;" @endif>
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="lead_id" value="{{ $lead->id }}">

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
                                                <label class="form-label">Salutation</label>
                                                <input type="text" value="{{ $lead->salutation ?? '' }}"
                                                    class="form-control form-control-sm" readonly disabled
                                                    style="background-color: #f8f9fa; cursor: not-allowed;">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">First Name</label>
                                                <input type="text" value="{{ $lead->first_name }}"
                                                    class="form-control form-control-sm" readonly disabled
                                                    style="background-color: #f8f9fa; cursor: not-allowed;">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Last Name</label>
                                                <input type="text" value="{{ $lead->last_name ?? '' }}"
                                                    class="form-control form-control-sm" readonly disabled
                                                    style="background-color: #f8f9fa; cursor: not-allowed;">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Primary No.</label>
                                                <input type="text" value="{{ $lead->primary_phone ?? $lead->phone }}"
                                                    class="form-control form-control-sm" readonly disabled
                                                    style="background-color: #f8f9fa; cursor: not-allowed;">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Secondary No.</label>
                                                <input type="text" value="{{ $lead->secondary_phone ?? '' }}"
                                                    class="form-control form-control-sm" readonly disabled
                                                    style="background-color: #f8f9fa; cursor: not-allowed;">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Emergency No.</label>
                                                <input type="text" value="{{ $lead->other_phone ?? '' }}"
                                                    class="form-control form-control-sm" readonly disabled
                                                    style="background-color: #f8f9fa; cursor: not-allowed;">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Email ID</label>
                                                <input type="email" value="{{ $lead->email }}"
                                                    class="form-control form-control-sm" readonly disabled
                                                    style="background-color: #f8f9fa; cursor: not-allowed;">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">No. of Adult(s)</label>
                                                <input type="number" value="{{ $lead->adults }}"
                                                    class="form-control form-control-sm" readonly disabled
                                                    style="background-color: #f8f9fa; cursor: not-allowed;">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Child (2-5 years)</label>
                                                <input type="number" value="{{ $lead->children_2_5 ?? 0 }}"
                                                    class="form-control form-control-sm" readonly disabled
                                                    style="background-color: #f8f9fa; cursor: not-allowed;">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Child (6-11 years)</label>
                                                <input type="number" value="{{ $lead->children_6_11 ?? 0 }}"
                                                    class="form-control form-control-sm" readonly disabled
                                                    style="background-color: #f8f9fa; cursor: not-allowed;">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Infant (>2 years)</label>
                                                <input type="number" value="{{ $lead->infants ?? 0 }}"
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
                                            <div class="col-md-3">
                                                <label class="form-label">Booked On</label>
                                                <input type="text"
                                                    value="{{ $lead->booked_on ? $lead->booked_on->format('d M, Y h:i A') : 'N/A' }}"
                                                    class="form-control form-control-sm" readonly disabled
                                                    style="background-color: #f8f9fa; cursor: not-allowed;">
                                            </div>
                                            @php
                                                $paymentState = $customerPaymentState ?? 'none';
                                                $salesBgColor = '#f8f9fa';
                                                $salesBorderColor = '#ced4da';
                                                $paymentIcon = null;
                                                $paymentIconColor = '#6c757d';

                                                if ($isViewOnly) {
                                                    if ($paymentState === 'full') {
                                                        $salesBgColor = '#d4edda'; // green
                                                        $salesBorderColor = '#28a745';
                                                        $paymentIcon = 'check-circle';
                                                        $paymentIconColor = '#28a745';
                                                    } elseif ($paymentState === 'partial') {
                                                        $salesBgColor = '#fff3cd'; // yellow
                                                        $salesBorderColor = '#ffc107';
                                                        $paymentIcon = 'clock';
                                                        $paymentIconColor = '#ffc107';
                                                    } else {
                                                        $salesBgColor = '#f8d7da'; // red
                                                        $salesBorderColor = '#dc3545';
                                                        $paymentIcon = 'alert-circle';
                                                        $paymentIconColor = '#dc3545';
                                                    }
                                                }
                                            @endphp
                                            <div class="col-md-3">
                                                <label class="form-label">Sales Cost</label>
                                                @if ($isViewOnly || ($isOpsDept ?? false))
                                                    <div class="input-group input-group-sm">
                                                        <input type="text"
                                                            value="{{ $lead->selling_price ? number_format($lead->selling_price, 2) : '0.00' }}"
                                                            class="form-control form-control-sm" readonly disabled
                                                            style="background-color: {{ $salesBgColor }}; cursor: not-allowed; border-color: {{ $salesBorderColor }};">
                                                        @if ($paymentIcon)
                                                            <span class="input-group-text"
                                                                style="background-color: {{ $salesBgColor }}; border-color: {{ $salesBorderColor }};">
                                                                <i data-feather="{{ $paymentIcon }}"
                                                                    style="width: 14px; height: 14px; color: {{ $paymentIconColor }};"></i>
                                                            </span>
                                                        @endif
                                                    </div>
                                                @else
                                                    <div class="input-group input-group-sm">
                                                        <input type="number" id="salesCostInput" name="selling_price"
                                                            value="{{ old('selling_price', $lead->selling_price ?? 0) }}"
                                                            class="form-control form-control-sm" step="0.01"
                                                            min="0" placeholder="0.00">
                                                        <button type="button" class="btn btn-primary btn-sm"
                                                            id="updateSalesCostBtn">
                                                            Update
                                                        </button>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Destination Section -->
                                    @if (!($isPostSales ?? false))
                                        <div class="mb-4 border rounded-3 p-3 bg-light">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h6 class="text-uppercase text-muted small fw-semibold mb-0">
                                                    <i data-feather="map-pin" class="me-1"
                                                        style="width: 14px; height: 14px;"></i>
                                                    Destination
                                                </h6>
                                                @if (!$isViewOnly)
                                                    <button type="button" class="btn btn-sm btn-primary"
                                                        data-bs-toggle="modal" data-bs-target="#addDestinationModal">
                                                        <i data-feather="plus" style="width: 14px; height: 14px;"></i>
                                                        Add
                                                    </button>
                                                @endif
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-sm mb-0" id="destinationTable">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th style="width: 15%;">Destination</th>
                                                            <th style="width: 15%;">Location</th>
                                                            <th style="width: 12%;" class="text-center">Only Hotel</th>
                                                            <th style="width: 12%;" class="text-center">Only TT</th>
                                                            <th style="width: 12%;" class="text-center">Hotel + TT</th>
                                                            <th style="width: 10%;">From Date</th>
                                                            <th style="width: 10%;">To Date</th>
                                                            @if (!($isViewOnly && ($isOpsDept || ($isPostSales ?? false))))
                                                                <th style="width: 10%;" class="text-center">Action</th>
                                                            @endif
                                                        </tr>
                                                    </thead>
                                                    <tbody id="destinationTableBody">
                                                        @if ($lead->bookingDestinations && $lead->bookingDestinations->count() > 0)
                                                            @foreach ($lead->bookingDestinations as $index => $bd)
                                                                <tr class="destination-data-row"
                                                                    data-destination-id="{{ $bd->id }}"
                                                                    data-row-index="{{ $index }}">
                                                                    <td>{{ $bd->destination }}</td>
                                                                    <td>{{ $bd->location }}</td>
                                                                    <td class="text-center">
                                                                        @if ($bd->only_hotel)
                                                                            <i data-feather="check"
                                                                                style="width: 16px; height: 16px; color: #28a745;"></i>
                                                                        @endif
                                                                    </td>
                                                                    <td class="text-center">
                                                                        @if ($bd->only_tt)
                                                                            <i data-feather="check"
                                                                                style="width: 16px; height: 16px; color: #28a745;"></i>
                                                                        @endif
                                                                    </td>
                                                                    <td class="text-center">
                                                                        @if ($bd->hotel_tt)
                                                                            <i data-feather="check"
                                                                                style="width: 16px; height: 16px; color: #28a745;"></i>
                                                                        @endif
                                                                    </td>
                                                                    <td>{{ $bd->from_date ? $bd->from_date->format('d/m/Y') : '' }}
                                                                    </td>
                                                                    <td>{{ $bd->to_date ? $bd->to_date->format('d/m/Y') : '' }}
                                                                    </td>
                                                                    @if (!($isViewOnly && ($isOpsDept || ($isPostSales ?? false))))
                                                                        <td class="text-center">
                                                                            @if (!$isViewOnly)
                                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                                    width="16" height="16"
                                                                                    viewBox="0 0 24 24" fill="none"
                                                                                    stroke="currentColor" stroke-width="2"
                                                                                    stroke-linecap="round"
                                                                                    stroke-linejoin="round"
                                                                                    class="editDestinationRow"
                                                                                    data-id="{{ $bd->id }}"
                                                                                    data-destination="{{ $bd->destination }}"
                                                                                    data-location="{{ $bd->location }}"
                                                                                    data-only-hotel="{{ $bd->only_hotel ? 1 : 0 }}"
                                                                                    data-only-tt="{{ $bd->only_tt ? 1 : 0 }}"
                                                                                    data-hotel-tt="{{ $bd->hotel_tt ? 1 : 0 }}"
                                                                                    data-from-date="{{ $bd->from_date ? $bd->from_date->format('Y-m-d') : '' }}"
                                                                                    data-to-date="{{ $bd->to_date ? $bd->to_date->format('Y-m-d') : '' }}"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#addDestinationModal"
                                                                                    style="width: 16px; height: 16px; color: #0d6efd; cursor: pointer; margin-right: 8px;">
                                                                                    <path
                                                                                        d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7">
                                                                                    </path>
                                                                                    <path
                                                                                        d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z">
                                                                                    </path>
                                                                                </svg>
                                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                                    width="16" height="16"
                                                                                    viewBox="0 0 24 24" fill="none"
                                                                                    stroke="currentColor" stroke-width="2"
                                                                                    stroke-linecap="round"
                                                                                    stroke-linejoin="round"
                                                                                    class="removeDestinationRow"
                                                                                    data-id="{{ $bd->id }}"
                                                                                    style="width: 16px; height: 16px; color: #dc3545; cursor: pointer;">
                                                                                    <polyline points="3 6 5 6 21 6">
                                                                                    </polyline>
                                                                                    <path
                                                                                        d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                                                    </path>
                                                                                </svg>
                                                                            @endif
                                                                        </td>
                                                                    @endif
                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            <tr>
                                                                <td colspan="{{ !($isViewOnly && ($isOpsDept || ($isPostSales ?? false))) ? '8' : '7' }}"
                                                                    class="text-center text-muted py-4">
                                                                    <i data-feather="inbox"
                                                                        style="width: 24px; height: 24px; opacity: 0.5;"
                                                                        class="mb-2"></i>
                                                                    <div>No destination data available</div>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    @endif

                                    {{-- Customer Payments (Post Sales editable, others view-only via accounts booking file) --}}
                                    @if ($isPostSales ?? false)
                                        <div class="mb-4 border rounded-3 p-3">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h6 class="text-uppercase text-muted small fw-semibold mb-0">
                                                    <i data-feather="credit-card" class="me-1"
                                                        style="width: 14px; height: 14px;"></i>
                                                    Customer Payments (Post Sales → Accounts)
                                                </h6>
                                                <button type="button" class="btn btn-sm btn-primary"
                                                    data-bs-toggle="modal" data-bs-target="#postSalesAddPaymentModal">
                                                    <i data-feather="plus" style="width: 14px; height: 14px;"></i>
                                                    Add Payment
                                                </button>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-sm mb-0"
                                                    id="customerPaymentsTable">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>Amount</th>
                                                            <th>Method</th>
                                                            <th>Paid On</th>
                                                            <th>Due Date</th>
                                                            <th>Transaction ID</th>
                                                            <th>Status</th>
                                                            <th class="text-center">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            $payments = $lead->payments ?? collect();
                                                        @endphp
                                                        @if ($payments->count() > 0)
                                                            @foreach ($payments as $payment)
                                                                <tr>
                                                                    <td>₹{{ number_format($payment->amount, 2) }}</td>
                                                                    <td>{{ ucfirst(str_replace('_', ' ', $payment->method)) }}
                                                                    </td>
                                                                    <td>{{ $payment->payment_date ? $payment->payment_date->format('d/m/Y') : '-' }}
                                                                    </td>
                                                                    <td>{{ $payment->due_date ? $payment->due_date->format('d/m/Y') : '-' }}
                                                                    </td>
                                                                    <td>{{ $payment->reference ?? '-' }}</td>
                                                                    <td>
                                                                        @php
                                                                            $statusColor =
                                                                                $payment->status === 'received'
                                                                                    ? 'success'
                                                                                    : ($payment->status === 'refunded'
                                                                                        ? 'secondary'
                                                                                        : 'warning');
                                                                        @endphp
                                                                        <span class="badge bg-{{ $statusColor }}">
                                                                            {{ ucfirst($payment->status) }}
                                                                        </span>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <i data-feather="edit"
                                                                            class="post-sales-edit-payment-btn"
                                                                            data-payment-id="{{ $payment->id }}"
                                                                            data-amount="{{ $payment->amount }}"
                                                                            data-method="{{ $payment->method }}"
                                                                            data-payment-date="{{ $payment->payment_date ? $payment->payment_date->format('Y-m-d') : '' }}"
                                                                            data-due-date="{{ $payment->due_date ? $payment->due_date->format('Y-m-d') : '' }}"
                                                                            data-reference="{{ $payment->reference }}"
                                                                            data-status="{{ $payment->status }}"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#postSalesAddPaymentModal"
                                                                            style="width: 16px; height: 16px; color: #0d6efd; cursor: pointer; margin-right: 8px;"></i>
                                                                        <button type="button"
                                                                            class="border-0 bg-transparent p-0 m-0 delete-customer-payment-btn"
                                                                            data-payment-id="{{ $payment->id }}"
                                                                            title="Delete Payment">
                                                                            <i data-feather="trash-2"
                                                                                style="width: 16px; height: 16px; color: #dc3545; cursor: pointer; pointer-events: none;"></i>
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            <tr>
                                                                <td colspan="7" class="text-center text-muted py-3">No
                                                                    customer payments recorded</td>
                                                            </tr>
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    @endif
                                    <!-- Arrival/Departure Details Section -->
                                    @if (!($isPostSales ?? false))
                                        <div class="mb-4 border rounded-3 p-3">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h6 class="text-uppercase text-muted small fw-semibold mb-0">
                                                    <i data-feather="navigation" class="me-1"
                                                        style="width: 14px; height: 14px;"></i>
                                                    Arrival/Departure Details
                                                </h6>
                                                @if (!$isViewOnly)
                                                    <button type="button" class="btn btn-sm btn-primary"
                                                        data-bs-toggle="modal" data-bs-target="#addArrivalDepartureModal">
                                                        <i data-feather="plus" style="width: 14px; height: 14px;"></i>
                                                        Add
                                                    </button>
                                                @endif
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-sm mb-0"
                                                    id="arrivalDepartureTable">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th style="width: 12%;" rowspan="2">Mode</th>
                                                            <th style="width: 15%;" rowspan="2">Info</th>
                                                            <th style="width: 12%;" rowspan="2">From City</th>
                                                            <th style="width: 12%;" rowspan="2">To City</th>
                                                            <th colspan="2" style="width: 18%;">Dep Date & Time</th>
                                                            <th colspan="2" style="width: 18%;">Arrival Date & Time
                                                            </th>
                                                            @if (!($isViewOnly && ($isOpsDept || ($isPostSales ?? false))))
                                                                <th style="width: 13%;" rowspan="2"
                                                                    class="text-center">Action</th>
                                                            @endif
                                                        </tr>

                                                    </thead>
                                                    <tbody id="arrivalDepartureTableBody">
                                                        @php
                                                            $allTransports =
                                                                $lead->bookingArrivalDepartures ?? collect();
                                                        @endphp
                                                        @if ($allTransports && $allTransports->count() > 0)
                                                            @foreach ($allTransports as $index => $transport)
                                                                <tr class="arrival-departure-data-row"
                                                                    data-transport-id="{{ $transport->id }}"
                                                                    data-row-index="{{ $index }}">
                                                                    <td>{{ $transport->mode }}</td>
                                                                    <td>{{ $transport->info }}</td>
                                                                    <td>{{ $transport->from_city }}</td>
                                                                    <td>{{ $transport->to_city ?? '' }}</td>
                                                                    <td>
                                                                        {{ $transport->departure_date ? ($transport->departure_date instanceof \DateTime ? $transport->departure_date->format('d/m/Y') : date('d/m/Y', strtotime($transport->departure_date))) : '' }}
                                                                    </td>
                                                                    <td>
                                                                        {{ $transport->departure_time ? substr($transport->departure_time, 0, 5) : '' }}
                                                                    </td>
                                                                    <td>
                                                                        {{ $transport->arrival_date ? ($transport->arrival_date instanceof \DateTime ? $transport->arrival_date->format('d/m/Y') : date('d/m/Y', strtotime($transport->arrival_date))) : '' }}
                                                                    </td>
                                                                    <td>
                                                                        {{ $transport->arrival_time ? substr($transport->arrival_time, 0, 5) : '' }}
                                                                    </td>
                                                                    @if (!($isViewOnly && ($isOpsDept || ($isPostSales ?? false))))
                                                                        <td class="text-center">
                                                                            @if (!$isViewOnly)
                                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                                    width="16" height="16"
                                                                                    viewBox="0 0 24 24" fill="none"
                                                                                    stroke="currentColor" stroke-width="2"
                                                                                    stroke-linecap="round"
                                                                                    stroke-linejoin="round"
                                                                                    class="editArrivalDepartureRow"
                                                                                    data-id="{{ $transport->id }}"
                                                                                    data-mode="{{ $transport->mode }}"
                                                                                    data-info="{{ $transport->info }}"
                                                                                    data-from-city="{{ $transport->from_city }}"
                                                                                    data-to-city="{{ $transport->to_city }}"
                                                                                    data-departure-date="{{ $transport->departure_date ? $transport->departure_date->format('Y-m-d') : '' }}"
                                                                                    data-departure-time="{{ $transport->departure_time ? substr($transport->departure_time, 0, 5) : '' }}"
                                                                                    data-arrival-date="{{ $transport->arrival_date ? $transport->arrival_date->format('Y-m-d') : '' }}"
                                                                                    data-arrival-time="{{ $transport->arrival_time ? substr($transport->arrival_time, 0, 5) : '' }}"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#addArrivalDepartureModal"
                                                                                    style="width: 16px; height: 16px; color: #0d6efd; cursor: pointer; margin-right: 8px;">
                                                                                    <path
                                                                                        d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7">
                                                                                    </path>
                                                                                    <path
                                                                                        d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z">
                                                                                    </path>
                                                                                </svg>
                                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                                    width="16" height="16"
                                                                                    viewBox="0 0 24 24" fill="none"
                                                                                    stroke="currentColor" stroke-width="2"
                                                                                    stroke-linecap="round"
                                                                                    stroke-linejoin="round"
                                                                                    class="removeArrivalDepartureRow"
                                                                                    data-id="{{ $transport->id }}"
                                                                                    style="width: 16px; height: 16px; color: #dc3545; cursor: pointer;">
                                                                                    <polyline points="3 6 5 6 21 6">
                                                                                    </polyline>
                                                                                    <path
                                                                                        d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                                                    </path>
                                                                                </svg>
                                                                            @endif
                                                                        </td>
                                                                    @endif
                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            <tr>
                                                                <td colspan="{{ !($isViewOnly && ($isOpsDept || ($isPostSales ?? false))) ? '9' : '8' }}"
                                                                    class="text-center text-muted py-4">
                                                                    <i data-feather="inbox"
                                                                        style="width: 24px; height: 24px; opacity: 0.5;"
                                                                        class="mb-2"></i>
                                                                    <div>No arrival/departure data available</div>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Accommodation Details Section -->
                                    @if (!($isPostSales ?? false))
                                        <div class="mb-4 border rounded-3 p-3 bg-light">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h6 class="text-uppercase text-muted small fw-semibold mb-0">
                                                    <i data-feather="home" class="me-1"
                                                        style="width: 14px; height: 14px;"></i>
                                                    Accommodation Details
                                                </h6>
                                                @if (!$isViewOnly)
                                                    <button type="button" class="btn btn-sm btn-primary"
                                                        data-bs-toggle="modal" data-bs-target="#addAccommodationModal">
                                                        <i data-feather="plus" style="width: 14px; height: 14px;"></i>
                                                        Add
                                                    </button>
                                                @endif
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-sm mb-0" id="accommodationTable">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th style="width: 12%;">Destination</th>
                                                            <th style="width: 12%;">Location</th>
                                                            <th style="width: 12%;">Stay At</th>
                                                            <th style="width: 12%;">Check-in</th>
                                                            <th style="width: 12%;">Check-out</th>
                                                            <th style="width: 12%;">Room Type</th>
                                                            <th style="width: 12%;">Meal Plan</th>
                                                            @if (!($isViewOnly && ($isOpsDept || ($isPostSales ?? false))))
                                                                <th style="width: 4%;" class="text-center">Action</th>
                                                            @endif
                                                        </tr>
                                                    </thead>
                                                    <tbody id="accommodationTableBody">
                                                        @if ($lead->bookingAccommodations && $lead->bookingAccommodations->count() > 0)
                                                            @foreach ($lead->bookingAccommodations as $index => $ba)
                                                                <tr class="accommodation-data-row"
                                                                    data-row-index="{{ $index }}">
                                                                    <td>{{ $ba->destination }}</td>
                                                                    <td>{{ $ba->location }}</td>
                                                                    <td>{{ $ba->stay_at }}</td>
                                                                    <td>{{ $ba->checkin_date ? $ba->checkin_date->format('d/m/Y') : '' }}
                                                                    </td>
                                                                    <td>{{ $ba->checkout_date ? $ba->checkout_date->format('d/m/Y') : '' }}
                                                                    </td>
                                                                    <td>{{ $ba->room_type }}</td>
                                                                    <td>{{ $ba->meal_plan }}</td>
                                                                    @if (!($isViewOnly && ($isOpsDept || ($isPostSales ?? false))))
                                                                        <td class="text-center">
                                                                            @if (!$isViewOnly)
                                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                                    width="16" height="16"
                                                                                    viewBox="0 0 24 24" fill="none"
                                                                                    stroke="currentColor" stroke-width="2"
                                                                                    stroke-linecap="round"
                                                                                    stroke-linejoin="round"
                                                                                    class="editAccommodationRow"
                                                                                    data-accommodation-id="{{ $ba->id }}"
                                                                                    data-destination="{{ $ba->destination }}"
                                                                                    data-location="{{ $ba->location }}"
                                                                                    data-stay-at="{{ $ba->stay_at }}"
                                                                                    data-checkin-date="{{ $ba->checkin_date ? $ba->checkin_date->format('Y-m-d') : '' }}"
                                                                                    data-checkout-date="{{ $ba->checkout_date ? $ba->checkout_date->format('Y-m-d') : '' }}"
                                                                                    data-room-type="{{ $ba->room_type }}"
                                                                                    data-meal-plan="{{ $ba->meal_plan }}"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#addAccommodationModal"
                                                                                    style="width: 16px; height: 16px; color: #0d6efd; cursor: pointer; margin-right: 8px;">
                                                                                    <path
                                                                                        d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7">
                                                                                    </path>
                                                                                    <path
                                                                                        d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z">
                                                                                    </path>
                                                                                </svg>
                                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                                    width="16" height="16"
                                                                                    viewBox="0 0 24 24" fill="none"
                                                                                    stroke="currentColor" stroke-width="2"
                                                                                    stroke-linecap="round"
                                                                                    stroke-linejoin="round"
                                                                                    class="removeAccommodationRow"
                                                                                    data-accommodation-id="{{ $ba->id }}"
                                                                                    style="width: 16px; height: 16px; color: #dc3545; cursor: pointer;">
                                                                                    <polyline points="3 6 5 6 21 6">
                                                                                    </polyline>
                                                                                    <path
                                                                                        d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                                                    </path>
                                                                                </svg>
                                                                            @endif
                                                                        </td>
                                                                    @endif
                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            <tr>
                                                                <td colspan="{{ !($isViewOnly && ($isOpsDept || ($isPostSales ?? false))) ? '8' : '7' }}"
                                                                    class="text-center text-muted py-4">
                                                                    <i data-feather="inbox"
                                                                        style="width: 24px; height: 24px; opacity: 0.5;"
                                                                        class="mb-2"></i>
                                                                    <div>No accommodation data available</div>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Day-Wise Itinerary Section -->
                                    @if (!($isPostSales ?? false))
                                        <div class="mb-4 border rounded-3 p-3" id="dayWiseItinerarySection"
                                            style="display: none;">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h6 class="text-uppercase text-muted small fw-semibold mb-0">
                                                    <i data-feather="calendar" class="me-1"
                                                        style="width: 14px; height: 14px;"></i>
                                                    Day-Wise Itinerary
                                                </h6>
                                                @if (!$isViewOnly)
                                                    <button type="button" class="btn btn-sm btn-primary"
                                                        data-bs-toggle="modal" data-bs-target="#addItineraryModal">
                                                        <i data-feather="plus" style="width: 14px; height: 14px;"></i>
                                                        Add
                                                    </button>
                                                @endif
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-sm mb-0" id="itineraryTable">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th style="width: 12%;">Day & Date</th>
                                                            <th style="width: 8%;">Time</th>
                                                            <th style="width: 10%;">Location</th>
                                                            <th style="width: 20%;">Activity/Tour Description</th>
                                                            <th style="width: 10%;">Stay at</th>
                                                            <th style="width: 15%;">Remarks</th>
                                                            @if (!($isViewOnly && ($isOpsDept || ($isPostSales ?? false))))
                                                                <th style="width: 7%;" class="text-center">Action</th>
                                                            @endif
                                                        </tr>
                                                    </thead>
                                                    <tbody id="itineraryTableBody">
                                                        @if ($lead->bookingItineraries && $lead->bookingItineraries->count() > 0)
                                                            @foreach ($lead->bookingItineraries as $index => $bi)
                                                                <tr class="itinerary-data-row"
                                                                    data-row-index="{{ $index }}">
                                                                    <td>{{ $bi->day_and_date }}</td>
                                                                    <td>{{ $bi->time ? substr($bi->time, 0, 5) : '' }}
                                                                    </td>
                                                                    <td>{{ $bi->location }}</td>
                                                                    <td>
                                                                        @if ($bi->activity_tour_description)
                                                                            @php
                                                                                // Handle different line break formats (Windows \r\n, Unix \n, Mac \r)
                                                                                $text = str_replace(
                                                                                    ["\r\n", "\r"],
                                                                                    "\n",
                                                                                    $bi->activity_tour_description,
                                                                                );
                                                                                $activities = array_filter(
                                                                                    array_map(
                                                                                        'trim',
                                                                                        explode("\n", $text),
                                                                                    ),
                                                                                    function ($item) {
                                                                                        return !empty($item);
                                                                                    },
                                                                                );
                                                                            @endphp
                                                                            @if (count($activities) > 0)
                                                                                <div class="mb-0"
                                                                                    style="padding-left: 0; margin-bottom: 0;">
                                                                                    @foreach ($activities as $activity)
                                                                                        <div
                                                                                            style="margin-bottom: 4px; padding-left: 0;">
                                                                                            <span
                                                                                                style="margin-right: 8px;">•</span>{{ $activity }}
                                                                                        </div>
                                                                                    @endforeach
                                                                                </div>
                                                                            @else
                                                                                {{ $bi->activity_tour_description }}
                                                                            @endif
                                                                        @else
                                                                            -
                                                                        @endif
                                                                    </td>
                                                                    <td>{{ $bi->stay_at }}</td>
                                                                    <td>{{ $bi->remarks }}</td>
                                                                    @if (!($isViewOnly && ($isOpsDept || ($isPostSales ?? false))))
                                                                        <td class="text-center">
                                                                            @if (!$isViewOnly)
                                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                                    width="16" height="16"
                                                                                    viewBox="0 0 24 24" fill="none"
                                                                                    stroke="currentColor" stroke-width="2"
                                                                                    stroke-linecap="round"
                                                                                    stroke-linejoin="round"
                                                                                    class="editItineraryRow"
                                                                                    data-itinerary-id="{{ $bi->id }}"
                                                                                    data-day-date="{{ $bi->day_and_date }}"
                                                                                    data-time="{{ $bi->time ? substr($bi->time, 0, 5) : '' }}"
                                                                                    data-location="{{ $bi->location }}"
                                                                                    data-activity="{{ $bi->activity_tour_description }}"
                                                                                    data-stay-at="{{ $bi->stay_at }}"
                                                                                    data-remarks="{{ $bi->remarks }}"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#addItineraryModal"
                                                                                    style="width: 16px; height: 16px; color: #0d6efd; cursor: pointer; margin-right: 8px;">
                                                                                    <path
                                                                                        d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7">
                                                                                    </path>
                                                                                    <path
                                                                                        d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z">
                                                                                    </path>
                                                                                </svg>
                                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                                    width="16" height="16"
                                                                                    viewBox="0 0 24 24" fill="none"
                                                                                    stroke="currentColor" stroke-width="2"
                                                                                    stroke-linecap="round"
                                                                                    stroke-linejoin="round"
                                                                                    class="removeItineraryRow"
                                                                                    data-itinerary-id="{{ $bi->id }}"
                                                                                    style="width: 16px; height: 16px; color: #dc3545; cursor: pointer;">
                                                                                    <polyline points="3 6 5 6 21 6">
                                                                                    </polyline>
                                                                                    <path
                                                                                        d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                                                    </path>
                                                                                </svg>
                                                                            @endif
                                                                        </td>
                                                                    @endif
                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            <tr>
                                                                <td colspan="{{ !($isViewOnly && ($isOpsDept || ($isPostSales ?? false))) ? '7' : '6' }}"
                                                                    class="text-center text-muted py-4">
                                                                    <i data-feather="inbox"
                                                                        style="width: 24px; height: 24px; opacity: 0.5;"
                                                                        class="mb-2"></i>
                                                                    <div>No itinerary data available</div>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Traveller Document Details (Post Sales editable, Operations view-only) -->
                                    @if (($isPostSales ?? false) || ($isOpsDept ?? false))
                                        <div class="mb-4 border rounded-3 p-3">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h6 class="text-uppercase text-muted small fw-semibold mb-0">
                                                    <i data-feather="clipboard" class="me-1"
                                                        style="width: 14px; height: 14px;"></i>
                                                    Traveller Document Details
                                                </h6>
                                                @if (!($isOpsDept ?? false))
                                                    <button type="button" id="openTravellerDocModalBtn"
                                                        class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                        data-bs-target="#travellerDocumentModal">
                                                        <i data-feather="plus" style="width: 14px; height: 14px;"></i>
                                                        Add
                                                    </button>
                                                @endif
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-sm mb-0"
                                                    id="travellerDocumentTable">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th style="width: 5%;">Sr. No.</th>
                                                            <th style="width: 25%;">Full Name</th>
                                                            <th style="width: 10%;">Contact No.</th>
                                                            <th style="width: 15%;">Doc Type</th>
                                                            <th style="width: 18%;">Doc No.</th>
                                                            <th style="width: 10%;">Nationality</th>
                                                            <th style="width: 8%;">DOB</th>
                                                            <th style="width: 10%;">Place of Issue</th>
                                                            <th style="width: 10%;">Expiry</th>
                                                            <th style="width: 12%;">Remark</th>
                                                            <th style="width: 10%;">Status</th>
                                                            @if (!($isOpsDept ?? false))
                                                                <th style="width: 8%;" class="text-center">Action</th>
                                                            @endif
                                                        </tr>
                                                    </thead>
                                                    <tbody id="travellerDocumentTableBody">
                                                        @php
                                                            $travellerDocs = $lead->travellerDocuments ?? collect();
                                                        @endphp
                                                        @forelse($travellerDocs as $index => $doc)
                                                            <tr data-row-type="{{ $doc->doc_type }}">
                                                                <td>{{ $index + 1 }}</td>
                                                                <td>
                                                                    @php
                                                                        $fullName = trim(
                                                                            ($doc->salutation
                                                                                ? $doc->salutation . ' '
                                                                                : '') .
                                                                                ($doc->first_name ?? '') .
                                                                                ($doc->last_name
                                                                                    ? ' ' . $doc->last_name
                                                                                    : ''),
                                                                        );
                                                                    @endphp
                                                                    {{ $fullName ?: '-' }}
                                                                </td>
                                                                <td>{{ $doc->contact_no ?? '-' }}</td>
                                                                <td>
                                                                    @switch($doc->doc_type)
                                                                        @case('passport')
                                                                            Passport
                                                                        @break

                                                                        @case('aadhar_card')
                                                                            Aadhar Card
                                                                        @break

                                                                        @case('pan_card')
                                                                            PAN Card
                                                                        @break

                                                                        @case('visa')
                                                                            Visa
                                                                        @break

                                                                        @case('voter_id')
                                                                            Voter ID
                                                                        @break

                                                                        @case('driving_license')
                                                                            Driving License
                                                                        @break

                                                                        @case('govt_id')
                                                                            Govt. ID
                                                                        @break

                                                                        @case('school_id')
                                                                            School ID
                                                                        @break

                                                                        @case('birth_certificate')
                                                                            Birth Certificate
                                                                        @break

                                                                        @case('marriage_certificate')
                                                                            Marriage Certificate
                                                                        @break

                                                                        @case('photos')
                                                                            Photos
                                                                        @break

                                                                        @case('insurance')
                                                                            Insurance
                                                                        @break

                                                                        @case('other_document')
                                                                            Other Document
                                                                        @break

                                                                        @default
                                                                            {{ ucfirst(str_replace('_', ' ', $doc->doc_type)) }}
                                                                    @endswitch
                                                                </td>

                                                                <td>{{ $doc->doc_no ?? '-' }}</td>
                                                                <td>
                                                                    @if ($doc->doc_type === 'passport')
                                                                        {{ $doc->nationality }}
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if ($doc->doc_type === 'passport' && $doc->dob)
                                                                        {{ $doc->dob->format('d/m/Y') }}
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if ($doc->doc_type === 'passport')
                                                                        {{ $doc->place_of_issue }}
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if ($doc->doc_type === 'passport' && $doc->date_of_expiry)
                                                                        {{ $doc->date_of_expiry->format('d/m/Y') }}
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    {{ $doc->remark ?? '-' }}
                                                                </td>
                                                                <td>
                                                                    @php
                                                                        $status = strtolower($doc->status ?? '');
                                                                        $badgeClass = 'secondary';
                                                                        $statusLabel = ucfirst(
                                                                            str_replace('_', ' ', $status),
                                                                        );
                                                                        if ($status === 'received') {
                                                                            $badgeClass = 'success';
                                                                        } elseif ($status === 'pending') {
                                                                            $badgeClass = 'warning';
                                                                        } elseif ($status === 'not_required') {
                                                                            $badgeClass = 'secondary';
                                                                        } elseif ($status === 'required_again') {
                                                                            $badgeClass = 'danger';
                                                                        }
                                                                    @endphp
                                                                    @if ($status)
                                                                        <span class="badge bg-{{ $badgeClass }}">
                                                                            {{ $statusLabel }}
                                                                        </span>
                                                                    @endif
                                                                </td>
                                                                @if (!($isOpsDept ?? false))
                                                                    <td class="text-center text-nowrap">
                                                                        <button type="button"
                                                                            class="btn btn-link p-0 me-1 traveller-doc-edit"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#travellerDocumentModal"
                                                                            data-document-id="{{ $doc->id }}"
                                                                            data-salutation="{{ $doc->salutation ?? '' }}"
                                                                            data-first-name="{{ $doc->first_name }}"
                                                                            data-last-name="{{ $doc->last_name }}"
                                                                            data-contact-no="{{ $doc->contact_no ?? '' }}"
                                                                            data-doc-type="{{ $doc->doc_type }}"
                                                                            data-status="{{ $doc->status }}"
                                                                            data-doc-no="{{ $doc->doc_no }}"
                                                                            data-nationality="{{ $doc->nationality }}"
                                                                            data-dob="{{ $doc->dob ? $doc->dob->format('Y-m-d') : '' }}"
                                                                            data-place-of-issue="{{ $doc->place_of_issue }}"
                                                                            data-date-of-expiry="{{ $doc->date_of_expiry ? $doc->date_of_expiry->format('Y-m-d') : '' }}"
                                                                            data-remark="{{ $doc->remark ?? '' }}">
                                                                            <i data-feather="edit" class="text-primary"
                                                                                style="width: 16px; height: 16px;"></i>
                                                                        </button>
                                                                        <button type="button"
                                                                            class="btn btn-link p-0 traveller-doc-delete"
                                                                            data-delete-url="{{ route('leads.traveller-documents.destroy', [$lead, $doc]) }}">
                                                                            <i data-feather="trash-2" class="text-danger"
                                                                                style="width: 16px; height: 16px;"></i>
                                                                        </button>
                                                                    </td>
                                                                @endif
                                                            </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="{{ $isOpsDept ?? false ? '11' : '12' }}"
                                                                        class="text-center text-muted py-3">
                                                                        No traveller document details added yet.
                                                                    </td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <!-- Document Checklist Summary Section (Post Sales Only) -->
                                            <div class="mb-4 border rounded-3 p-3">
                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <h6 class="text-uppercase text-muted small fw-semibold mb-0">
                                                        <i data-feather="file-text" class="me-1"
                                                            style="width: 14px; height: 14px;"></i>
                                                        Document Checklist Summary (Across Entire Booking)
                                                    </h6>
                                                </div>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-sm mb-0">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th>Document Type</th>
                                                                <th class="text-center">Total Required</th>
                                                                <th class="text-center">Received</th>
                                                                <th class="text-center">Pending</th>
                                                                <th class="text-center">Issues Found</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php
                                                                $travellerDocs = $lead->travellerDocuments ?? collect();
                                                                $documentTypes = [
                                                                    'passport' => 'Passports',
                                                                    'visa' => 'Visa',
                                                                    'pan_card' => 'Pan Card',
                                                                    'voter_id' => 'Voter ID',
                                                                    'driving_license' => 'Driving License',
                                                                    'govt_id' => 'Govt. ID',
                                                                    'school_id' => 'School ID',
                                                                    'birth_certificate' => 'Birth Certificate',
                                                                    'marriage_certificate' => 'Marriage Certificate',
                                                                    'aadhar_card' => 'Aadhar',
                                                                    'photos' => 'Photos',
                                                                    'insurance' => 'Insurance',
                                                                ];

                                                                // Group documents by type and calculate counts
                                                                $docCounts = [];
                                                                foreach ($documentTypes as $docType => $docLabel) {
                                                                    $docsOfType = $travellerDocs->where(
                                                                        'doc_type',
                                                                        $docType,
                                                                    );
                                                                    $totalRequired = $docsOfType->count();
                                                                    $received = $docsOfType
                                                                        ->where('status', 'received')
                                                                        ->count();
                                                                    $pending = $docsOfType
                                                                        ->where('status', 'pending')
                                                                        ->count();
                                                                    $issuesFound = $docsOfType
                                                                        ->where('status', 'required_again')
                                                                        ->count();

                                                                    // Get remarks for documents that are not received
                                                                    $notReceivedDocs = $docsOfType
                                                                        ->where('status', '!=', 'received')
                                                                        ->whereNotNull('remark')
                                                                        ->where('remark', '!=', '');
                                                                    $remarks = $notReceivedDocs
                                                                        ->pluck('remark')
                                                                        ->filter()
                                                                        ->unique()
                                                                        ->values();

                                                                    $docCounts[$docType] = [
                                                                        'label' => $docLabel,
                                                                        'total_required' => $totalRequired,
                                                                        'received' => $received,
                                                                        'pending' => $pending,
                                                                        'issues_found' => $issuesFound,
                                                                        'remarks' => $remarks,
                                                                    ];
                                                                }
                                                            @endphp
                                                            @foreach ($docCounts as $docType => $counts)
                                                                <tr>
                                                                    <td>{{ $counts['label'] }}</td>
                                                                    <td class="text-center">{{ $counts['total_required'] }}
                                                                    </td>
                                                                    <td class="text-center">{{ $counts['received'] }}</td>
                                                                    <td class="text-center">{{ $counts['pending'] }}</td>
                                                                    <td class="text-center">
                                                                        @if ($counts['remarks']->isNotEmpty())
                                                                            <div class="text-start"
                                                                                style="max-width: 200px; font-size: 0.85rem;">
                                                                                @foreach ($counts['remarks'] as $remark)
                                                                                    <div class="mb-1">{{ $remark }}
                                                                                    </div>
                                                                                @endforeach
                                                                            </div>
                                                                        @elseif($counts['issues_found'] > 0)
                                                                            {{ $counts['issues_found'] }} incorrect
                                                                        @else
                                                                            0
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        @endif

                                        <!-- Vendor Payments Section (Ops Only) -->
                                        @if ($isOpsDept ?? false)
                                            <div class="mb-4 border rounded-3 p-3">
                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <div>
                                                        <h6 class="text-uppercase text-muted small fw-semibold mb-0">
                                                            <i data-feather="dollar-sign" class="me-1"
                                                                style="width: 14px; height: 14px;"></i>
                                                            Vendor Payments (Ops → Accounts)
                                                        </h6>
                                                    </div>
                                                    {{-- Ops can always edit Vendor Payments, even in view-only mode --}}
                                                    <button type="button" class="btn btn-sm btn-primary"
                                                        data-bs-toggle="modal" data-bs-target="#addVendorPaymentModal">
                                                        <i data-feather="plus" style="width: 14px; height: 14px;"></i>
                                                        Add
                                                    </button>
                                                </div>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-sm mb-0"
                                                        id="vendorPaymentsTable">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th>Vendor Code/Name</th>
                                                                <th>Booking Type</th>
                                                                <th>Location</th>
                                                                <th>Purchase Cost</th>
                                                                <th>Due Date</th>
                                                                @if (!($isOpsDept ?? false) && !($isPostSales ?? false))
                                                                    <th style="background-color: #fff3cd;">Paid</th>
                                                                    <th style="background-color: #fff3cd;">Pending</th>
                                                                    <th style="background-color: #fff3cd;">Payment Mode</th>
                                                                    <th style="background-color: #fff3cd;">Ref. No.</th>
                                                                    <th style="background-color: #fff3cd;">Remarks</th>
                                                                @else
                                                                    <th>Status</th>
                                                                @endif
                                                                <th class="text-center">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="vendorPaymentsTableBody">
                                                            @if (isset($vendorPayments) && $vendorPayments->count() > 0)
                                                                @foreach ($vendorPayments as $vp)
                                                                    <tr data-vendor-payment-id="{{ $vp->id }}"
                                                                        data-vendor-code="{{ $vp->vendor_code ?? '' }}"
                                                                        data-booking-type="{{ $vp->booking_type ?? '' }}"
                                                                        data-location="{{ $vp->location ?? '' }}"
                                                                        data-purchase-cost="{{ $vp->purchase_cost ?? 0 }}"
                                                                        data-due-date="{{ $vp->due_date ? $vp->due_date->format('Y-m-d') : '' }}"
                                                                        data-status="{{ $vp->status ?? 'Pending' }}">
                                                                        <td>{{ $vp->vendor_code ?? '-' }}</td>
                                                                        <td>{{ $vp->booking_type ?? '-' }}</td>
                                                                        <td>{{ $vp->location ?? '-' }}</td>
                                                                        <td>{{ $vp->purchase_cost ? number_format($vp->purchase_cost, 2) : '-' }}
                                                                        </td>
                                                                        <td>{{ $vp->due_date ? $vp->due_date->format('d/m/Y') : '-' }}
                                                                        </td>
                                                                        @if (!($isOpsDept ?? false) && !($isPostSales ?? false))
                                                                            <td style="background-color: #fff3cd;">
                                                                                {{ $vp->paid_amount ? number_format($vp->paid_amount, 2) : '-' }}
                                                                            </td>
                                                                            <td style="background-color: #fff3cd;">
                                                                                {{ $vp->pending_amount ? number_format($vp->pending_amount, 2) : '-' }}
                                                                            </td>
                                                                            <td style="background-color: #fff3cd;">
                                                                                {{ $vp->payment_mode ?? '-' }}</td>
                                                                            <td style="background-color: #fff3cd;">
                                                                                {{ $vp->ref_no ?? '-' }}</td>
                                                                            <td style="background-color: #fff3cd;">
                                                                                {{ $vp->remarks ?? '-' }}</td>
                                                                        @else
                                                                            <td>
                                                                                <span
                                                                                    class="badge bg-{{ $vp->status == 'Paid' ? 'success' : ($vp->status == 'Pending' ? 'warning' : 'secondary') }}">
                                                                                    {{ $vp->status ?? 'Pending' }}
                                                                                </span>
                                                                            </td>
                                                                        @endif
                                                                        <td class="text-center">
                                                                            {{-- Ops can always edit/delete Vendor Payments, even in view-only mode --}}
                                                                            <button type="button"
                                                                                class="btn btn-sm btn-outline-primary edit-vendor-payment-btn"
                                                                                data-vendor-payment-id="{{ $vp->id }}"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#addVendorPaymentModal">
                                                                                <i data-feather="edit"
                                                                                    style="width: 14px; height: 14px;"></i>
                                                                            </button>
                                                                            <button type="button"
                                                                                class="btn btn-sm btn-outline-danger delete-vendor-payment-btn"
                                                                                data-vendor-payment-id="{{ $vp->id }}">
                                                                                <i data-feather="trash-2"
                                                                                    style="width: 14px; height: 14px;"></i>
                                                                            </button>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            @else
                                                                <tr>
                                                                    <td colspan="{{ $isViewOnly && $isOpsDept ? '7' : '11' }}"
                                                                        class="text-center text-muted py-4">No vendor payments
                                                                        found</td>
                                                                </tr>
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        @endif

                                        @if (!$isViewOnly)
                                            {{-- Cancel and Save Booking File buttons removed --}}
                                        @else
                                            <div class="d-flex justify-content-end gap-2 mb-4">
                                                <a href="{{ $backUrl ?? route('bookings.index') }}"
                                                    class="btn btn-light border">Back</a>
                                            </div>
                                        @endif
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @can('edit leads')
            <!-- Re-assign Lead Modal -->
            <div class="modal fade" id="reassignLeadModal" tabindex="-1" aria-labelledby="reassignLeadModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form action="{{ route('leads.reassign', $lead) }}" method="POST">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title" id="reassignLeadModalLabel">Re-assign Lead</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Assign To <span class="text-danger">*</span></label>
                                    <select name="reassigned_user_id" class="form-select form-select-sm" required>
                                        <option value="">-- Select Employee --</option>
                                        @foreach ($employees as $employee)
                                            @php
                                                $matchingUser = \App\Models\User::where(
                                                    'email',
                                                    $employee->login_work_email,
                                                )
                                                    ->orWhere('email', $employee->user_id)
                                                    ->first();
                                                $isSelected = false;
                                                if (
                                                    $lead->reassigned_to &&
                                                    $matchingUser &&
                                                    $lead->reassigned_to == $matchingUser->id
                                                ) {
                                                    $isSelected = true;
                                                }
                                            @endphp
                                            <option value="{{ $employee->id }}" data-user-id="{{ $matchingUser->id ?? '' }}"
                                                {{ $isSelected ? 'selected' : '' }}>
                                                {{ $employee->name }} @if ($employee->user_id)
                                                    ({{ $employee->user_id }})
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-sm btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endcan

        @if ($isPostSales ?? false)
            <!-- Traveller Document Details Modal -->
            <div class="modal fade" id="travellerDocumentModal" tabindex="-1" aria-labelledby="travellerDocumentModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="travellerDocumentModalLabel">Traveller Document Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="travellerDocumentForm" action="{{ route('leads.traveller-documents.store', $lead) }}"
                            method="POST">
                            @csrf
                            <input type="hidden" name="traveller_document_id" id="travellerDocumentId" value="">
                            <div class="modal-body">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label">Salutation</label>
                                        <select class="form-select form-select-sm" name="salutation">
                                            <option value="">Select</option>
                                            <option value="Mr">Mr</option>
                                            <option value="Mrs">Mrs</option>
                                            <option value="Ms">Ms</option>
                                            <option value="Miss">Miss</option>
                                            <option value="Dr">Dr</option>
                                            <option value="Prof">Prof</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">First Name</label>
                                        <input type="text" class="form-control form-control-sm" name="first_name">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Last Name</label>
                                        <input type="text" class="form-control form-control-sm" name="last_name">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Traveller Contact No.</label>
                                        <input type="text" class="form-control form-control-sm" name="contact_no"
                                            placeholder="Enter contact number">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Document Type</label>
                                        <select class="form-select form-select-sm" name="document_type"
                                            id="travellerDocumentType" required>
                                            <option value="">Select</option>
                                            <option value="passport">Passport</option>
                                            <option value="visa">Visa</option>
                                            <option value="aadhar_card">Aadhar Card</option>
                                            <option value="pan_card">PAN Card</option>
                                            <option value="voter_id">Voter ID</option>
                                            <option value="driving_license">Driving License</option>
                                            <option value="govt_id">Govt. ID</option>
                                            <option value="school_id">School ID</option>
                                            <option value="birth_certificate">Birth Certificate</option>
                                            <option value="marriage_certificate">Marriage Certificate</option>
                                            <option value="photos">Photos</option>
                                            <option value="insurance">Insurance</option>
                                            <option value="other_document">Other Document</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Status</label>
                                        <select class="form-select form-select-sm" name="status">
                                            <option value="received">Received</option>
                                            <option value="pending">Pending</option>
                                            <option value="not_required">Not Required</option>
                                            <option value="required_again">Required Again</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Doc No.</label>
                                        <input type="text" class="form-control form-control-sm" name="document_details"
                                            placeholder="Passport No. / Aadhar No. / PAN No. / Other">
                                    </div>
                                    <div class="col-md-4" id="dobFieldContainer" style="display: none;">
                                        <label class="form-label">DOB</label>
                                        <input type="date" class="form-control form-control-sm" name="dob"
                                            id="travellerDobField">
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label">Remark</label>
                                        <textarea class="form-control form-control-sm" name="remark" rows="2"
                                            placeholder="Enter any remarks or notes about this document"></textarea>
                                    </div>
                                </div>
                                <hr class="my-3">
                                <div id="passportExtraFields">
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label class="form-label">Nationality</label>
                                            <input type="text" class="form-control form-control-sm" name="nationality">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Place of Issue</label>
                                            <input type="text" class="form-control form-control-sm" name="place_of_issue">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Date of Expiry</label>
                                            <input type="date" class="form-control form-control-sm" name="date_of_expiry">
                                        </div>
                                    </div>
                                    <small class="text-muted d-block mt-2">These fields are mainly for Passport
                                        documents.</small>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-sm btn-secondary"
                                    data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-sm btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Post Sales: Add/Edit Customer Payment Modal -->
            <div class="modal fade" id="postSalesAddPaymentModal" tabindex="-1"
                aria-labelledby="postSalesAddPaymentModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form id="postSalesPaymentForm" action="{{ route('leads.payments.store', $lead->id) }}"
                            method="POST">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title" id="postSalesAddPaymentModalLabel">Add Customer Payment</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="_method" id="postSalesPaymentFormMethod" value="POST">
                                <div class="mb-3">
                                    <label class="form-label">Amount <span class="text-danger">*</span></label>
                                    <input type="number" name="amount" class="form-control form-control-sm" step="0.01"
                                        min="0" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Payment Method <span class="text-danger">*</span></label>
                                    <select name="method" class="form-select form-select-sm" required>
                                        <option value="">Select</option>
                                        <option value="Cash">Cash</option>
                                        <option value="UPI">UPI</option>
                                        <option value="NEFT">NEFT</option>
                                        <option value="RTGS">RTGS</option>
                                        <option value="WIB">WIB</option>
                                        <option value="Online">Online</option>
                                        <option value="Cheque">Cheque</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Paid On <span class="text-danger">*</span></label>
                                    <input type="date" name="payment_date" class="form-control form-control-sm"
                                        value="{{ date('Y-m-d') }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Due Date</label>
                                    <input type="date" name="due_date" class="form-control form-control-sm">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Transaction ID</label>
                                    <input type="text" name="reference" class="form-control form-control-sm"
                                        maxlength="255">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Status <span class="text-danger">*</span></label>
                                    <select name="status_display" class="form-select form-select-sm"
                                        {{ $isPostSales ?? false ? 'disabled' : 'required' }}>
                                        <option value="pending">Pending</option>
                                        <option value="received">Received</option>
                                        <option value="refunded">Refunded</option>
                                    </select>
                                    @if ($isPostSales ?? false)
                                        <input type="hidden" name="status" id="hiddenPaymentStatus" value="pending">
                                    @else
                                        {{-- If not post sales, we need the select to have the name "status" --}}
                                        <script>
                                            document.currentScript.previousElementSibling.previousElementSibling.name = "status";
                                        </script>
                                    @endif
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-sm btn-secondary"
                                    data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-sm btn-primary">Save Payment</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif

        <!-- Add Destination Modal -->
        <div class="modal fade" id="addDestinationModal" tabindex="-1" aria-labelledby="addDestinationModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addDestinationModalLabel">Add Destination</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addDestinationForm">
                            <div class="mb-3">
                                <label class="form-label">Destination <span class="text-danger">*</span></label>
                                <select class="form-select form-select-sm" id="modalDestinationSelect" required>
                                    <option value="">-- Select Destination --</option>
                                    @foreach ($destinations as $dest)
                                        <option value="{{ $dest->name }}" data-destination-id="{{ $dest->id }}">
                                            {{ $dest->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Location <span class="text-danger">*</span></label>
                                <select class="form-select form-select-sm" id="modalLocationSelect" required>
                                    <option value="">-- Select Location --</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Service Type <span class="text-danger">*</span></label>
                                <div class="btn-group w-100" role="group" aria-label="Service Type">
                                    <input type="radio" class="btn-check" name="service_type" id="modalOnlyHotel"
                                        value="only_hotel" autocomplete="off">
                                    <label class="btn btn-outline-primary btn-sm" for="modalOnlyHotel">Only Hotel</label>

                                    <input type="radio" class="btn-check" name="service_type" id="modalOnlyTT"
                                        value="only_tt" autocomplete="off">
                                    <label class="btn btn-outline-primary btn-sm" for="modalOnlyTT">Only TT</label>

                                    <input type="radio" class="btn-check" name="service_type" id="modalHotelTT"
                                        value="hotel_tt" autocomplete="off">
                                    <label class="btn btn-outline-primary btn-sm" for="modalHotelTT">Hotel + TT</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">From Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control form-control-sm" id="modalFromDate" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">To Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control form-control-sm" id="modalToDate" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="submitDestinationModal">Add</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Arrival/Departure Modal -->
        <div class="modal fade" id="addArrivalDepartureModal" tabindex="-1" aria-labelledby="addArrivalDepartureModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addArrivalDepartureModalLabel">Add Arrival/Departure</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addArrivalDepartureForm">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Mode <span class="text-danger">*</span></label>
                                    <select class="form-select form-select-sm" id="modalMode" required>
                                        <option value="By Air">By Air</option>
                                        <option value="By Surface">By Surface</option>
                                        <option value="By Sea">By Sea</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Info</label>
                                    <input type="text" class="form-control form-control-sm" id="modalInfo"
                                        placeholder="Info">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">From City</label>
                                    <input type="text" class="form-control form-control-sm" id="modalFromCity"
                                        placeholder="From City">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">To City</label>
                                    <input type="text" class="form-control form-control-sm" id="modalToCity"
                                        placeholder="To City">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Departure Date & Time <span class="text-danger">*</span></label>
                                    <input type="datetime-local" class="form-control form-control-sm" id="modalDepartureAt"
                                        required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Arrival Date & Time <span class="text-danger">*</span></label>
                                    <input type="datetime-local" class="form-control form-control-sm" id="modalArrivalAt"
                                        required>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="submitArrivalDepartureModal">Add</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Accommodation Modal -->
        <div class="modal fade" id="addAccommodationModal" tabindex="-1" aria-labelledby="addAccommodationModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addAccommodationModalLabel">Add Accommodation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addAccommodationForm">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Destination</label>
                                    <select class="form-select form-select-sm" id="modalAccDestinationSelect">
                                        <option value="">-- Select Destination --</option>
                                        @foreach ($destinations as $dest)
                                            <option value="{{ $dest->name }}"
                                                data-destination-id="{{ $dest->id }}">{{ $dest->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Location</label>
                                    <select class="form-select form-select-sm" id="modalAccLocationSelect">
                                        <option value="">-- Select Location --</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Stay At</label>
                                    <input type="text" class="form-control form-control-sm" id="modalStayAt"
                                        placeholder="Stay At">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Check-in Date</label>
                                    <input type="date" class="form-control form-control-sm" id="modalCheckinDate">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Check-out Date</label>
                                    <input type="date" class="form-control form-control-sm" id="modalCheckoutDate">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Room Type</label>
                                    <input type="text" class="form-control form-control-sm" id="modalRoomType"
                                        placeholder="Room Type">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Meal Plan</label>
                                    <select class="form-select form-select-sm" id="modalMealPlan">
                                        <option value="">-- Select --</option>
                                        <option value="EP">EP</option>
                                        <option value="CP">CP</option>
                                        <option value="MAP">MAP</option>
                                        <option value="AP">AP</option>
                                        <option value="AI">AI</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="submitAccommodationModal">Add</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Itinerary Modal -->
        <div class="modal fade" id="addItineraryModal" tabindex="-1" aria-labelledby="addItineraryModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addItineraryModalLabel">Add Day-Wise Itinerary</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addItineraryForm">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Day & Date</label>
                                    <input type="text" class="form-control form-control-sm" id="modalDayDate"
                                        placeholder="Day & Date">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Time</label>
                                    <input type="time" class="form-control form-control-sm" id="modalItineraryTime">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Location</label>
                                    <input type="text" class="form-control form-control-sm" id="modalItineraryLocation"
                                        placeholder="Location">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Stay At</label>
                                    <input type="text" class="form-control form-control-sm" id="modalItineraryStayAt"
                                        placeholder="Stay at">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Activity/Tour Description</label>
                                    <textarea class="form-control form-control-sm" id="modalActivity" rows="5"
                                        placeholder="Enter each activity on a new line (press Enter for list items)"></textarea>
                                    <small class="text-muted">Each line will be displayed as a list item in the itinerary
                                        table.</small>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Remarks</label>
                                    <textarea class="form-control form-control-sm" id="modalRemarks" rows="3" placeholder="Remarks"></textarea>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="submitItineraryModal">Add</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add/Edit Vendor Payment Modal (Ops Only) -->
        @if ($isOpsDept ?? false)
            <div class="modal fade" id="addVendorPaymentModal" tabindex="-1"
                aria-labelledby="addVendorPaymentModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addVendorPaymentModalLabel">Add Vendor Payment</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="addVendorPaymentForm">
                                @csrf
                                <input type="hidden" id="vendorPaymentId" name="vendor_payment_id" value="">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Vendor Code/Name <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-sm" id="modalVendorCode"
                                            name="vendor_code" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Booking Type <span class="text-danger">*</span></label>
                                        <select class="form-select form-select-sm" id="modalBookingType"
                                            name="booking_type" required>
                                            <option value="">-- Select --</option>
                                            <option value="Hotel">Hotel</option>
                                            <option value="TT">TT</option>
                                            <option value="Hotel + TT">Hotel + TT</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Location <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-sm" id="modalLocation"
                                            name="location" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Purchase Cost <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control form-control-sm" id="modalPurchaseCost"
                                            name="purchase_cost" step="0.01" min="0" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Due Date <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control form-control-sm" id="modalDueDate"
                                            name="due_date" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Status <span class="text-danger">*</span></label>
                                        <select class="form-select form-select-sm" id="modalStatus" name="status"
                                            required>
                                            <option value="Pending" selected>Pending</option>
                                            <option value="Cancelled">Cancelled</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary" id="submitVendorPaymentModal">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @push('scripts')
            <script>
                $(document).ready(function() {
                    // Disable all form inputs if in view-only mode
                    @if ($isViewOnly)
                        $('#bookingFileForm').find('input, select, textarea').not('[readonly]').prop('disabled', true).css({
                            'background-color': '#f8f9fa',
                            'cursor': 'not-allowed'
                        });
                        // Also disable checkboxes
                        $('#bookingFileForm').find('input[type="checkbox"]').prop('disabled', true);
                    @endif

                    // Don't call feather.replace() globally - let init.js handle it
                    // We'll only ensure specific sections (like accommodation) are properly initialized

                    // Function to calculate and update profit
                    function updateBookingProfit() {
                        const sellingPrice = parseFloat(document.getElementById('bookingSellingPrice')?.value || 0);
                        const totalCost = parseFloat(document.getElementById('bookingTotalCost')?.value || 0);
                        const profit = sellingPrice - totalCost;

                        if (document.getElementById('bookingProfit')) {
                            document.getElementById('bookingProfit').value = profit.toFixed(2);
                        }
                    }

                    // Update profit when selling price or total cost changes
                    const sellingPriceInput = document.getElementById('bookingSellingPrice');
                    const totalCostInput = document.getElementById('bookingTotalCost');

                    if (sellingPriceInput) {
                        sellingPriceInput.addEventListener('input', updateBookingProfit);
                    }
                    if (totalCostInput) {
                        totalCostInput.addEventListener('input', updateBookingProfit);
                    }

                    // Calculate profit on page load
                    updateBookingProfit();

                    // Destination table management
                    let destinationRowIndex = {{ $lead->bookingDestinations ? $lead->bookingDestinations->count() : 0 }};

                    // Function to load locations for input row destination
                    // Function to load locations for the modal destination dropdown
                    function loadLocationsForModal(destinationSelect) {
                        const locationSelect = document.getElementById('modalLocationSelect');
                        const selectedOption = destinationSelect.options[destinationSelect.selectedIndex];
                        const destinationId = selectedOption?.getAttribute('data-destination-id');

                        if (locationSelect) {
                            locationSelect.innerHTML = '<option value="">-- Select Location --</option>';

                            if (destinationId) {
                                locationSelect.disabled = true;
                                locationSelect.innerHTML = '<option value="">Loading locations...</option>';
                                const submitBtn = document.getElementById('submitDestinationModal');
                                if (submitBtn) submitBtn.disabled = true;

                                fetch(`/api/destinations/${destinationId}/locations`, {
                                        method: 'GET',
                                        headers: {
                                            'X-Requested-With': 'XMLHttpRequest',
                                            'Accept': 'application/json',
                                        },
                                        credentials: 'same-origin'
                                    })
                                    .then(response => response.json())
                                    .then(data => {
                                        locationSelect.innerHTML = '<option value="">-- Select Location --</option>';
                                        data.forEach(location => {
                                            const option = document.createElement('option');
                                            option.value = location.name;
                                            option.textContent = location.name;
                                            locationSelect.appendChild(option);
                                        });

                                        // If a location is pending selection (editing), set it now
                                        if (typeof editingLocationValue !== 'undefined' && editingLocationValue) {
                                            locationSelect.value = editingLocationValue;
                                        }
                                        locationSelect.disabled = false;
                                        const submitBtn = document.getElementById('submitDestinationModal');
                                        if (submitBtn) submitBtn.disabled = false;
                                    })
                                    .catch(error => {
                                        console.error('Error loading locations:', error);
                                        locationSelect.innerHTML = '<option value="">Error loading locations</option>';
                                        locationSelect.disabled = false;
                                        const submitBtn = document.getElementById('submitDestinationModal');
                                        if (submitBtn) submitBtn.disabled = false;
                                    });
                            } else {
                                locationSelect.disabled = false;
                            }
                        }
                    }

                    // Attach change listener to modal destination dropdown
                    document.getElementById('modalDestinationSelect')?.addEventListener('change', function() {
                        loadLocationsForModal(this);
                    });

                    // Destination management variables
                    let editingDestinationRow = null;
                    let editingLocationValue = null;

                    // Reset modal for New Destination
                    document.querySelector('[data-bs-target="#addDestinationModal"]')?.addEventListener('click',
                function() {
                        if (this.id === 'submitDestinationModal') return; // Ignore submit click
                        editingDestinationRow = null;
                        document.getElementById('addDestinationModalLabel').textContent = 'Add Destination';
                        document.getElementById('addDestinationForm').reset();
                        document.getElementById('modalLocationSelect').innerHTML =
                            '<option value="">-- Select Location --</option>';
                        document.getElementById('submitDestinationModal').textContent = 'Add';
                    });

                    // Edit Handler (UI side)
                    document.addEventListener('click', function(e) {
                        if (e.target.closest('.editDestinationRow')) {
                            const icon = e.target.closest('.editDestinationRow');
                            const row = icon.closest('tr');
                            editingDestinationRow = row;

                            // Get data from attributes
                            const destination = icon.dataset.destination;
                            const location = icon.dataset.location;
                            const onlyHotel = icon.dataset.onlyHotel === '1';
                            const onlyTT = icon.dataset.onlyTt === '1';
                            const hotelTT = icon.dataset.hotelTt === '1';

                            const fromDate = icon.dataset.fromDate || '';
                            const toDate = icon.dataset.toDate || '';

                            // Populate modal
                            document.getElementById('modalDestinationSelect').value = destination;
                            editingLocationValue = location;

                            // Uncheck all first
                            document.getElementById('modalOnlyHotel').checked = false;
                            document.getElementById('modalOnlyTT').checked = false;
                            document.getElementById('modalHotelTT').checked = false;

                            // Check the correct radio button
                            if (onlyHotel) document.getElementById('modalOnlyHotel').checked = true;
                            if (onlyTT) document.getElementById('modalOnlyTT').checked = true;
                            if (hotelTT) document.getElementById('modalHotelTT').checked = true;

                            document.getElementById('modalFromDate').value = fromDate;
                            document.getElementById('modalToDate').value = toDate;

                            // Change modal title & button
                            document.getElementById('addDestinationModalLabel').textContent = 'Edit Destination';
                            document.getElementById('submitDestinationModal').textContent = 'Update';

                            // Trigger location load
                            const destinationSelect = document.getElementById('modalDestinationSelect');
                            if (destinationSelect.value) {
                                destinationSelect.dispatchEvent(new Event('change'));
                            }
                        }
                    });

                    // Handle modal form submission (AJAX)
                    document.getElementById('submitDestinationModal')?.addEventListener('click', async function() {
                        const submitBtn = this;
                        const destination = document.getElementById('modalDestinationSelect').value;
                        const location = document.getElementById('modalLocationSelect').value;

                        const selectedServiceType = document.querySelector('input[name="service_type"]:checked')
                            ?.value;
                        const onlyHotel = selectedServiceType === 'only_hotel';
                        const onlyTT = selectedServiceType === 'only_tt';
                        const hotelTT = selectedServiceType === 'hotel_tt';

                        const fromDate = document.getElementById('modalFromDate').value;
                        const toDate = document.getElementById('modalToDate').value;

                        if (!destination || !location || !fromDate || !toDate) {
                            alert('Please fill in all required fields');
                            return;
                        }

                        if (!selectedServiceType) {
                            alert('Please select a service type');
                            return;
                        }

                        submitBtn.disabled = true;
                        const originalText = submitBtn.textContent;
                        submitBtn.textContent = 'Saving...';

                        const data = {
                            destination,
                            location,
                            only_hotel: onlyHotel ? 1 : 0,
                            only_tt: onlyTT ? 1 : 0,
                            hotel_tt: hotelTT ? 1 : 0,
                            from_date: fromDate,
                            to_date: toDate
                        };

                        let url = `{{ route('leads.booking-destinations.store', $lead) }}`;
                        let method = 'POST';

                        if (editingDestinationRow) {
                            const dbId = editingDestinationRow.querySelector('.editDestinationRow').dataset.id;
                            url = `{{ route('leads.booking-destinations.update', [$lead, ':id']) }}`.replace(
                                ':id', dbId);
                            method = 'PUT';
                        }

                        try {
                            const response = await fetch(url, {
                                method: method,
                                headers: {
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                        ?.content
                                },
                                body: JSON.stringify(data)
                            });

                            const result = await response.json();

                            if (response.ok) {
                                window.location.reload();
                            } else {
                                alert(result.message || 'Error occurred while saving destination');
                                submitBtn.disabled = false;
                                submitBtn.textContent = originalText;
                            }
                        } catch (error) {
                            console.error('Error saving destination:', error);
                            alert('An unexpected error occurred');
                            submitBtn.disabled = false;
                            submitBtn.textContent = originalText;
                        }
                    });

                    // Delete Handler (AJAX)
                    document.addEventListener('click', async function(e) {
                        if (e.target.closest('.removeDestinationRow')) {
                            const icon = e.target.closest('.removeDestinationRow');
                            const dbId = icon.dataset.id;

                            if (!dbId) {
                                e.target.closest('tr').remove();
                                return;
                            }

                            if (!confirm('Are you sure you want to remove this destination?')) return;

                            try {
                                const response = await fetch(
                                    `{{ route('leads.booking-destinations.destroy', [$lead, ':id']) }}`
                                    .replace(':id', dbId), {
                                        method: 'DELETE',
                                        headers: {
                                            'X-CSRF-TOKEN': document.querySelector(
                                                'meta[name="csrf-token"]')?.content,
                                            'Accept': 'application/json'
                                        }
                                    });

                                if (response.ok) {
                                    window.location.reload();
                                } else {
                                    const result = await response.json();
                                    alert(result.message || 'Error removing destination');
                                }
                            } catch (error) {
                                console.error('Error removing destination:', error);
                                alert('An unexpected error occurred');
                            }
                        }
                    });

                    // Arrival/Departure unified table management
                    @php
                        $totalTransports = $lead->bookingArrivalDepartures ? $lead->bookingArrivalDepartures->count() : 0;
                    @endphp
                    let arrivalDepartureRowIndex = {{ $totalTransports }};
                    // Track if we are editing an existing arrival/departure row
                    let editingArrivalDepartureRow = null;

                    // Function to format date for display
                    function formatDateDisplay(dateStr) {
                        if (!dateStr) return '';
                        const date = new Date(dateStr);
                        const day = String(date.getDate()).padStart(2, '0');
                        const month = String(date.getMonth() + 1).padStart(2, '0');
                        const year = date.getFullYear();
                        return `${day}/${month}/${year}`;
                    }

                    // Arrival/Departure AJAX Logic
                    let editingArrivalDepartureId = null;

                    // Reset modal for new entry
                    document.getElementById('addArrivalDepartureModal')?.addEventListener('show.bs.modal', function(e) {
                        const button = e.relatedTarget;
                        if (!button || !button.classList.contains('editArrivalDepartureRow')) {
                            document.getElementById('addArrivalDepartureForm').reset();
                            editingArrivalDepartureId = null;
                            document.getElementById('addArrivalDepartureModalLabel').textContent =
                                'Add Arrival/Departure';
                            document.getElementById('submitArrivalDepartureModal').textContent = 'Add';
                        }
                    });

                    // Edit Handler - Populate Modal
                    document.addEventListener('click', function(e) {
                        const editBtn = e.target.closest('.editArrivalDepartureRow');
                        if (editBtn) {
                            editingArrivalDepartureId = editBtn.dataset.id;
                            document.getElementById('addArrivalDepartureModalLabel').textContent =
                                'Edit Arrival/Departure';
                            document.getElementById('submitArrivalDepartureModal').textContent = 'Update';

                            // Populate modal fields from data attributes
                            document.getElementById('modalMode').value = editBtn.dataset.mode || 'By Air';
                            document.getElementById('modalInfo').value = editBtn.dataset.info || '';
                            document.getElementById('modalFromCity').value = editBtn.dataset.fromCity || '';
                            document.getElementById('modalToCity').value = editBtn.dataset.toCity || '';

                            // Handle datetime-local values (YYYY-MM-DDTHH:MM)
                            const depDate = editBtn.dataset.departureDate || '';
                            const depTime = editBtn.dataset.departureTime || '';
                            if (depDate && depTime) {
                                document.getElementById('modalDepartureAt').value = `${depDate}T${depTime}`;
                            }

                            const arrDate = editBtn.dataset.arrivalDate || '';
                            const arrTime = editBtn.dataset.arrivalTime || '';
                            if (arrDate && arrTime) {
                                document.getElementById('modalArrivalAt').value = `${arrDate}T${arrTime}`;
                            }
                        }
                    });

                    // Modal Submission (Add/Update)
                    document.getElementById('submitArrivalDepartureModal')?.addEventListener('click', async function() {
                        const submitBtn = this;
                        const mode = document.getElementById('modalMode').value;
                        const info = document.getElementById('modalInfo').value;
                        const fromCity = document.getElementById('modalFromCity').value;
                        const toCity = document.getElementById('modalToCity').value;
                        const departureAt = document.getElementById('modalDepartureAt').value;
                        const arrivalAt = document.getElementById('modalArrivalAt').value;

                        if (!mode || !fromCity || !toCity || !departureAt || !arrivalAt) {
                            alert('Please fill in all required fields');
                            return;
                        }

                        // Split datetime-local into date and time for backend
                        const depParts = departureAt.split('T');
                        const arrParts = arrivalAt.split('T');

                        const data = {
                            mode: mode,
                            info: info,
                            from_city: fromCity,
                            to_city: toCity,
                            departure_date: depParts[0],
                            departure_time: depParts[1],
                            arrival_date: arrParts[0],
                            arrival_time: arrParts[1]
                        };

                        const originalText = submitBtn.textContent;
                        submitBtn.disabled = true;
                        submitBtn.textContent = editingArrivalDepartureId ? 'Updating...' : 'Adding...';

                        try {
                            const url = editingArrivalDepartureId ?
                                `{{ route('leads.booking-arrival-departure.update', [$lead, ':id']) }}`
                                .replace(':id', editingArrivalDepartureId) :
                                `{{ route('leads.booking-arrival-departure.store', $lead) }}`;

                            const response = await fetch(url, {
                                method: editingArrivalDepartureId ? 'PUT' : 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                        ?.content,
                                    'Accept': 'application/json'
                                },
                                body: JSON.stringify(data)
                            });

                            const result = await response.json();

                            if (response.ok) {
                                window.location.reload();
                            } else {
                                alert(result.message || 'Error occurred while saving arrival/departure');
                                submitBtn.disabled = false;
                                submitBtn.textContent = originalText;
                            }
                        } catch (error) {
                            console.error('Error saving arrival/departure:', error);
                            alert('An unexpected error occurred');
                            submitBtn.disabled = false;
                            submitBtn.textContent = originalText;
                        }
                    });

                    // Delete Handler
                    document.addEventListener('click', async function(e) {
                        const deleteBtn = e.target.closest('.removeArrivalDepartureRow');
                        if (deleteBtn) {
                            const dbId = deleteBtn.dataset.id;
                            if (!dbId) {
                                deleteBtn.closest('tr').remove();
                                return;
                            }

                            if (!confirm('Are you sure you want to remove this arrival/departure entry?'))
                                return;

                            try {
                                const response = await fetch(
                                    `{{ route('leads.booking-arrival-departure.destroy', [$lead, ':id']) }}`
                                    .replace(':id', dbId), {
                                        method: 'DELETE',
                                        headers: {
                                            'X-CSRF-TOKEN': document.querySelector(
                                                'meta[name="csrf-token"]')?.content,
                                            'Accept': 'application/json'
                                        }
                                    });

                                if (response.ok) {
                                    window.location.reload();
                                } else {
                                    const result = await response.json();
                                    alert(result.message || 'Error removing entry');
                                }
                            } catch (error) {
                                console.error('Error removing arrival/departure:', error);
                                alert('An unexpected error occurred');
                            }
                        }
                    });

                    // Accommodation AJAX Logic
                    let editingAccommodationId = null;
                    let editingAccLocationValue = null;

                    // Reset modal for new entry
                    document.getElementById('addAccommodationModal')?.addEventListener('show.bs.modal', function(e) {
                        const button = e.relatedTarget;
                        if (!button || !button.classList.contains('editAccommodationRow')) {
                            document.getElementById('addAccommodationForm').reset();
                            editingAccommodationId = null;
                            editingAccLocationValue = null;
                            document.getElementById('addAccommodationModalLabel').textContent = 'Add Accommodation';
                            document.getElementById('submitAccommodationModal').textContent = 'Add';
                            document.getElementById('modalAccLocationSelect').innerHTML =
                                '<option value="">-- Select Location --</option>';
                        }
                    });

                    // Function to load locations for accommodation modal
                    function loadAccLocationsForDestination(destinationSelect) {
                        const locationSelect = document.getElementById('modalAccLocationSelect');
                        const destinationId = destinationSelect.options[destinationSelect.selectedIndex]?.getAttribute(
                            'data-destination-id');

                        if (locationSelect) {
                            locationSelect.innerHTML = '<option value="">-- Select Location --</option>';
                            if (destinationId) {
                                locationSelect.disabled = true;
                                locationSelect.innerHTML = '<option value="">Loading...</option>';
                                fetch(`/api/destinations/${destinationId}/locations`, {
                                        headers: {
                                            'Accept': 'application/json',
                                            'X-Requested-With': 'XMLHttpRequest'
                                        }
                                    })
                                    .then(response => {
                                        if (!response.ok) throw new Error('Network response was not ok');
                                        return response.json();
                                    })
                                    .then(data => {
                                        locationSelect.innerHTML = '<option value="">-- Select Location --</option>';
                                        data.forEach(loc => {
                                            const option = document.createElement('option');
                                            option.value = loc.name;
                                            option.textContent = loc.name;
                                            locationSelect.appendChild(option);
                                        });
                                        if (editingAccLocationValue) {
                                            locationSelect.value = editingAccLocationValue;
                                            // Fallback if value property didn't match (e.g. whitespace)
                                            if (locationSelect.value !== editingAccLocationValue) {
                                                Array.from(locationSelect.options).forEach(opt => {
                                                    if (opt.value.trim() === editingAccLocationValue.trim()) {
                                                        locationSelect.value = opt.value;
                                                    }
                                                });
                                            }
                                            editingAccLocationValue = null;
                                        }
                                        locationSelect.disabled = false;
                                        const submitBtn = document.getElementById('submitAccommodationModal');
                                        if (submitBtn) submitBtn.disabled = false;
                                    })
                                    .catch(error => {
                                        console.error('Error loading locations:', error);
                                        locationSelect.innerHTML = '<option value="">Error loading locations</option>';
                                        locationSelect.disabled = false;
                                        const submitBtn = document.getElementById('submitAccommodationModal');
                                        if (submitBtn) submitBtn.disabled = false;
                                    });
                            }
                        }
                    }

                    document.getElementById('modalAccDestinationSelect')?.addEventListener('change', function() {
                        loadAccLocationsForDestination(this);
                    });

                    // Edit Handler - Populate Modal
                    document.addEventListener('click', function(e) {
                        const editBtn = e.target.closest('.editAccommodationRow');
                        if (editBtn) {
                            editingAccommodationId = editBtn.dataset.accommodationId;
                            document.getElementById('addAccommodationModalLabel').textContent =
                            'Edit Accommodation';
                            document.getElementById('submitAccommodationModal').textContent = 'Update';

                            // Populate fields
                            document.getElementById('modalAccDestinationSelect').value = editBtn.dataset
                            .destination;
                            editingAccLocationValue = editBtn.dataset.location;
                            document.getElementById('modalStayAt').value = editBtn.dataset.stayAt;
                            document.getElementById('modalCheckinDate').value = editBtn.dataset.checkinDate;
                            document.getElementById('modalCheckoutDate').value = editBtn.dataset.checkoutDate;
                            document.getElementById('modalRoomType').value = editBtn.dataset.roomType;
                            document.getElementById('modalMealPlan').value = editBtn.dataset.mealPlan;

                            // Trigger location load
                            const destSelect = document.getElementById('modalAccDestinationSelect');
                            destSelect.dispatchEvent(new Event('change'));
                        }
                    });

                    // Modal Submission (Add/Update)
                    document.getElementById('submitAccommodationModal')?.addEventListener('click', async function() {
                        const submitBtn = this;
                        const data = {
                            destination: document.getElementById('modalAccDestinationSelect').value,
                            location: document.getElementById('modalAccLocationSelect').value,
                            stay_at: document.getElementById('modalStayAt').value,
                            checkin_date: document.getElementById('modalCheckinDate').value,
                            checkout_date: document.getElementById('modalCheckoutDate').value,
                            room_type: document.getElementById('modalRoomType').value,
                            meal_plan: document.getElementById('modalMealPlan').value,
                        };

                        if (!data.destination || !data.location || !data.stay_at || !data.checkin_date || !data
                            .checkout_date) {
                            alert('Please fill in all required fields');
                            return;
                        }

                        const originalText = submitBtn.textContent;
                        submitBtn.disabled = true;
                        submitBtn.textContent = editingAccommodationId ? 'Updating...' : 'Adding...';

                        try {
                            const url = editingAccommodationId ?
                                `{{ route('leads.booking-accommodations.update', [$lead, ':id']) }}`.replace(
                                    ':id', editingAccommodationId) :
                                `{{ route('leads.booking-accommodations.store', $lead) }}`;

                            const response = await fetch(url, {
                                method: editingAccommodationId ? 'PUT' : 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                        ?.content,
                                    'Accept': 'application/json'
                                },
                                body: JSON.stringify(data)
                            });

                            if (response.ok) {
                                window.location.reload();
                            } else {
                                const result = await response.json();
                                alert(result.message || 'Error occurred while saving accommodation');
                                submitBtn.disabled = false;
                                submitBtn.textContent = originalText;
                            }
                        } catch (error) {
                            console.error('Error saving accommodation:', error);
                            alert('An unexpected error occurred');
                            submitBtn.disabled = false;
                            submitBtn.textContent = originalText;
                        }
                    });

                    // Delete Handler
                    document.addEventListener('click', async function(e) {
                        const deleteBtn = e.target.closest('.removeAccommodationRow');
                        if (deleteBtn) {
                            const dbId = deleteBtn.dataset.accommodationId;
                            if (!dbId) {
                                deleteBtn.closest('tr').remove();
                                return;
                            }

                            if (!confirm('Are you sure you want to remove this accommodation?')) return;

                            try {
                                const response = await fetch(
                                    `{{ route('leads.booking-accommodations.destroy', [$lead, ':id']) }}`
                                    .replace(':id', dbId), {
                                        method: 'DELETE',
                                        headers: {
                                            'X-CSRF-TOKEN': document.querySelector(
                                                'meta[name="csrf-token"]')?.content,
                                            'Accept': 'application/json'
                                        }
                                    });

                                if (response.ok) {
                                    window.location.reload();
                                } else {
                                    const result = await response.json();
                                    alert(result.message || 'Error removing accommodation');
                                }
                            } catch (error) {
                                console.error('Error removing accommodation:', error);
                                alert('An unexpected error occurred');
                            }
                        }
                    });


                    // Itinerary AJAX Logic
                    let editingItineraryId = null;

                    // Function to add bullet points to activity textarea
                    function formatActivityWithBullets(text) {
                        if (!text || !text.trim()) return '• ';
                        // Split by line breaks and add bullet points
                        const lines = text.split(/\r?\n/);
                        const formatted = lines.map(line => {
                            const trimmed = line.trim();
                            // Remove existing bullet points if any
                            const cleaned = trimmed.replace(/^[•\-\*]\s*/, '');
                            return cleaned ? `• ${cleaned}` : '';
                        }).filter(line => line);
                        return formatted.length > 0 ? formatted.join('\n') : '• ';
                    }

                    // Function to remove bullet points (for storage)
                    function removeBulletsFromText(text) {
                        if (!text) return '';
                        return text.split(/\r?\n/).map(line => {
                            return line.replace(/^[•\-\*]\s*/, '').trim();
                        }).filter(line => line).join('\n');
                    }

                    // Handle Enter key in Activity textarea to add bullet points
                    const modalActivity = document.getElementById('modalActivity');
                    if (modalActivity) {
                        // Add bullet point on first focus if empty
                        modalActivity.addEventListener('focus', function() {
                            if (this.value.trim() === '') {
                                this.value = '• ';
                            }
                        });

                        // Handle Enter key to add bullet point on new line
                        modalActivity.addEventListener('keydown', function(e) {
                            if (e.key === 'Enter') {
                                e.preventDefault();
                                const start = this.selectionStart;
                                const end = this.selectionEnd;
                                const text = this.value;

                                // Get current line
                                const beforeCursor = text.substring(0, start);
                                const afterCursor = text.substring(end);
                                const lines = beforeCursor.split('\n');
                                const currentLine = lines[lines.length - 1];

                                // Remove bullet from current line if it's empty or just has bullet
                                let newText;
                                if (currentLine.trim() === '' || currentLine.trim() === '•') {
                                    // Remove empty bullet line and add new one
                                    const beforeLines = lines.slice(0, -1).join('\n');
                                    newText = (beforeLines ? beforeLines + '\n' : '') + '• ' + afterCursor;
                                } else {
                                    // Add new line with bullet
                                    newText = beforeCursor + '\n• ' + afterCursor;
                                }

                                this.value = newText;

                                // Set cursor position after the bullet
                                const newCursorPos = start + (newText.length - text.length);
                                this.setSelectionRange(newCursorPos, newCursorPos);
                            }
                        });

                        // Format existing text when modal opens (if it doesn't have bullets) - only for new entries
                        document.getElementById('addItineraryModal')?.addEventListener('shown.bs.modal', function(e) {
                            // Only format if this is not an edit (check if editingItineraryId is null)
                            if (!editingItineraryId) {
                                const activityText = modalActivity.value;
                                if (activityText && !activityText.includes('•')) {
                                    // Only format if there are line breaks but no bullets
                                    if (activityText.includes('\n')) {
                                        modalActivity.value = formatActivityWithBullets(activityText);
                                    } else if (activityText.trim() && !activityText.startsWith('•')) {
                                        modalActivity.value = '• ' + activityText.trim();
                                    }
                                }
                            }
                        });
                    }

                    // Reset modal for new entry
                    document.getElementById('addItineraryModal')?.addEventListener('show.bs.modal', function(e) {
                        const button = e.relatedTarget;
                        if (!button || !button.classList.contains('editItineraryRow')) {
                            document.getElementById('addItineraryForm').reset();
                            editingItineraryId = null;
                            document.getElementById('addItineraryModalLabel').textContent =
                            'Add Day-Wise Itinerary';
                            document.getElementById('submitItineraryModal').textContent = 'Add';

                            // Pre-fill Day & Date based on existing data
                            const itineraryRows = document.querySelectorAll(
                                '#itineraryTableBody .itinerary-data-row');
                            const nextDayNumber = itineraryRows.length + 1;
                            document.getElementById('modalDayDate').value = `Day ${nextDayNumber}`;

                            // Initialize with bullet point
                            if (modalActivity) {
                                modalActivity.value = '• ';
                            }
                        }
                    });

                    // Edit Handler - Populate Modal
                    document.addEventListener('click', function(e) {
                        const editBtn = e.target.closest('.editItineraryRow');
                        if (editBtn) {
                            editingItineraryId = editBtn.dataset.itineraryId;
                            document.getElementById('addItineraryModalLabel').textContent =
                                'Edit Day-Wise Itinerary';
                            document.getElementById('submitItineraryModal').textContent = 'Update';

                            // Populate fields
                            document.getElementById('modalDayDate').value = editBtn.dataset.dayDate;
                            document.getElementById('modalItineraryTime').value = editBtn.dataset.time || '';
                            document.getElementById('modalItineraryLocation').value = editBtn.dataset.location;

                            // Handle activity with list format - add bullet points for display
                            const activityText = editBtn.dataset.activity || '';
                            // Format with bullet points for the textarea
                            const formattedActivity = formatActivityWithBullets(activityText);
                            document.getElementById('modalActivity').value = formattedActivity || '• ';

                            document.getElementById('modalItineraryStayAt').value = editBtn.dataset.stayAt || '';
                            document.getElementById('modalRemarks').value = editBtn.dataset.remarks || '';
                        }
                    });

                    // Modal Submission (Add/Update)
                    document.getElementById('submitItineraryModal')?.addEventListener('click', async function() {
                        const submitBtn = this;

                        // Remove bullet points before saving
                        const activityText = document.getElementById('modalActivity').value;
                        const cleanActivityText = removeBulletsFromText(activityText);

                        const data = {
                            day_and_date: document.getElementById('modalDayDate').value,
                            time: document.getElementById('modalItineraryTime').value,
                            location: document.getElementById('modalItineraryLocation').value,
                            activity_tour_description: cleanActivityText,
                            stay_at: document.getElementById('modalItineraryStayAt').value,
                            remarks: document.getElementById('modalRemarks').value,
                        };

                        if (!data.day_and_date || !data.location || !data.activity_tour_description) {
                            alert('Please fill in all required fields');
                            return;
                        }

                        const originalText = submitBtn.textContent;
                        submitBtn.disabled = true;
                        submitBtn.textContent = editingItineraryId ? 'Updating...' : 'Adding...';

                        try {
                            const url = editingItineraryId ?
                                `{{ route('leads.booking-itineraries.update', [$lead, ':id']) }}`.replace(
                                    ':id', editingItineraryId) :
                                `{{ route('leads.booking-itineraries.store', $lead) }}`;

                            const response = await fetch(url, {
                                method: editingItineraryId ? 'PUT' : 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                        ?.content,
                                    'Accept': 'application/json'
                                },
                                body: JSON.stringify(data)
                            });

                            if (response.ok) {
                                window.location.reload();
                            } else {
                                const result = await response.json();
                                alert(result.message || 'Error occurred while saving itinerary');
                                submitBtn.disabled = false;
                                submitBtn.textContent = originalText;
                            }
                        } catch (error) {
                            console.error('Error saving itinerary:', error);
                            alert('An unexpected error occurred');
                            submitBtn.disabled = false;
                            submitBtn.textContent = originalText;
                        }
                    });

                    // Delete Handler
                    document.addEventListener('click', async function(e) {
                        const deleteBtn = e.target.closest('.removeItineraryRow');
                        if (deleteBtn) {
                            const dbId = deleteBtn.dataset.itineraryId;
                            if (!dbId) {
                                deleteBtn.closest('tr').remove();
                                return;
                            }

                            if (!confirm('Are you sure you want to remove this itinerary entry?')) return;

                            try {
                                const response = await fetch(
                                    `{{ route('leads.booking-itineraries.destroy', [$lead, ':id']) }}`
                                    .replace(':id', dbId), {
                                        method: 'DELETE',
                                        headers: {
                                            'X-CSRF-TOKEN': document.querySelector(
                                                'meta[name="csrf-token"]')?.content,
                                            'Accept': 'application/json'
                                        }
                                    });

                                if (response.ok) {
                                    window.location.reload();
                                } else {
                                    const result = await response.json();
                                    alert(result.message || 'Error removing itinerary entry');
                                }
                            } catch (error) {
                                console.error('Error removing itinerary:', error);
                                alert('An unexpected error occurred');
                            }
                        }
                    });

                    // Function to check if any destination has Only TT or Hotel + TT selected
                    function checkItineraryVisibility() {
                        const destinationTableBody = document.getElementById('destinationTableBody');
                        const itinerarySection = document.getElementById('dayWiseItinerarySection');

                        if (!destinationTableBody || !itinerarySection) {
                            return;
                        }

                        let shouldShow = false;
                        const destinationRows = destinationTableBody.querySelectorAll(
                            '.destination-data-row, tr[data-row-index]');

                        destinationRows.forEach(row => {
                            const cells = row.querySelectorAll('td');
                            if (cells.length >= 5) {
                                // Column 2 is Only Hotel, Column 3 is Only TT, Column 4 is Hotel + TT (0-indexed)
                                // Check for check icons or checked state
                                const onlyTTCell = cells[3];
                                const hotelTTCell = cells[4];

                                // Check if there's a check icon or if the cell contains checked content
                                const onlyTTIcon = onlyTTCell?.querySelector(
                                    'i[data-feather="check"], .feather-check, svg.feather-check');
                                const hotelTTIcon = hotelTTCell?.querySelector(
                                    'i[data-feather="check"], .feather-check, svg.feather-check');

                                // Also check for text content indicating checked state or any non-empty content
                                const onlyTTText = onlyTTCell?.textContent?.trim();
                                const hotelTTText = hotelTTCell?.textContent?.trim();

                                // Check if cell has any indication of being selected (icon, checkmark, or non-empty)
                                if (onlyTTIcon || hotelTTIcon) {
                                    shouldShow = true;
                                } else if (onlyTTText && onlyTTText !== '-' && onlyTTText.length > 0) {
                                    // If there's any content in the cell (not just empty or dash), consider it selected
                                    shouldShow = true;
                                } else if (hotelTTText && hotelTTText !== '-' && hotelTTText.length > 0) {
                                    shouldShow = true;
                                }
                            }
                        });

                        // Also check if there are existing itinerary entries - if so, always show the section
                        const itineraryTbody = document.getElementById('itineraryTableBody');
                        if (itineraryTbody) {
                            const existingItineraryRows = itineraryTbody.querySelectorAll('tr[data-row-index]');
                            if (existingItineraryRows.length > 0) {
                                shouldShow = true;
                            }
                        }

                        // Show/hide itinerary section
                        if (shouldShow) {
                            itinerarySection.style.display = '';
                            // Icons will be handled by init.js or our accommodation icon handler
                        } else {
                            itinerarySection.style.display = 'none';
                        }
                    }

                    // Check itinerary visibility when service type checkboxes change in input row
                    const inputServiceTypeCheckboxes = document.querySelectorAll(
                        '.only-hotel-input, .only-tt-input, .hotel-tt-input');
                    inputServiceTypeCheckboxes.forEach(checkbox => {
                        checkbox.addEventListener('change', function() {
                            // Check visibility after adding a destination, not on checkbox change
                            // This is handled in addDestinationFromInput function
                        });
                    });

                    // Icons are now directly embedded as SVG in the template, so no JavaScript replacement needed
                    // This eliminates all feather icon replacement conflicts and delays

                    // Check itinerary visibility on page load
                    checkItineraryVisibility();

                    // Add default row if itinerary table is empty and section is visible
                    const itineraryTbody = document.getElementById('itineraryTableBody');
                    const itinerarySection = document.getElementById('dayWiseItinerarySection');
                    if (itineraryTbody && itinerarySection && itinerarySection.style.display !== 'none') {
                        const hasItineraryEmptyMessage = itineraryTbody.querySelector('.empty-row-message');
                        const hasItineraryExistingRows = itineraryTbody.querySelectorAll('tr[data-row-index]').length > 0;

                        if (hasItineraryEmptyMessage && !hasItineraryExistingRows) {
                            const emptyRow = itineraryTbody.querySelector('.empty-row-message');
                            if (emptyRow) {
                                emptyRow.remove();
                            }
                            addItineraryRow();
                        }
                    }

                    // Post Sales: handle edit payment button to populate modal
                    document.addEventListener('click', function(e) {
                        const editBtn = e.target.closest('.post-sales-edit-payment-btn');
                        if (!editBtn) return;

                        const form = document.getElementById('postSalesPaymentForm');
                        if (!form) return;

                        const paymentId = editBtn.getAttribute('data-payment-id');
                        const amount = editBtn.getAttribute('data-amount') || '';
                        const method = editBtn.getAttribute('data-method') || 'cash';
                        const paymentDate = editBtn.getAttribute('data-payment-date') || '';
                        const dueDate = editBtn.getAttribute('data-due-date') || '';
                        const reference = editBtn.getAttribute('data-reference') || '';
                        const status = editBtn.getAttribute('data-status') || 'pending';

                        // Update form action to use update route
                        form.action = '{{ route('leads.payments.update', [$lead->id, ':id']) }}'.replace(':id',
                            paymentId);
                        const methodInput = document.getElementById('postSalesPaymentFormMethod');
                        if (methodInput) {
                            methodInput.value = 'PUT';
                        }

                        form.querySelector('input[name=\"amount\"]').value = amount;
                        form.querySelector('select[name=\"method\"]').value = method;
                        form.querySelector('input[name=\"payment_date\"]').value = paymentDate;
                        form.querySelector('input[name=\"due_date\"]').value = dueDate;
                        form.querySelector('input[name=\"reference\"]').value = reference;
                        const statusSelect = form.querySelector(
                        'select[class*="form-select"]'); // Use class selector as name might be status or status_display
                        if (statusSelect) {
                            statusSelect.value = status;
                        }

                        // Update hidden status input if it exists (for Post Sales)
                        const hiddenStatus = document.getElementById('hiddenPaymentStatus');
                        if (hiddenStatus) {
                            hiddenStatus.value = status;
                        }

                        const modalTitle = document.getElementById('postSalesAddPaymentModalLabel');
                        if (modalTitle) {
                            modalTitle.textContent = 'Edit Customer Payment';
                        }
                    });

                    // Reset Post Sales payment modal on hide (back to Add mode)
                    document.getElementById('postSalesAddPaymentModal')?.addEventListener('hidden.bs.modal', function() {
                        const form = document.getElementById('postSalesPaymentForm');
                        if (!form) return;

                        form.action = '{{ route('leads.payments.store', $lead->id) }}';
                        const methodInput = document.getElementById('postSalesPaymentFormMethod');
                        if (methodInput) {
                            methodInput.value = 'POST';
                        }
                        form.reset();
                        const modalTitle = document.getElementById('postSalesAddPaymentModalLabel');
                        if (modalTitle) {
                            modalTitle.textContent = 'Add Customer Payment';
                        }

                        // Reset hidden status to pending
                        const hiddenStatus = document.getElementById('hiddenPaymentStatus');
                        if (hiddenStatus) {
                            hiddenStatus.value = 'pending';
                        }
                    });

                    // Traveller Document Details: toggle passport extra fields
                    const travellerDocTypeSelect = document.getElementById('travellerDocumentType');
                    const passportExtraFields = document.getElementById('passportExtraFields');
                    const dobFieldContainer = document.getElementById('dobFieldContainer');

                    if (travellerDocTypeSelect && passportExtraFields) {
                        const togglePassportFields = () => {
                            if (travellerDocTypeSelect.value === 'passport') {
                                passportExtraFields.style.display = '';
                            } else {
                                passportExtraFields.style.display = 'none';
                            }
                        };
                        travellerDocTypeSelect.addEventListener('change', togglePassportFields);
                        // Initialize on load
                        togglePassportFields();
                    }

                    // Traveller Document Details: toggle DOB field (hide for visa, marriage_certificate, photos, insurance)
                    if (travellerDocTypeSelect && dobFieldContainer) {
                        const toggleDobField = () => {
                            const docType = travellerDocTypeSelect.value;
                            const excludedTypes = ['visa', 'marriage_certificate', 'photos', 'insurance'];

                            if (docType && !excludedTypes.includes(docType)) {
                                dobFieldContainer.style.display = '';
                            } else {
                                dobFieldContainer.style.display = 'none';
                                // Clear DOB value when hidden
                                const dobField = document.getElementById('travellerDobField');
                                if (dobField) {
                                    dobField.value = '';
                                }
                            }
                        };
                        travellerDocTypeSelect.addEventListener('change', toggleDobField);
                        // Initialize on load
                        toggleDobField();
                    }

                    // Traveller Document Details: hide / show Nationality/DOB/Place/Expiry columns if any Passport rows exist
                    function updateTravellerDocColumnsVisibility() {
                        const travellerDocTable = document.getElementById('travellerDocumentTable');
                        if (!travellerDocTable) return;

                        const headerCells = travellerDocTable.querySelectorAll('thead tr th');
                        const bodyRows = travellerDocTable.querySelectorAll('tbody tr');

                        let hasPassport = false;
                        bodyRows.forEach(row => {
                            const rowType = row.getAttribute('data-row-type') || '';
                            const docTypeCell = row.children[3]; // 0-based index: 3 = Doc Type column
                            if (rowType === 'passport' || (docTypeCell && /passport/i.test(docTypeCell
                                    .textContent || ''))) {
                                hasPassport = true;
                            }
                        });

                        // Column indices: 0=Sr.No, 1=Full Name, 2=Contact No, 3=Doc Type, 4=Doc No, 5=Nationality, 6=DOB, 7=Place of Issue, 8=Expiry
                        const colsToToggle = [5, 6, 7, 8]; // Nationality, DOB, Place of Issue, Date of Expiry
                        colsToToggle.forEach(idx => {
                            if (headerCells[idx]) {
                                headerCells[idx].style.display = hasPassport ? '' : 'none';
                            }
                            bodyRows.forEach(row => {
                                if (row.children[idx]) {
                                    row.children[idx].style.display = hasPassport ? '' : 'none';
                                }
                            });
                        });
                    }

                    updateTravellerDocColumnsVisibility();

                    // Traveller Document Details: reset form when clicking "Add"
                    const openTravellerDocBtn = document.getElementById('openTravellerDocModalBtn');
                    if (openTravellerDocBtn) {
                        openTravellerDocBtn.addEventListener('click', function() {
                            const form = document.getElementById('travellerDocumentForm');
                            if (!form) return;
                            form.reset();
                            // Clear the document ID to ensure a new record is created
                            const documentIdField = document.getElementById('travellerDocumentId');
                            if (documentIdField) {
                                documentIdField.value = '';
                            }
                            const docTypeSelect = form.querySelector('select[name=\"document_type\"]');
                            if (docTypeSelect) {
                                docTypeSelect.value = '';
                                const changeEvent = new Event('change');
                                docTypeSelect.dispatchEvent(changeEvent);
                            }
                        });
                    }

                    // Traveller Document Details: handle delete via AJAX to avoid nested form issues
                    document.addEventListener('click', function(e) {
                        const deleteIcon = e.target.closest('.traveller-doc-delete');
                        if (!deleteIcon) return;

                        const url = deleteIcon.getAttribute('data-delete-url');
                        if (!url) return;

                        if (!confirm('Are you sure you want to delete this traveller document?')) {
                            return;
                        }

                        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

                        fetch(url, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': token || '',
                                    'Accept': 'application/json',
                                },
                            })
                            .then(() => {
                                // Reload to reflect changes
                                window.location.reload();
                            })
                            .catch(() => {
                                window.location.reload();
                            });
                    });

                    // Traveller Document Details: handle edit icon to populate and open modal
                    document.addEventListener('click', function(e) {
                        // Use closest() directly so clicks on SVG/icon also work
                        const editIcon = e.target.closest('.traveller-doc-edit');
                        if (!editIcon) return;

                        const form = document.getElementById('travellerDocumentForm');
                        if (!form) return;

                        // Set the document ID for update
                        const documentIdField = document.getElementById('travellerDocumentId');
                        if (documentIdField) {
                            documentIdField.value = editIcon.getAttribute('data-document-id') || '';
                        }

                        // Fill basic fields
                        const salutationSelect = form.querySelector('select[name=\"salutation\"]');
                        if (salutationSelect) {
                            salutationSelect.value = editIcon.getAttribute('data-salutation') || '';
                        }
                        form.querySelector('input[name=\"first_name\"]').value = editIcon.getAttribute(
                            'data-first-name') || '';
                        form.querySelector('input[name=\"last_name\"]').value = editIcon.getAttribute(
                            'data-last-name') || '';
                        form.querySelector('input[name=\"contact_no\"]').value = editIcon.getAttribute(
                            'data-contact-no') || '';

                        const docTypeSelect = form.querySelector('select[name=\"document_type\"]');
                        const statusSelect = form.querySelector('select[name=\"status\"]');

                        const docType = editIcon.getAttribute('data-doc-type') || '';
                        if (docTypeSelect) {
                            docTypeSelect.value = docType;
                            const changeEvent = new Event('change');
                            docTypeSelect.dispatchEvent(changeEvent);
                        }

                        if (statusSelect) {
                            const status = (editIcon.getAttribute('data-status') || '').toLowerCase();
                            statusSelect.value = status;
                        }

                        form.querySelector('input[name=\"document_details\"]').value = editIcon.getAttribute(
                            'data-doc-no') || '';
                        form.querySelector('input[name=\"nationality\"]').value = editIcon.getAttribute(
                            'data-nationality') || '';
                        // Populate DOB in main form field
                        const dobField = document.getElementById('travellerDobField');
                        if (dobField) {
                            dobField.value = editIcon.getAttribute('data-dob') || '';
                        }
                        form.querySelector('input[name=\"place_of_issue\"]').value = editIcon.getAttribute(
                            'data-place-of-issue') || '';
                        form.querySelector('input[name=\"date_of_expiry\"]').value = editIcon.getAttribute(
                            'data-date-of-expiry') || '';
                        form.querySelector('textarea[name=\"remark\"]').value = editIcon.getAttribute(
                            'data-remark') || '';

                        // Open modal
                        const travellerModalEl = document.getElementById('travellerDocumentModal');
                        if (travellerModalEl && typeof bootstrap !== 'undefined') {
                            const modal = bootstrap.Modal.getInstance(travellerModalEl) || new bootstrap.Modal(
                                travellerModalEl);
                            modal.show();
                        } else if (openTravellerDocBtn) {
                            // Fallback: trigger the Add button which is wired with data-bs-toggle
                            openTravellerDocBtn.click();
                        }
                    });

                    // Handle form submission (Direct submit enabled)
                    const bookingFileForm = document.getElementById('bookingFileForm');
                    if (bookingFileForm) {
                        // The form will now submit normally
                        console.log('Direct submission enabled for bookingFileForm');
                    }

                    // Handle Sales Cost Update Button
                    const updateSalesCostBtn = document.getElementById('updateSalesCostBtn');
                    const salesCostInput = document.getElementById('salesCostInput');

                    if (updateSalesCostBtn && salesCostInput) {
                        updateSalesCostBtn.addEventListener('click', async function() {
                            const salesCost = parseFloat(salesCostInput.value);

                            if (isNaN(salesCost) || salesCost < 0) {
                                alert('Please enter a valid sales cost (must be 0 or greater)');
                                return;
                            }

                            const originalText = updateSalesCostBtn.textContent;
                            updateSalesCostBtn.disabled = true;
                            updateSalesCostBtn.textContent = 'Updating...';

                            try {
                                const response = await fetch(
                                '{{ route('leads.update-sales-cost', $lead) }}', {
                                    method: 'PUT',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector(
                                            'meta[name="csrf-token"]')?.content,
                                        'Accept': 'application/json'
                                    },
                                    body: JSON.stringify({
                                        selling_price: salesCost
                                    })
                                });

                                const result = await response.json();

                                if (response.ok) {
                                    alert(result.message || 'Sales cost updated successfully!');
                                    // Optionally reload the page to reflect changes
                                    window.location.reload();
                                } else {
                                    alert(result.message || 'Error updating sales cost');
                                    updateSalesCostBtn.disabled = false;
                                    updateSalesCostBtn.textContent = originalText;
                                }
                            } catch (error) {
                                console.error('Error updating sales cost:', error);
                                alert('An unexpected error occurred while updating sales cost');
                                updateSalesCostBtn.disabled = false;
                                updateSalesCostBtn.textContent = originalText;
                            }
                        });
                    }
                });

                // Vendor Payment handlers (Ops only)
                @if ($isOpsDept ?? false)
                    let currentEditVendorPaymentId = null;

                    // Reset vendor payment modal
                    function resetVendorPaymentModal() {
                        document.getElementById('addVendorPaymentForm').reset();
                        document.getElementById('vendorPaymentId').value = '';
                        document.getElementById('addVendorPaymentModalLabel').textContent = 'Add Vendor Payment';
                        currentEditVendorPaymentId = null;
                    }

                    // Handle modal show event
                    const addVendorPaymentModal = document.getElementById('addVendorPaymentModal');
                    if (addVendorPaymentModal) {
                        addVendorPaymentModal.addEventListener('show.bs.modal', function() {
                            resetVendorPaymentModal();
                        });
                    }

                    // Handle edit vendor payment button click
                    document.addEventListener('click', function(e) {
                        if (e.target.closest('.edit-vendor-payment-btn')) {
                            const btn = e.target.closest('.edit-vendor-payment-btn');
                            const vendorPaymentId = btn.dataset.vendorPaymentId;
                            const row = btn.closest('tr');

                            currentEditVendorPaymentId = vendorPaymentId;
                            document.getElementById('vendorPaymentId').value = vendorPaymentId;
                            document.getElementById('addVendorPaymentModalLabel').textContent = 'Edit Vendor Payment';

                            // Populate form from data attributes
                            document.getElementById('modalVendorCode').value = row.dataset.vendorCode || '';
                            document.getElementById('modalBookingType').value = row.dataset.bookingType || '';
                            document.getElementById('modalLocation').value = row.dataset.location || '';
                            document.getElementById('modalPurchaseCost').value = row.dataset.purchaseCost || '';
                            document.getElementById('modalDueDate').value = row.dataset.dueDate || '';
                            document.getElementById('modalStatus').value = row.dataset.status || 'Pending';
                        }
                    });


                    // Handle delete vendor payment button click
                    document.addEventListener('click', function(e) {
                        if (e.target.closest('.delete-vendor-payment-btn')) {
                            if (!confirm('Are you sure you want to delete this vendor payment?')) {
                                return;
                            }
                            const btn = e.target.closest('.delete-vendor-payment-btn');
                            const vendorPaymentId = btn.dataset.vendorPaymentId;
                            const leadId = {{ $lead->id }};

                            fetch(`/bookings/${leadId}/vendor-payment/${vendorPaymentId}`, {
                                    method: 'DELETE',
                                    headers: {
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                            'content'),
                                        'Accept': 'application/json',
                                    }
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        const row = btn.closest('tr');
                                        row.remove();
                                        // Check if table is empty
                                        const tbody = document.getElementById('vendorPaymentsTableBody');
                                        if (tbody && tbody.querySelectorAll('tr').length === 0) {
                                            tbody.innerHTML =
                                                '<tr><td colspan="11" class="text-center text-muted py-4">No vendor payments found</td></tr>';
                                        }
                                    } else {
                                        alert(data.message || 'Failed to delete vendor payment');
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    alert('An error occurred while deleting vendor payment');
                                });
                        }
                    });

                    // Handle vendor payment form submission
                    const submitVendorPaymentBtn = document.getElementById('submitVendorPaymentModal');
                    if (submitVendorPaymentBtn) {
                        submitVendorPaymentBtn.addEventListener('click', function() {
                            const form = document.getElementById('addVendorPaymentForm');
                            const formData = new FormData(form);
                            const vendorPaymentId = document.getElementById('vendorPaymentId').value;
                            const leadId = {{ $lead->id }};

                            let url = `/bookings/${leadId}/vendor-payment`;
                            let method = 'POST';

                            if (vendorPaymentId) {
                                url = `/bookings/${leadId}/vendor-payment/${vendorPaymentId}`;
                                method = 'PUT';
                                formData.append('_method', 'PUT');
                            }

                            fetch(url, {
                                    method: method,
                                    headers: {
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                            'content'),
                                        'Accept': 'application/json',
                                    },
                                    body: formData
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        // Close modal
                                        const modal = bootstrap.Modal.getInstance(addVendorPaymentModal);
                                        if (modal) {
                                            modal.hide();
                                        }
                                        // Reload page to show updated data
                                        window.location.reload();
                                    } else {
                                        alert(data.message || 'Failed to save vendor payment');
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    alert('An error occurred while saving vendor payment');
                                });
                        });
                    }
                @endif



                // Handle delete customer payment button click - outside ready block for better event delegation
                $(document).on('click', '.delete-customer-payment-btn', function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    const deleteBtn = $(this);
                    const paymentId = deleteBtn.data('payment-id');

                    if (!paymentId) {
                        console.error('Payment ID not found');
                        alert('Error: Payment ID not found');
                        return false;
                    }

                    if (!confirm('Are you sure you want to delete this payment?')) {
                        return false;
                    }

                    const leadId = {{ $lead->id }};
                    const url = `/leads/${leadId}/payments/${paymentId}`;

                    $.ajax({
                        url: url,
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            'Accept': 'application/json',
                        },
                        success: function(data) {
                            if (data.success) {
                                deleteBtn.closest('tr').remove();
                                // Check if table is empty
                                const tbody = $('#customerPaymentsTable tbody');
                                if (tbody.find('tr').length === 0) {
                                    tbody.html(
                                        '<tr><td colspan="7" class="text-center text-muted py-3">No customer payments recorded</td></tr>'
                                    );
                                }
                                // Reload page to refresh payment state
                                window.location.reload();
                            } else {
                                alert(data.message || 'Failed to delete payment');
                            }
                        },
                        error: function(xhr) {
                            console.error('Delete error:', xhr);
                            let errorMsg = 'An error occurred while deleting payment';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMsg = xhr.responseJSON.message;
                            } else if (xhr.status === 404) {
                                errorMsg = 'Payment not found';
                            } else if (xhr.status === 403) {
                                errorMsg = 'You do not have permission to delete this payment';
                            } else if (xhr.status === 500) {
                                errorMsg = 'Server error. Please try again.';
                            }
                            alert(errorMsg);
                        }
                    });

                    return false;
                });
            </script>
        @endpush
    @endsection
