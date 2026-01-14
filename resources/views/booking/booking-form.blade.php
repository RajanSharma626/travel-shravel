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
                                                @if ($isViewOnly)
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
                                                    <input type="number" name="selling_price"
                                                        value="{{ old('selling_price', $lead->selling_price ?? 0) }}"
                                                        class="form-control form-control-sm" step="0.01"
                                                        min="0" placeholder="0.00">
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
                                                                                <input type="hidden"
                                                                                    name="booking_destinations[{{ $index }}][id]"
                                                                                    value="{{ $bd->id }}">
                                                                                <input type="hidden"
                                                                                    name="booking_destinations[{{ $index }}][destination]"
                                                                                    value="{{ $bd->destination }}">
                                                                                <input type="hidden"
                                                                                    name="booking_destinations[{{ $index }}][location]"
                                                                                    value="{{ $bd->location }}">
                                                                                <input type="hidden"
                                                                                    name="booking_destinations[{{ $index }}][only_hotel]"
                                                                                    value="{{ $bd->only_hotel ? '1' : '0' }}">
                                                                                <input type="hidden"
                                                                                    name="booking_destinations[{{ $index }}][only_tt]"
                                                                                    value="{{ $bd->only_tt ? '1' : '0' }}">
                                                                                <input type="hidden"
                                                                                    name="booking_destinations[{{ $index }}][hotel_tt]"
                                                                                    value="{{ $bd->hotel_tt ? '1' : '0' }}">
                                                                                <input type="hidden"
                                                                                    name="booking_destinations[{{ $index }}][from_date]"
                                                                                    value="{{ $bd->from_date ? $bd->from_date->format('Y-m-d') : '' }}">
                                                                                <input type="hidden"
                                                                                    name="booking_destinations[{{ $index }}][to_date]"
                                                                                    value="{{ $bd->to_date ? $bd->to_date->format('Y-m-d') : '' }}">
                                                                                <i data-feather="edit"
                                                                                    class="editDestinationRow"
                                                                                    data-destination-id="{{ $bd->id }}"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#addDestinationModal"
                                                                                    style="width: 16px; height: 16px; color: #0d6efd; cursor: pointer; margin-right: 8px;"></i>
                                                                                <i data-feather="trash-2"
                                                                                    class="removeDestinationRow"
                                                                                    style="width: 16px; height: 16px; color: #dc3545; cursor: pointer;"></i>
                                                                            @endif
                                                                        </td>
                                                                    @endif
                                                                </tr>
                                                            @endforeach
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
                                                                                <input type="hidden"
                                                                                    name="arrival_departure[{{ $index }}][id]"
                                                                                    value="{{ $transport->id }}">
                                                                                <input type="hidden"
                                                                                    name="arrival_departure[{{ $index }}][mode]"
                                                                                    value="{{ $transport->mode }}">
                                                                                <input type="hidden"
                                                                                    name="arrival_departure[{{ $index }}][info]"
                                                                                    value="{{ $transport->info }}">
                                                                                <input type="hidden"
                                                                                    name="arrival_departure[{{ $index }}][from_city]"
                                                                                    value="{{ $transport->from_city }}">
                                                                                <input type="hidden"
                                                                                    name="arrival_departure[{{ $index }}][to_city]"
                                                                                    value="{{ $transport->to_city ?? '' }}">
                                                                                <input type="hidden"
                                                                                    name="arrival_departure[{{ $index }}][departure_date]"
                                                                                    value="{{ $transport->departure_date ? ($transport->departure_date instanceof \DateTime ? $transport->departure_date->format('Y-m-d') : $transport->departure_date) : '' }}">
                                                                                <input type="hidden"
                                                                                    name="arrival_departure[{{ $index }}][departure_time]"
                                                                                    value="{{ $transport->departure_time ? substr($transport->departure_time, 0, 5) : '' }}">
                                                                                <input type="hidden"
                                                                                    name="arrival_departure[{{ $index }}][arrival_date]"
                                                                                    value="{{ $transport->arrival_date ? ($transport->arrival_date instanceof \DateTime ? $transport->arrival_date->format('Y-m-d') : $transport->arrival_date) : '' }}">
                                                                                <input type="hidden"
                                                                                    name="arrival_departure[{{ $index }}][arrival_time]"
                                                                                    value="{{ $transport->arrival_time ? substr($transport->arrival_time, 0, 5) : '' }}">
                                                                                <i data-feather="edit"
                                                                                    class="editArrivalDepartureRow"
                                                                                    data-transport-id="{{ $transport->id }}"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#addArrivalDepartureModal"
                                                                                    style="width: 16px; height: 16px; color: #0d6efd; cursor: pointer; margin-right: 8px;"></i>
                                                                                <i data-feather="trash-2"
                                                                                    class="removeArrivalDepartureRow"
                                                                                    style="width: 16px; height: 16px; color: #dc3545; cursor: pointer;"></i>
                                                                            @endif
                                                                        </td>
                                                                    @endif
                                                                </tr>
                                                            @endforeach
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
                                                            <th style="width: 12%;">Check-in (Date)</th>
                                                            <th style="width: 12%;">Check-out (Date)</th>
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
                                                                                <input type="hidden"
                                                                                    name="booking_accommodations[{{ $index }}][id]"
                                                                                    value="{{ $ba->id }}">
                                                                                <input type="hidden"
                                                                                    name="booking_accommodations[{{ $index }}][destination]"
                                                                                    value="{{ $ba->destination }}">
                                                                                <input type="hidden"
                                                                                    name="booking_accommodations[{{ $index }}][location]"
                                                                                    value="{{ $ba->location }}">
                                                                                <input type="hidden"
                                                                                    name="booking_accommodations[{{ $index }}][stay_at]"
                                                                                    value="{{ $ba->stay_at }}">
                                                                                <input type="hidden"
                                                                                    name="booking_accommodations[{{ $index }}][checkin_date]"
                                                                                    value="{{ $ba->checkin_date ? $ba->checkin_date->format('Y-m-d') : '' }}">
                                                                                <input type="hidden"
                                                                                    name="booking_accommodations[{{ $index }}][checkout_date]"
                                                                                    value="{{ $ba->checkout_date ? $ba->checkout_date->format('Y-m-d') : '' }}">
                                                                                <input type="hidden"
                                                                                    name="booking_accommodations[{{ $index }}][room_type]"
                                                                                    value="{{ $ba->room_type }}">
                                                                                <input type="hidden"
                                                                                    name="booking_accommodations[{{ $index }}][meal_plan]"
                                                                                    value="{{ $ba->meal_plan }}">
                                                                                <i data-feather="edit"
                                                                                    class="editAccommodationRow"
                                                                                    data-accommodation-id="{{ $ba->id }}"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#addAccommodationModal"
                                                                                    style="width: 16px; height: 16px; color: #0d6efd; cursor: pointer; margin-right: 8px;"></i>
                                                                                <i data-feather="trash-2"
                                                                                    class="removeAccommodationRow"
                                                                                    style="width: 16px; height: 16px; color: #dc3545; cursor: pointer;"></i>
                                                                            @endif
                                                                        </td>
                                                                    @endif
                                                                </tr>
                                                            @endforeach
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
                                                                    <td>{{ $bi->activity_tour_description }}</td>
                                                                    <td>{{ $bi->stay_at }}</td>
                                                                    <td>{{ $bi->remarks }}</td>
                                                                    @if (!($isViewOnly && ($isOpsDept || ($isPostSales ?? false))))
                                                                        <td class="text-center">
                                                                            @if (!$isViewOnly)
                                                                                <input type="hidden"
                                                                                    name="booking_itineraries[{{ $index }}][id]"
                                                                                    value="{{ $bi->id }}">
                                                                                <input type="hidden"
                                                                                    name="booking_itineraries[{{ $index }}][day_and_date]"
                                                                                    value="{{ $bi->day_and_date }}">
                                                                                <input type="hidden"
                                                                                    name="booking_itineraries[{{ $index }}][time]"
                                                                                    value="{{ $bi->time ? substr($bi->time, 0, 5) : '' }}">
                                                                                <input type="hidden"
                                                                                    name="booking_itineraries[{{ $index }}][location]"
                                                                                    value="{{ $bi->location }}">
                                                                                <input type="hidden"
                                                                                    name="booking_itineraries[{{ $index }}][activity_tour_description]"
                                                                                    value="{{ $bi->activity_tour_description }}">
                                                                                <input type="hidden"
                                                                                    name="booking_itineraries[{{ $index }}][stay_at]"
                                                                                    value="{{ $bi->stay_at }}">
                                                                                <input type="hidden"
                                                                                    name="booking_itineraries[{{ $index }}][remarks]"
                                                                                    value="{{ $bi->remarks }}">
                                                                                <i data-feather="edit"
                                                                                    class="editItineraryRow"
                                                                                    data-itinerary-id="{{ $bi->id }}"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#addItineraryModal"
                                                                                    style="width: 16px; height: 16px; color: #0d6efd; cursor: pointer; margin-right: 8px;"></i>
                                                                                <i data-feather="trash-2"
                                                                                    class="removeItineraryRow"
                                                                                    style="width: 16px; height: 16px; color: #dc3545; cursor: pointer;"></i>
                                                                            @endif
                                                                        </td>
                                                                    @endif
                                                                </tr>
                                                            @endforeach
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Traveller Document Details (Post Sales Only) -->
                                    @if ($isPostSales ?? false)
                                        <div class="mb-4 border rounded-3 p-3">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h6 class="text-uppercase text-muted small fw-semibold mb-0">
                                                    <i data-feather="clipboard" class="me-1"
                                                        style="width: 14px; height: 14px;"></i>
                                                    Traveller Document Details
                                                </h6>
                                                <button type="button" id="openTravellerDocModalBtn"
                                                    class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#travellerDocumentModal">
                                                    <i data-feather="plus" style="width: 14px; height: 14px;"></i>
                                                    Add
                                                </button>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-sm mb-0"
                                                    id="travellerDocumentTable">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th style="width: 5%;">Sr. No.</th>
                                                            <th style="width: 8%;">Salutation</th>
                                                            <th style="width: 12%;">First Name</th>
                                                            <th style="width: 12%;">Last Name</th>
                                                            <th style="width: 15%;">Doc Type</th>
                                                            <th style="width: 10%;">Status</th>
                                                            <th style="width: 18%;">Doc No.</th>
                                                            <th style="width: 10%;">Nationality</th>
                                                            <th style="width: 8%;">DOB</th>
                                                            <th style="width: 10%;">Place of Issue</th>
                                                            <th style="width: 10%;">Expiry</th>
                                                            <th style="width: 12%;">Remark</th>
                                                            <th style="width: 8%;" class="text-center">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="travellerDocumentTableBody">
                                                        @php
                                                            $travellerDocs = $lead->travellerDocuments ?? collect();
                                                        @endphp
                                                        @forelse($travellerDocs as $index => $doc)
                                                            <tr data-row-type="{{ $doc->doc_type }}">
                                                                <td>{{ $index + 1 }}</td>
                                                                <td>{{ $doc->salutation ?? '-' }}</td>
                                                                <td>{{ $doc->first_name }}</td>
                                                                <td>{{ $doc->last_name }}</td>
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
                                                                <td>{{ $doc->doc_no }}</td>
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
                                                                <td class="text-center text-nowrap">
                                                                    <button type="button"
                                                                        class="btn btn-link p-0 me-1 traveller-doc-edit"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#travellerDocumentModal"
                                                                        data-document-id="{{ $doc->id }}"
                                                                        data-salutation="{{ $doc->salutation ?? '' }}"
                                                                        data-first-name="{{ $doc->first_name }}"
                                                                        data-last-name="{{ $doc->last_name }}"
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
                                                            </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="11" class="text-center text-muted py-3">
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
                                                                @if (!($isViewOnly && ($isOpsDept || ($isPostSales ?? false))))
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
                                                                        @if (!($isViewOnly && ($isOpsDept || ($isPostSales ?? false))))
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
                                            <div class="d-flex justify-content-end gap-2 mb-4">
                                                <a href="{{ $backUrl ?? route('bookings.index') }}"
                                                    class="btn btn-light border">Cancel</a>
                                                <button type="submit" class="btn btn-primary">Save Booking File</button>
                                            </div>
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
                                <h6 class="text-uppercase text-muted small fw-semibold mb-3">
                                    <i data-feather="users" class="me-1" style="width: 14px; height: 14px;"></i>
                                    Department Assignee
                                </h6>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Sales</label>
                                        <select name="reassigned_employee_id" class="form-select form-select-sm">
                                            <option value="">-- Select --</option>
                                            @foreach ($employees as $emp)
                                                @php
                                                    $matchingUser = \App\Models\User::where(
                                                        'email',
                                                        $emp->login_work_email,
                                                    )
                                                        ->orWhere('email', $emp->user_id)
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
                                                <option value="{{ $emp->id }}" {{ $isSelected ? 'selected' : '' }}>
                                                    {{ $emp->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Post Sales</label>
                                        <select name="post_sales_user_id" class="form-select form-select-sm">
                                            <option value="">-- Select --</option>
                                            @foreach ($employees as $emp)
                                                <option value="{{ $emp->id }}"
                                                    {{ isset($lead->post_sales_user_id) && $lead->post_sales_user_id == $emp->id ? 'selected' : '' }}>
                                                    {{ $emp->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Operations</label>
                                        <select name="operations_user_id" class="form-select form-select-sm">
                                            <option value="">-- Select --</option>
                                            @foreach ($employees as $emp)
                                                <option value="{{ $emp->id }}"
                                                    {{ isset($lead->operations_user_id) && $lead->operations_user_id == $emp->id ? 'selected' : '' }}>
                                                    {{ $emp->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Ticketing</label>
                                        <select name="ticketing_user_id" class="form-select form-select-sm">
                                            <option value="">-- Select --</option>
                                            @foreach ($employees as $emp)
                                                <option value="{{ $emp->id }}"
                                                    {{ isset($lead->ticketing_user_id) && $lead->ticketing_user_id == $emp->id ? 'selected' : '' }}>
                                                    {{ $emp->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Visa</label>
                                        <select name="visa_user_id" class="form-select form-select-sm">
                                            <option value="">-- Select --</option>
                                            @foreach ($employees as $emp)
                                                <option value="{{ $emp->id }}"
                                                    {{ isset($lead->visa_user_id) && $lead->visa_user_id == $emp->id ? 'selected' : '' }}>
                                                    {{ $emp->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Insurance</label>
                                        <select name="insurance_user_id" class="form-select form-select-sm">
                                            <option value="">-- Select --</option>
                                            @foreach ($employees as $emp)
                                                <option value="{{ $emp->id }}"
                                                    {{ isset($lead->insurance_user_id) && $lead->insurance_user_id == $emp->id ? 'selected' : '' }}>
                                                    {{ $emp->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Accountant</label>
                                        <select name="accountant_user_id" class="form-select form-select-sm">
                                            <option value="">-- Select --</option>
                                            @foreach ($employees as $emp)
                                                <option value="{{ $emp->id }}"
                                                    {{ isset($lead->accountant_user_id) && $lead->accountant_user_id == $emp->id ? 'selected' : '' }}>
                                                    {{ $emp->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Delivery</label>
                                        <select name="delivery_user_id" class="form-select form-select-sm">
                                            <option value="">-- Select --</option>
                                            @foreach ($employees as $emp)
                                                <option value="{{ $emp->id }}"
                                                    {{ isset($lead->delivery_user_id) && $lead->delivery_user_id == $emp->id ? 'selected' : '' }}>
                                                    {{ $emp->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
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
                                        <label class="form-label">Document Details</label>
                                        <input type="text" class="form-control form-control-sm" name="document_details"
                                            placeholder="Passport No. / Aadhar No. / PAN No. / Other">
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
                                        <div class="col-md-3">
                                            <label class="form-label">Nationality</label>
                                            <input type="text" class="form-control form-control-sm" name="nationality">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">DOB</label>
                                            <input type="date" class="form-control form-control-sm" name="dob">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Place of Issue</label>
                                            <input type="text" class="form-control form-control-sm" name="place_of_issue">
                                        </div>
                                        <div class="col-md-3">
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
                                    <select name="status" class="form-select form-select-sm" required>
                                        <option value="pending">Pending</option>
                                        <option value="received">Received</option>
                                        <option value="refunded">Refunded</option>
                                    </select>
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
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="modalOnlyHotel">
                                    <label class="form-check-label" for="modalOnlyHotel">Only Hotel</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="modalOnlyTT">
                                    <label class="form-check-label" for="modalOnlyTT">Only TT</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="modalHotelTT">
                                    <label class="form-check-label" for="modalHotelTT">Hotel + TT</label>
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
                                    <textarea class="form-control form-control-sm" id="modalActivity" rows="3"
                                        placeholder="Activity/Tour Description"></textarea>
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

                    // Initialize Feather icons
                    if (typeof feather !== 'undefined') {
                        feather.replace();
                    }

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
                    function loadLocationsForInputRow(destinationSelect) {
                        const locationSelect = document.querySelector('.location-select-input');
                        const destinationId = destinationSelect.options[destinationSelect.selectedIndex]?.getAttribute(
                            'data-destination-id');

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
                                            // Do not clear here in case another handler needs it; handlers will clear when used
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


                    // Function to add destination from modal form
                    function addDestinationFromModal() {
                        const destination = document.getElementById('modalDestinationSelect').value;
                        const location = document.getElementById('modalLocationSelect').value;
                        const onlyHotel = document.getElementById('modalOnlyHotel').checked;
                        const onlyTT = document.getElementById('modalOnlyTT').checked;
                        const hotelTT = document.getElementById('modalHotelTT').checked;
                        const fromDate = document.getElementById('modalFromDate').value;
                        const toDate = document.getElementById('modalToDate').value;

                        // Validation
                        if (!destination || !location || !fromDate || !toDate) {
                            alert('Please fill in all required fields (Destination, Location, From Date, To Date)');
                            return false;
                        }

                        if (!onlyHotel && !onlyTT && !hotelTT) {
                            alert('Please select at least one service type (Only Hotel, Only TT, or Hotel + TT)');
                            return false;
                        }

                        // Format dates for display
                        const formatDate = (dateStr) => {
                            if (!dateStr) return '';
                            const date = new Date(dateStr);
                            const day = String(date.getDate()).padStart(2, '0');
                            const month = String(date.getMonth() + 1).padStart(2, '0');
                            const year = date.getFullYear();
                            return `${day}/${month}/${year}`;
                        };

                        // Create new data row
                        const tbody = document.getElementById('destinationTableBody');
                        const newRow = document.createElement('tr');
                        newRow.className = 'destination-data-row';
                        newRow.setAttribute('data-row-index', destinationRowIndex);

                        // Build service type checkmarks
                        let onlyHotelMark = onlyHotel ?
                            '<i data-feather="check" style="width: 16px; height: 16px; color: #28a745;"></i>' : '';
                        let onlyTTMark = onlyTT ?
                            '<i data-feather="check" style="width: 16px; height: 16px; color: #28a745;"></i>' : '';
                        let hotelTTMark = hotelTT ?
                            '<i data-feather="check" style="width: 16px; height: 16px; color: #28a745;"></i>' : '';

                        newRow.innerHTML = `
                        <td>${destination}</td>
                        <td>${location}</td>
                        <td class="text-center">${onlyHotelMark}</td>
                        <td class="text-center">${onlyTTMark}</td>
                        <td class="text-center">${hotelTTMark}</td>
                        <td>${formatDate(fromDate)}</td>
                        <td>${formatDate(toDate)}</td>
                        <td class="text-center">
                            <input type="hidden" name="booking_destinations[${destinationRowIndex}][destination]" value="${destination}">
                            <input type="hidden" name="booking_destinations[${destinationRowIndex}][location]" value="${location}">
                            <input type="hidden" name="booking_destinations[${destinationRowIndex}][only_hotel]" value="${onlyHotel ? '1' : '0'}">
                            <input type="hidden" name="booking_destinations[${destinationRowIndex}][only_tt]" value="${onlyTT ? '1' : '0'}">
                            <input type="hidden" name="booking_destinations[${destinationRowIndex}][hotel_tt]" value="${hotelTT ? '1' : '0'}">
                            <input type="hidden" name="booking_destinations[${destinationRowIndex}][from_date]" value="${fromDate}">
                            <input type="hidden" name="booking_destinations[${destinationRowIndex}][to_date]" value="${toDate}">
                            <i data-feather="edit" class="editDestinationRow" data-bs-toggle="modal" data-bs-target="#addDestinationModal" style="width: 16px; height: 16px; color: #0d6efd; cursor: pointer; margin-right: 8px;"></i>
                            <i data-feather="trash-2" class="removeDestinationRow" style="width: 16px; height: 16px; color: #dc3545; cursor: pointer;"></i>
                        </td>
                    `;

                        tbody.appendChild(newRow);

                        // Re-initialize Feather icons
                        if (typeof feather !== 'undefined') {
                            feather.replace();
                        }

                        destinationRowIndex++;

                        // Check itinerary visibility
                        checkItineraryVisibility();

                        return true;
                    }

                    // Handle modal form submission
                    document.getElementById('submitDestinationModal')?.addEventListener('click', function() {
                        // Only add a new destination if we're NOT editing an existing row
                        if (!editingDestinationRow && addDestinationFromModal()) {
                            // Close modal
                            const modal = bootstrap.Modal.getInstance(document.getElementById(
                                'addDestinationModal'));
                            if (modal) {
                                modal.hide();
                            }

                            // Clear modal form
                            document.getElementById('addDestinationForm').reset();
                            document.getElementById('modalLocationSelect').innerHTML =
                                '<option value="">-- Select Location --</option>';
                        }
                        // If we were editing a row, the other handler will perform the update
                    });

                    // Handle destination select change in modal to load locations
                    document.getElementById('modalDestinationSelect')?.addEventListener('change', function() {
                        const destinationId = this.options[this.selectedIndex].dataset.destinationId;
                        const locationSelect = document.getElementById('modalLocationSelect');

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
                                        locationSelect.innerHTML =
                                            '<option value="">-- Select Location --</option>';
                                        data.forEach(location => {
                                            const option = document.createElement('option');
                                            option.value = location.name;
                                            option.textContent = location.name;
                                            locationSelect.appendChild(option);
                                        });
                                        // If editing, pick the stored location now and clear the stored value
                                        if (typeof editingLocationValue !== 'undefined' &&
                                            editingLocationValue) {
                                            locationSelect.value = editingLocationValue;
                                            editingLocationValue = null;
                                        }
                                        locationSelect.disabled = false;
                                        const submitBtn = document.getElementById('submitDestinationModal');
                                        if (submitBtn) submitBtn.disabled = false;
                                    })
                                    .catch(error => {
                                        console.error('Error loading locations:', error);
                                        locationSelect.innerHTML =
                                            '<option value="">Error loading locations</option>';
                                        locationSelect.disabled = false;
                                        const submitBtn = document.getElementById('submitDestinationModal');
                                        if (submitBtn) submitBtn.disabled = false;
                                    });
                            } else {
                                locationSelect.disabled = false;
                            }
                        }
                    });

                    // Handle service type checkboxes mutual exclusivity in modal
                    const modalServiceTypeCheckboxes = ['modalOnlyHotel', 'modalOnlyTT', 'modalHotelTT'];
                    modalServiceTypeCheckboxes.forEach(id => {
                        document.getElementById(id)?.addEventListener('change', function() {
                            if (this.checked) {
                                modalServiceTypeCheckboxes.forEach(otherId => {
                                    if (otherId !== id) {
                                        document.getElementById(otherId).checked = false;
                                    }
                                });
                            }
                        });
                    });

                    // Edit destination row handler
                    let editingDestinationRow = null;
                    // When editing a row we store the location to set after locations are loaded
                    let editingLocationValue = null;
                    document.addEventListener('click', function(e) {
                        if (e.target.closest('.editDestinationRow')) {
                            const row = e.target.closest('tr');
                            editingDestinationRow = row;

                            // Get row data
                            const destination = row.querySelector('td:nth-child(1)').textContent.trim();
                            const location = row.querySelector('td:nth-child(2)').textContent.trim();
                            const onlyHotel = row.querySelector('td:nth-child(3)').querySelector('i') !== null;
                            const onlyTT = row.querySelector('td:nth-child(4)').querySelector('i') !== null;
                            const hotelTT = row.querySelector('td:nth-child(5)').querySelector('i') !== null;
                            const fromDate = row.querySelector('input[name*="[from_date]"]')?.value || '';
                            const toDate = row.querySelector('input[name*="[to_date]"]')?.value || '';

                            // Populate modal (set destination, and defer location until options load)
                            document.getElementById('modalDestinationSelect').value = destination;
                            // store the location value so we can set it after locations are fetched
                            editingLocationValue = location;
                            document.getElementById('modalOnlyHotel').checked = onlyHotel;
                            document.getElementById('modalOnlyTT').checked = onlyTT;
                            document.getElementById('modalHotelTT').checked = hotelTT;
                            document.getElementById('modalFromDate').value = fromDate;
                            document.getElementById('modalToDate').value = toDate;

                            // Change modal title
                            document.getElementById('addDestinationModalLabel').textContent = 'Edit Destination';

                            // Trigger location change if destination exists
                            const destinationSelect = document.getElementById('modalDestinationSelect');
                            if (destinationSelect.value) {
                                destinationSelect.dispatchEvent(new Event('change'));
                            }
                        }
                    });

                    // Update submit handler to handle edit
                    const originalSubmitDestination = document.getElementById('submitDestinationModal');
                    if (originalSubmitDestination) {
                        originalSubmitDestination.addEventListener('click', function() {
                            if (editingDestinationRow) {
                                // Update existing row
                                const row = editingDestinationRow;
                                const destination = document.getElementById('modalDestinationSelect').value;
                                const location = document.getElementById('modalLocationSelect').value;
                                const onlyHotel = document.getElementById('modalOnlyHotel').checked;
                                const onlyTT = document.getElementById('modalOnlyTT').checked;
                                const hotelTT = document.getElementById('modalHotelTT').checked;
                                const fromDate = document.getElementById('modalFromDate').value;
                                const toDate = document.getElementById('modalToDate').value;

                                if (!destination || !location || !fromDate || !toDate) {
                                    alert('Please fill in all required fields');
                                    return;
                                }

                                const formatDate = (dateStr) => {
                                    if (!dateStr) return '';
                                    const date = new Date(dateStr);
                                    const day = String(date.getDate()).padStart(2, '0');
                                    const month = String(date.getMonth() + 1).padStart(2, '0');
                                    const year = date.getFullYear();
                                    return `${day}/${month}/${year}`;
                                };

                                // Update row content
                                row.querySelector('td:nth-child(1)').textContent = destination;
                                row.querySelector('td:nth-child(2)').textContent = location;
                                row.querySelector('td:nth-child(3)').innerHTML = onlyHotel ?
                                    '<i data-feather="check" style="width: 16px; height: 16px; color: #28a745;"></i>' :
                                    '';
                                row.querySelector('td:nth-child(4)').innerHTML = onlyTT ?
                                    '<i data-feather="check" style="width: 16px; height: 16px; color: #28a745;"></i>' :
                                    '';
                                row.querySelector('td:nth-child(5)').innerHTML = hotelTT ?
                                    '<i data-feather="check" style="width: 16px; height: 16px; color: #28a745;"></i>' :
                                    '';
                                row.querySelector('td:nth-child(6)').textContent = formatDate(fromDate);
                                row.querySelector('td:nth-child(7)').textContent = formatDate(toDate);

                                // Update hidden inputs
                                row.querySelector('input[name*="[destination]"]').value = destination;
                                row.querySelector('input[name*="[location]"]').value = location;
                                row.querySelector('input[name*="[only_hotel]"]').value = onlyHotel ? '1' : '0';
                                row.querySelector('input[name*="[only_tt]"]').value = onlyTT ? '1' : '0';
                                row.querySelector('input[name*="[hotel_tt]"]').value = hotelTT ? '1' : '0';
                                row.querySelector('input[name*="[from_date]"]').value = fromDate;
                                row.querySelector('input[name*="[to_date]"]').value = toDate;

                                // Re-initialize Feather icons
                                if (typeof feather !== 'undefined') {
                                    feather.replace();
                                }

                                editingDestinationRow = null;
                                editingLocationValue = null;
                                document.getElementById('addDestinationModalLabel').textContent = 'Add Destination';
                                const modal = bootstrap.Modal.getInstance(document.getElementById(
                                    'addDestinationModal'));
                                if (modal) modal.hide();
                                document.getElementById('addDestinationForm').reset();
                            } else {
                                // Original add functionality
                                if (addDestinationFromModal()) {
                                    const modal = bootstrap.Modal.getInstance(document.getElementById(
                                        'addDestinationModal'));
                                    if (modal) modal.hide();
                                    document.getElementById('addDestinationForm').reset();
                                }
                                editingLocationValue = null;
                            }
                        });
                    }

                    // Reset editing state when modal is closed
                    document.getElementById('addDestinationModal')?.addEventListener('hidden.bs.modal', function() {
                        editingDestinationRow = null;
                        editingLocationValue = null;
                        document.getElementById('addDestinationModalLabel').textContent = 'Add Destination';
                        const locationSelect = document.getElementById('modalLocationSelect');
                        if (locationSelect) {
                            locationSelect.innerHTML = '<option value="">-- Select Location --</option>';
                        }
                        const form = document.getElementById('addDestinationForm');
                        if (form) form.reset();
                    });

                    // Reset arrival/departure modal edit state when closed
                    document.getElementById('addArrivalDepartureModal')?.addEventListener('hidden.bs.modal', function() {
                        editingArrivalDepartureRow = null;
                        document.getElementById('addArrivalDepartureModalLabel').textContent =
                            'Add Arrival/Departure';
                        const submitBtn = document.getElementById('submitArrivalDepartureModal');
                        if (submitBtn) submitBtn.textContent = 'Add';
                        const form = document.getElementById('addArrivalDepartureForm');
                        if (form) form.reset();
                    });

                    // Remove destination row handler (using event delegation)
                    document.addEventListener('click', function(e) {
                        if (e.target.closest('.removeDestinationRow')) {
                            if (!confirm('Are you sure you want to delete this destination row?')) {
                                return;
                            }
                            const row = e.target.closest('tr');
                            row.remove();

                            // Check itinerary visibility after removing destination row
                            checkItineraryVisibility();
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

                    // Function to add arrival/departure from modal
                    function addArrivalDepartureFromModal() {
                        const mode = document.getElementById('modalMode').value;
                        const info = document.getElementById('modalInfo').value;
                        const fromCity = document.getElementById('modalFromCity').value;
                        const toCity = document.getElementById('modalToCity').value;
                        const departureAt = document.getElementById('modalDepartureAt').value; // e.g. 2025-12-31T15:30
                        const arrivalAt = document.getElementById('modalArrivalAt').value;

                        // Validation
                        if (!mode || !fromCity || !toCity || !departureAt || !arrivalAt) {
                            alert(
                                'Please fill in all required fields (Mode, From City, To City, Departure Date & Time, Arrival Date & Time)'
                            );
                            return false;
                        }

                        // Split datetime-local into date and time parts
                        const [departureDate, departureTimeFull] = departureAt.split('T');
                        const departureTime = departureTimeFull ? departureTimeFull.substr(0, 5) : '';
                        const [arrivalDate, arrivalTimeFull] = arrivalAt.split('T');
                        const arrivalTime = arrivalTimeFull ? arrivalTimeFull.substr(0, 5) : '';

                        // Create new data row
                        const tbody = document.getElementById('arrivalDepartureTableBody');
                        const newRow = document.createElement('tr');
                        newRow.className = 'arrival-departure-data-row';
                        newRow.setAttribute('data-row-index', arrivalDepartureRowIndex);

                        const depDateDisplay = formatDateDisplay(departureDate);
                        const arrDateDisplay = formatDateDisplay(arrivalDate);
                        const depTimeDisplay = departureTime ? departureTime : '';
                        const arrTimeDisplay = arrivalTime ? arrivalTime : '';

                        newRow.innerHTML = `
                        <td>${mode}</td>
                        <td>${info}</td>
                        <td>${fromCity}</td>
                        <td>${toCity}</td>
                        <td>${depDateDisplay}</td>
                        <td>${depTimeDisplay}</td>
                        <td>${arrDateDisplay}</td>
                        <td>${arrTimeDisplay}</td>
                        <td class="text-center">
                            <input type="hidden" name="arrival_departure[${arrivalDepartureRowIndex}][mode]" value="${mode}">
                            <input type="hidden" name="arrival_departure[${arrivalDepartureRowIndex}][info]" value="${info}">
                            <input type="hidden" name="arrival_departure[${arrivalDepartureRowIndex}][from_city]" value="${fromCity}">
                            <input type="hidden" name="arrival_departure[${arrivalDepartureRowIndex}][to_city]" value="${toCity}">
                            <input type="hidden" name="arrival_departure[${arrivalDepartureRowIndex}][departure_date]" value="${departureDate}">
                            <input type="hidden" name="arrival_departure[${arrivalDepartureRowIndex}][departure_time]" value="${departureTime}">
                            <input type="hidden" name="arrival_departure[${arrivalDepartureRowIndex}][arrival_date]" value="${arrivalDate}">
                            <input type="hidden" name="arrival_departure[${arrivalDepartureRowIndex}][arrival_time]" value="${arrivalTime}">
                            <i data-feather="edit" class="editArrivalDepartureRow" data-bs-toggle="modal" data-bs-target="#addArrivalDepartureModal" style="width: 16px; height: 16px; color: #0d6efd; cursor: pointer; margin-right: 8px;"></i>
                            <i data-feather="trash-2" class="removeArrivalDepartureRow" style="width: 16px; height: 16px; color: #dc3545; cursor: pointer;"></i>
                        </td>
                    `;

                        // If we are editing an existing row, replace its contents
                        if (editingArrivalDepartureRow) {
                            const row = editingArrivalDepartureRow;
                            const rowIndex = row.getAttribute('data-row-index') || row.dataset.rowIndex || '';
                            row.innerHTML = `
                            <td>${mode}</td>
                            <td>${info}</td>
                            <td>${fromCity}</td>
                            <td>${toCity}</td>
                            <td>${depDateDisplay}</td>
                            <td>${depTimeDisplay}</td>
                            <td>${arrDateDisplay}</td>
                            <td>${arrTimeDisplay}</td>
                            <td class="text-center">
                                <input type="hidden" name="arrival_departure[${rowIndex}][mode]" value="${mode}">
                                <input type="hidden" name="arrival_departure[${rowIndex}][info]" value="${info}">
                                <input type="hidden" name="arrival_departure[${rowIndex}][from_city]" value="${fromCity}">
                                <input type="hidden" name="arrival_departure[${rowIndex}][to_city]" value="${toCity}">
                                <input type="hidden" name="arrival_departure[${rowIndex}][departure_date]" value="${departureDate}">
                                <input type="hidden" name="arrival_departure[${rowIndex}][departure_time]" value="${departureTime}">
                                <input type="hidden" name="arrival_departure[${rowIndex}][arrival_date]" value="${arrivalDate}">
                                <input type="hidden" name="arrival_departure[${rowIndex}][arrival_time]" value="${arrivalTime}">
                                <i data-feather="edit" class="editArrivalDepartureRow" data-bs-toggle="modal" data-bs-target="#addArrivalDepartureModal" style="width: 16px; height: 16px; color: #0d6efd; cursor: pointer; margin-right: 8px;"></i>
                                <i data-feather="trash-2" class="removeArrivalDepartureRow" style="width: 16px; height: 16px; color: #dc3545; cursor: pointer;"></i>
                            </td>
                        `;

                            // Re-initialize Feather icons
                            if (typeof feather !== 'undefined') {
                                feather.replace();
                            }

                            // Reset edit state
                            editingArrivalDepartureRow = null;
                            document.getElementById('addArrivalDepartureModalLabel').textContent = 'Add Arrival/Departure';
                            const submitBtn = document.getElementById('submitArrivalDepartureModal');
                            if (submitBtn) submitBtn.textContent = 'Add';

                            return true;
                        }

                        // Otherwise append as new row
                        tbody.appendChild(newRow);

                        // Re-initialize Feather icons
                        if (typeof feather !== 'undefined') {
                            feather.replace();
                        }

                        arrivalDepartureRowIndex++;
                        return true;
                    }

                    // Handle modal form submission
                    document.getElementById('submitArrivalDepartureModal')?.addEventListener('click', function() {
                        if (addArrivalDepartureFromModal()) {
                            const modal = bootstrap.Modal.getInstance(document.getElementById(
                                'addArrivalDepartureModal'));
                            if (modal) {
                                modal.hide();
                            }
                            document.getElementById('addArrivalDepartureForm').reset();
                        }
                    });

                    // Remove arrival/departure row handler
                    document.addEventListener('click', function(e) {
                        if (e.target.closest('.removeArrivalDepartureRow')) {
                            if (!confirm('Are you sure you want to delete this arrival/departure row?')) {
                                return;
                            }
                            const row = e.target.closest('tr');
                            row.remove();
                        }

                        // Edit arrival/departure row handler
                        if (e.target.closest('.editArrivalDepartureRow')) {
                            const row = e.target.closest('tr');
                            editingArrivalDepartureRow = row;

                            // Get row data
                            const mode = row.querySelector('td:nth-child(1)').textContent.trim();
                            const info = row.querySelector('td:nth-child(2)').textContent.trim();
                            const fromCity = row.querySelector('td:nth-child(3)').textContent.trim();
                            const toCity = row.querySelector('td:nth-child(4)').textContent.trim();

                            const departureDateHidden = row.querySelector('input[name*="[departure_date]"]')
                                ?.value || '';
                            const departureTimeHidden = row.querySelector('input[name*="[departure_time]"]')
                                ?.value || '';
                            const arrivalDateHidden = row.querySelector('input[name*="[arrival_date]"]')?.value ||
                                '';
                            const arrivalTimeHidden = row.querySelector('input[name*="[arrival_time]"]')?.value ||
                                '';

                            // Populate modal fields
                            document.getElementById('modalMode').value = mode;
                            document.getElementById('modalInfo').value = info;
                            document.getElementById('modalFromCity').value = fromCity;
                            document.getElementById('modalToCity').value = toCity;

                            const departureAt = departureDateHidden ? (departureTimeHidden ?
                                `${departureDateHidden}T${departureTimeHidden}` : `${departureDateHidden}T00:00`
                            ) : '';
                            const arrivalAt = arrivalDateHidden ? (arrivalTimeHidden ?
                                `${arrivalDateHidden}T${arrivalTimeHidden}` : `${arrivalDateHidden}T00:00`) : '';

                            document.getElementById('modalDepartureAt').value = departureAt;
                            document.getElementById('modalArrivalAt').value = arrivalAt;

                            // Change modal title and button text
                            document.getElementById('addArrivalDepartureModalLabel').textContent =
                                'Edit Arrival/Departure';
                            const submitBtn = document.getElementById('submitArrivalDepartureModal');
                            if (submitBtn) submitBtn.textContent = 'Save';
                        }
                    });

                    // Accommodation table management
                    let accommodationRowIndex =
                        {{ $lead->bookingAccommodations ? $lead->bookingAccommodations->count() : 0 }};

                    // Track if we are editing an existing accommodation row
                    let editingAccommodationRow = null;
                    // When editing, store the location to set after locations are loaded
                    let editingAccLocationValue = null;

                    // Function to load locations for accommodation modal when a destination is selected
                    function loadAccLocationsForDestination(destinationSelect) {
                        const locationSelect = document.getElementById('modalAccLocationSelect');
                        const destinationId = destinationSelect.options[destinationSelect.selectedIndex]?.getAttribute(
                            'data-destination-id');

                        if (locationSelect) {
                            locationSelect.innerHTML = '<option value="">-- Select Location --</option>';

                            if (destinationId) {
                                locationSelect.disabled = true;
                                locationSelect.innerHTML = '<option value="">Loading locations...</option>';
                                const submitBtn = document.getElementById('submitAccommodationModal');
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
                                        // If a location is pending selection (editing), set it now and clear stored value
                                        if (typeof editingAccLocationValue !== 'undefined' && editingAccLocationValue) {
                                            locationSelect.value = editingAccLocationValue;
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
                            } else {
                                locationSelect.disabled = false;
                            }
                        }
                    }

                    // Function to add accommodation from modal
                    function addAccommodationFromModal() {
                        const destination = document.getElementById('modalAccDestinationSelect').value;
                        const location = document.getElementById('modalAccLocationSelect').value;
                        const stayAt = document.getElementById('modalStayAt').value;
                        const checkinDate = document.getElementById('modalCheckinDate').value;
                        const checkoutDate = document.getElementById('modalCheckoutDate').value;
                        const roomType = document.getElementById('modalRoomType').value;
                        const mealPlan = document.getElementById('modalMealPlan').value;

                        // Validation
                        if (!destination || !location || !stayAt || !checkinDate || !checkoutDate) {
                            alert(
                                'Please fill in all required fields (Destination, Location, Stay At, Check-in Date, Check-out Date)'
                            );
                            return false;
                        }

                        // Create new data row
                        const tbody = document.getElementById('accommodationTableBody');
                        const newRow = document.createElement('tr');
                        newRow.className = 'accommodation-data-row';
                        newRow.setAttribute('data-row-index', accommodationRowIndex);

                        newRow.innerHTML = `
                        <td>${destination}</td>
                        <td>${location}</td>
                        <td>${stayAt}</td>
                        <td>${formatDateDisplay(checkinDate)}</td>
                        <td>${formatDateDisplay(checkoutDate)}</td>
                        <td>${roomType}</td>
                        <td>${mealPlan}</td>
                        <td class="text-center">
                            <input type="hidden" name="booking_accommodations[${accommodationRowIndex}][destination]" value="${destination}">
                            <input type="hidden" name="booking_accommodations[${accommodationRowIndex}][location]" value="${location}">
                            <input type="hidden" name="booking_accommodations[${accommodationRowIndex}][stay_at]" value="${stayAt}">
                            <input type="hidden" name="booking_accommodations[${accommodationRowIndex}][checkin_date]" value="${checkinDate}">
                            <input type="hidden" name="booking_accommodations[${accommodationRowIndex}][checkout_date]" value="${checkoutDate}">
                            <input type="hidden" name="booking_accommodations[${accommodationRowIndex}][room_type]" value="${roomType}">
                            <input type="hidden" name="booking_accommodations[${accommodationRowIndex}][meal_plan]" value="${mealPlan}">
                            <i data-feather="edit" class="editAccommodationRow" data-bs-toggle="modal" data-bs-target="#addAccommodationModal" style="width: 16px; height: 16px; color: #0d6efd; cursor: pointer; margin-right: 8px;"></i>
                            <i data-feather="trash-2" class="removeAccommodationRow" style="width: 16px; height: 16px; color: #dc3545; cursor: pointer;"></i>
                        </td>
                    `;

                        // If we are editing an existing row, replace its contents
                        if (editingAccommodationRow) {
                            const row = editingAccommodationRow;
                            const rowIndex = row.getAttribute('data-row-index') || row.dataset.rowIndex || '';
                            row.innerHTML = `
                            <td>${destination}</td>
                            <td>${location}</td>
                            <td>${stayAt}</td>
                            <td>${formatDateDisplay(checkinDate)}</td>
                            <td>${formatDateDisplay(checkoutDate)}</td>
                            <td>${roomType}</td>
                            <td>${mealPlan}</td>
                            <td class="text-center">
                                <input type="hidden" name="booking_accommodations[${rowIndex}][destination]" value="${destination}">
                                <input type="hidden" name="booking_accommodations[${rowIndex}][location]" value="${location}">
                                <input type="hidden" name="booking_accommodations[${rowIndex}][stay_at]" value="${stayAt}">
                                <input type="hidden" name="booking_accommodations[${rowIndex}][checkin_date]" value="${checkinDate}">
                                <input type="hidden" name="booking_accommodations[${rowIndex}][checkout_date]" value="${checkoutDate}">
                                <input type="hidden" name="booking_accommodations[${rowIndex}][room_type]" value="${roomType}">
                                <input type="hidden" name="booking_accommodations[${rowIndex}][meal_plan]" value="${mealPlan}">
                                <i data-feather="edit" class="editAccommodationRow" data-bs-toggle="modal" data-bs-target="#addAccommodationModal" style="width: 16px; height: 16px; color: #0d6efd; cursor: pointer; margin-right: 8px;"></i>
                                <i data-feather="trash-2" class="removeAccommodationRow" style="width: 16px; height: 16px; color: #dc3545; cursor: pointer;"></i>
                            </td>
                        `;

                            // Re-initialize Feather icons
                            if (typeof feather !== 'undefined') {
                                feather.replace();
                            }

                            // Reset edit state
                            editingAccommodationRow = null;
                            document.getElementById('addAccommodationModalLabel').textContent = 'Add Accommodation';
                            const modal = bootstrap.Modal.getInstance(document.getElementById('addAccommodationModal'));
                            if (modal) modal.hide();
                            document.getElementById('addAccommodationForm').reset();

                            return true;
                        }

                        // Otherwise append as new row
                        tbody.appendChild(newRow);

                        // Re-initialize Feather icons
                        if (typeof feather !== 'undefined') {
                            feather.replace();
                        }

                        accommodationRowIndex++;
                        return true;
                    }

                    // Handle modal form submission
                    document.getElementById('submitAccommodationModal')?.addEventListener('click', function() {
                        if (addAccommodationFromModal()) {
                            const modal = bootstrap.Modal.getInstance(document.getElementById(
                                'addAccommodationModal'));
                            if (modal) {
                                modal.hide();
                            }
                            document.getElementById('addAccommodationForm').reset();
                        }
                    });

                    // Remove accommodation row handler and Edit handler
                    document.addEventListener('click', function(e) {
                        if (e.target.closest('.removeAccommodationRow')) {
                            if (!confirm('Are you sure you want to delete this accommodation row?')) {
                                return;
                            }
                            const row = e.target.closest('tr');
                            row.remove();
                        }

                        // Edit accommodation row handler
                        if (e.target.closest('.editAccommodationRow')) {
                            const row = e.target.closest('tr');
                            editingAccommodationRow = row;

                            // Get row data
                            const destination = row.querySelector('td:nth-child(1)').textContent.trim();
                            const location = row.querySelector('td:nth-child(2)').textContent.trim();
                            const stayAt = row.querySelector('td:nth-child(3)').textContent.trim();
                            const checkinDateHidden = row.querySelector('input[name*="[checkin_date]"]')?.value ||
                                '';
                            const checkoutDateHidden = row.querySelector('input[name*="[checkout_date]"]')?.value ||
                                '';
                            const roomType = row.querySelector('td:nth-child(6)').textContent.trim();
                            const mealPlan = row.querySelector('td:nth-child(7)').textContent.trim();

                            // Populate modal
                            const destinationSelect = document.getElementById('modalAccDestinationSelect');
                            if (destinationSelect) {
                                destinationSelect.value = destination;
                                // store the location value so we can set it after locations are fetched
                                editingAccLocationValue = location;
                                // Trigger location change to load options
                                destinationSelect.dispatchEvent(new Event('change'));
                            }

                            document.getElementById('modalStayAt').value = stayAt;
                            document.getElementById('modalCheckinDate').value = checkinDateHidden;
                            document.getElementById('modalCheckoutDate').value = checkoutDateHidden;
                            document.getElementById('modalRoomType').value = roomType;
                            document.getElementById('modalMealPlan').value = mealPlan;

                            // Change modal title
                            document.getElementById('addAccommodationModalLabel').textContent =
                                'Edit Accommodation';
                            const submitBtn = document.getElementById('submitAccommodationModal');
                            if (submitBtn) submitBtn.textContent = 'Save';
                        }
                    });

                    // Handle destination change in accommodation modal to load locations
                    document.getElementById('modalAccDestinationSelect')?.addEventListener('change', function() {
                        const destinationId = this.options[this.selectedIndex].dataset.destinationId;
                        const locationSelect = document.getElementById('modalAccLocationSelect');

                        if (locationSelect) {
                            locationSelect.innerHTML = '<option value="">-- Select Location --</option>';

                            if (destinationId) {
                                locationSelect.disabled = true;
                                locationSelect.innerHTML = '<option value="">Loading locations...</option>';
                                const submitBtn = document.getElementById('submitAccommodationModal');
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
                                        locationSelect.innerHTML =
                                            '<option value="">-- Select Location --</option>';
                                        data.forEach(location => {
                                            const option = document.createElement('option');
                                            option.value = location.name;
                                            option.textContent = location.name;
                                            locationSelect.appendChild(option);
                                        });
                                        // If editing, pick the stored location now and clear the stored value
                                        if (typeof editingAccLocationValue !== 'undefined' &&
                                            editingAccLocationValue) {
                                            locationSelect.value = editingAccLocationValue;
                                            editingAccLocationValue = null;
                                        }
                                        locationSelect.disabled = false;
                                        const submitBtn = document.getElementById('submitAccommodationModal');
                                        if (submitBtn) submitBtn.disabled = false;
                                    })
                                    .catch(error => {
                                        console.error('Error loading locations:', error);
                                        locationSelect.innerHTML =
                                            '<option value="">Error loading locations</option>';
                                        locationSelect.disabled = false;
                                        const submitBtn = document.getElementById('submitAccommodationModal');
                                        if (submitBtn) submitBtn.disabled = false;
                                    });
                            } else {
                                locationSelect.disabled = false;
                            }
                        }
                    });

                    // Reset editing state when accommodation modal is closed
                    document.getElementById('addAccommodationModal')?.addEventListener('hidden.bs.modal', function() {
                        editingAccommodationRow = null;
                        editingAccLocationValue = null;
                        document.getElementById('addAccommodationModalLabel').textContent = 'Add Accommodation';
                        const submitBtn = document.getElementById('submitAccommodationModal');
                        if (submitBtn) submitBtn.textContent = 'Add';
                        const locationSelect = document.getElementById('modalAccLocationSelect');
                        if (locationSelect) {
                            locationSelect.innerHTML = '<option value="">-- Select Location --</option>';
                        }
                        const form = document.getElementById('addAccommodationForm');
                        if (form) form.reset();
                    });

                    // Itinerary table management
                    let itineraryRowIndex = {{ $lead->bookingItineraries ? $lead->bookingItineraries->count() : 0 }};

                    // Function to add itinerary from modal
                    function addItineraryFromModal() {
                        const dayDate = document.getElementById('modalDayDate').value;
                        const time = document.getElementById('modalItineraryTime').value;
                        const location = document.getElementById('modalItineraryLocation').value;
                        const activity = document.getElementById('modalActivity').value;
                        const stayAt = document.getElementById('modalItineraryStayAt').value;
                        const remarks = document.getElementById('modalRemarks').value;

                        // Validation
                        if (!dayDate || !location || !activity) {
                            alert('Please fill in all required fields (Day & Date, Location, Activity/Tour Description)');
                            return false;
                        }

                        // Create new data row
                        const tbody = document.getElementById('itineraryTableBody');
                        const newRow = document.createElement('tr');
                        newRow.className = 'itinerary-data-row';
                        newRow.setAttribute('data-row-index', itineraryRowIndex);

                        newRow.innerHTML = `
                        <td>${dayDate}</td>
                        <td>${time || ''}</td>
                        <td>${location}</td>
                        <td>${activity}</td>
                        <td>${stayAt || ''}</td>
                        <td>${remarks || ''}</td>
                        <td class="text-center">
                            <input type="hidden" name="booking_itineraries[${itineraryRowIndex}][day_and_date]" value="${dayDate}">
                            <input type="hidden" name="booking_itineraries[${itineraryRowIndex}][time]" value="${time}">
                            <input type="hidden" name="booking_itineraries[${itineraryRowIndex}][location]" value="${location}">
                            <input type="hidden" name="booking_itineraries[${itineraryRowIndex}][activity_tour_description]" value="${activity}">
                            <input type="hidden" name="booking_itineraries[${itineraryRowIndex}][stay_at]" value="${stayAt}">
                            <input type="hidden" name="booking_itineraries[${itineraryRowIndex}][remarks]" value="${remarks}">
                            <i data-feather="edit" class="editItineraryRow" data-bs-toggle="modal" data-bs-target="#addItineraryModal" style="width: 16px; height: 16px; color: #0d6efd; cursor: pointer; margin-right: 8px;"></i>
                            <i data-feather="trash-2" class="removeItineraryRow" style="width: 16px; height: 16px; color: #dc3545; cursor: pointer;"></i>
                        </td>
                    `;

                        tbody.appendChild(newRow);

                        // Re-initialize Feather icons
                        if (typeof feather !== 'undefined') {
                            feather.replace();
                        }

                        itineraryRowIndex++;
                        return true;
                    }

                    // Edit itinerary row handler
                    let editingItineraryRow = null;
                    document.addEventListener('click', function(e) {
                        if (e.target.closest('.editItineraryRow')) {
                            const row = e.target.closest('tr');
                            editingItineraryRow = row;

                            // Get row data
                            const dayDate = row.querySelector('td:nth-child(1)').textContent.trim();
                            const time = row.querySelector('td:nth-child(2)').textContent.trim();
                            const location = row.querySelector('td:nth-child(3)').textContent.trim();
                            const activity = row.querySelector('td:nth-child(4)').textContent.trim();
                            const stayAt = row.querySelector('td:nth-child(5)').textContent.trim();
                            const remarks = row.querySelector('td:nth-child(6)').textContent.trim();

                            // Populate modal
                            document.getElementById('modalDayDate').value = dayDate;
                            document.getElementById('modalItineraryTime').value = time;
                            document.getElementById('modalItineraryLocation').value = location;
                            document.getElementById('modalActivity').value = activity;
                            document.getElementById('modalItineraryStayAt').value = stayAt;
                            document.getElementById('modalRemarks').value = remarks;

                            // Change modal title
                            document.getElementById('addItineraryModalLabel').textContent =
                                'Edit Day-Wise Itinerary';
                        }
                    });

                    // Handle modal form submission
                    document.getElementById('submitItineraryModal')?.addEventListener('click', function() {
                        if (editingItineraryRow) {
                            // Update existing row
                            const row = editingItineraryRow;
                            const dayDate = document.getElementById('modalDayDate').value;
                            const time = document.getElementById('modalItineraryTime').value;
                            const location = document.getElementById('modalItineraryLocation').value;
                            const activity = document.getElementById('modalActivity').value;
                            const stayAt = document.getElementById('modalItineraryStayAt').value;
                            const remarks = document.getElementById('modalRemarks').value;

                            if (!dayDate || !location || !activity) {
                                alert(
                                    'Please fill in all required fields (Day & Date, Location, Activity/Tour Description)'
                                );
                                return;
                            }

                            // Update row content
                            row.querySelector('td:nth-child(1)').textContent = dayDate;
                            row.querySelector('td:nth-child(2)').textContent = time || '';
                            row.querySelector('td:nth-child(3)').textContent = location;
                            row.querySelector('td:nth-child(4)').textContent = activity;
                            row.querySelector('td:nth-child(5)').textContent = stayAt || '';
                            row.querySelector('td:nth-child(6)').textContent = remarks || '';

                            // Update hidden inputs
                            row.querySelector('input[name*="[day_and_date]"]').value = dayDate;
                            row.querySelector('input[name*="[time]"]').value = time || '';
                            row.querySelector('input[name*="[location]"]').value = location;
                            row.querySelector('input[name*="[activity_tour_description]"]').value = activity;
                            row.querySelector('input[name*="[stay_at]"]').value = stayAt || '';
                            row.querySelector('input[name*="[remarks]"]').value = remarks || '';

                            editingItineraryRow = null;
                            document.getElementById('addItineraryModalLabel').textContent =
                                'Add Day-Wise Itinerary';
                            const modal = bootstrap.Modal.getInstance(document.getElementById('addItineraryModal'));
                            if (modal) modal.hide();
                            document.getElementById('addItineraryForm').reset();
                        } else {
                            // Original add functionality
                            if (addItineraryFromModal()) {
                                const modal = bootstrap.Modal.getInstance(document.getElementById(
                                    'addItineraryModal'));
                                if (modal) {
                                    modal.hide();
                                }
                                document.getElementById('addItineraryForm').reset();
                            }
                        }
                    });

                    // Reset editing state when modal is closed
                    document.getElementById('addItineraryModal')?.addEventListener('hidden.bs.modal', function() {
                        editingItineraryRow = null;
                        document.getElementById('addItineraryModalLabel').textContent = 'Add Day-Wise Itinerary';
                    });

                    // Remove itinerary row handler
                    document.addEventListener('click', function(e) {
                        if (e.target.closest('.removeItineraryRow')) {
                            if (!confirm('Are you sure you want to delete this itinerary row?')) {
                                return;
                            }
                            const row = e.target.closest('tr');
                            row.remove();
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
                        const destinationRows = destinationTableBody.querySelectorAll('.destination-data-row');

                        destinationRows.forEach(row => {
                            const onlyTTInput = row.querySelector('input[name*="[only_tt]"]');
                            const hotelTTInput = row.querySelector('input[name*="[hotel_tt]"]');

                            if ((onlyTTInput && onlyTTInput.value === '1') || (hotelTTInput && hotelTTInput
                                    .value === '1')) {
                                shouldShow = true;
                            }
                        });

                        // Show/hide itinerary section
                        if (shouldShow) {
                            itinerarySection.style.display = '';

                            // Input row is always present, no need to add default row
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

                        form.action = '{{ route('leads.payments.store', $lead->id) }}'.replace('/payments',
                            '/payments/' + paymentId);
                        const methodInput = document.getElementById('postSalesPaymentFormMethod');
                        if (methodInput) {
                            methodInput.value = 'PUT';
                        }

                        form.querySelector('input[name=\"amount\"]').value = amount;
                        form.querySelector('select[name=\"method\"]').value = method;
                        form.querySelector('input[name=\"payment_date\"]').value = paymentDate;
                        form.querySelector('input[name=\"due_date\"]').value = dueDate;
                        form.querySelector('input[name=\"reference\"]').value = reference;
                        form.querySelector('select[name=\"status\"]').value = status;

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
                    });

                    // Traveller Document Details: toggle passport extra fields
                    const travellerDocTypeSelect = document.getElementById('travellerDocumentType');
                    const passportExtraFields = document.getElementById('passportExtraFields');
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

                        const colsToToggle = [6, 7, 8, 9]; // Nationality, DOB, Place of Issue, Date of Expiry
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
                        form.querySelector('input[name=\"dob\"]').value = editIcon.getAttribute('data-dob') || '';
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

                    // Handle form submission
                    const bookingFileForm = document.getElementById('bookingFileForm');
                    if (bookingFileForm) {
                        bookingFileForm.addEventListener('submit', function(e) {
                            e.preventDefault();

                            // Convert form to FormData to properly handle arrays
                            const formData = new FormData(bookingFileForm);
                            const submitButton = bookingFileForm.querySelector('button[type="submit"]');
                            const originalButtonText = submitButton.textContent;

                            // Disable submit button and show loading
                            submitButton.disabled = true;
                            submitButton.textContent = 'Saving...';

                            // Convert FormData to object for JSON submission
                            const data = {};
                            for (let [key, value] of formData.entries()) {
                                if (key.includes('[') && key.includes(']')) {
                                    // Handle array notation like booking_destinations[0][destination]
                                    const matches = key.match(/^(.+?)\[(\d+)\]\[(.+?)\]$/);
                                    if (matches) {
                                        const [, arrayName, index, field] = matches;
                                        if (!data[arrayName]) data[arrayName] = {};
                                        if (!data[arrayName][index]) data[arrayName][index] = {};
                                        data[arrayName][index][field] = value;
                                    } else {
                                        // Handle simple array notation
                                        const arrayMatch = key.match(/^(.+?)\[(\d+)\]$/);
                                        if (arrayMatch) {
                                            const [, arrayName, index] = arrayMatch;
                                            if (!data[arrayName]) data[arrayName] = {};
                                            data[arrayName][index] = value;
                                        } else {
                                            data[key] = value;
                                        }
                                    }
                                } else {
                                    data[key] = value;
                                }
                            }

                            // Convert nested objects to arrays for Laravel
                            if (data.booking_destinations) {
                                data.booking_destinations = Object.values(data.booking_destinations);
                            }
                            if (data.booking_flights) {
                                data.booking_flights = Object.values(data.booking_flights);
                            }
                            if (data.booking_surface_transports) {
                                data.booking_surface_transports = Object.values(data.booking_surface_transports);
                            }
                            if (data.booking_sea_transports) {
                                data.booking_sea_transports = Object.values(data.booking_sea_transports);
                            }
                            if (data.booking_accommodations) {
                                data.booking_accommodations = Object.values(data.booking_accommodations);
                            }
                            if (data.booking_itineraries) {
                                data.booking_itineraries = Object.values(data.booking_itineraries);
                            }

                            fetch(bookingFileForm.action, {
                                    method: 'PUT',
                                    headers: {
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                            ?.content || formData.get('_token'),
                                        'Accept': 'application/json',
                                        'Content-Type': 'application/json',
                                    },
                                    body: JSON.stringify(data)
                                })
                                .then(response => {
                                    if (!response.ok) {
                                        return response.json().then(data => {
                                            throw new Error(data.message || 'An error occurred');
                                        });
                                    }
                                    return response.json();
                                })
                                .then(data => {
                                    // Show success message
                                    const alertDiv = document.createElement('div');
                                    alertDiv.className = 'alert alert-success alert-dismissible fade show';
                                    alertDiv.setAttribute('role', 'alert');
                                    alertDiv.innerHTML = `
                                    <strong>Success!</strong> Booking file saved successfully!
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                `;
                                    bookingFileForm.insertBefore(alertDiv, bookingFileForm.firstChild);

                                    // Scroll to top
                                    window.scrollTo({
                                        top: 0,
                                        behavior: 'smooth'
                                    });

                                    // Auto-hide alert after 3 seconds
                                    setTimeout(() => {
                                        alertDiv.remove();
                                    }, 3000);
                                })
                                .catch(error => {
                                    console.error('Error saving booking file:', error);

                                    // Show error message
                                    const alertDiv = document.createElement('div');
                                    alertDiv.className = 'alert alert-danger alert-dismissible fade show';
                                    alertDiv.setAttribute('role', 'alert');
                                    alertDiv.innerHTML = `
                                    <strong>Error!</strong> ${error.message || 'Unable to save booking file.'}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                `;
                                    bookingFileForm.insertBefore(alertDiv, bookingFileForm.firstChild);

                                    // Scroll to top
                                    window.scrollTo({
                                        top: 0,
                                        behavior: 'smooth'
                                    });
                                })
                                .finally(() => {
                                    // Re-enable submit button
                                    submitButton.disabled = false;
                                    submitButton.textContent = originalButtonText;
                                });
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
