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
                                <div class="d-flex align-items-center gap-3">
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
                                                <label class="form-label">Contact 1</label>
                                                <input type="text" value="{{ $lead->primary_phone ?? $lead->phone }}"
                                                    class="form-control form-control-sm" readonly disabled
                                                    style="background-color: #f8f9fa; cursor: not-allowed;">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Contact 2</label>
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
                                                <label class="form-label">Booked On</label>
                                                <input type="text"
                                                    value="{{ $lead->booked_on ? $lead->booked_on->format('d M, Y h:i A') : 'N/A' }}"
                                                    class="form-control form-control-sm" readonly disabled
                                                    style="background-color: #f8f9fa; cursor: not-allowed;">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Sales Cost</label>
                                                @if ($isViewOnly)
                                                    <input type="text"
                                                        value="{{ $lead->selling_price ? number_format($lead->selling_price, 2) : '0.00' }}"
                                                        class="form-control form-control-sm" readonly disabled
                                                        style="background-color: #f8f9fa; cursor: not-allowed;">
                                                @else
                                                    <input type="number" name="selling_price" 
                                                        value="{{ old('selling_price', $lead->selling_price ?? 0) }}"
                                                        class="form-control form-control-sm" step="0.01" min="0"
                                                        placeholder="0.00">
                                                @endif
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Re-assign To</label>
                                                @if ($isViewOnly)
                                                    <input type="text"
                                                        value="{{ $lead->reassignedTo?->name ?? 'N/A' }}"
                                                        class="form-control form-control-sm" readonly disabled
                                                        style="background-color: #f8f9fa; cursor: not-allowed;">
                                                @else
                                                    <select name="reassigned_to" class="form-select form-select-sm">
                                                        <option value="">-- Select User --</option>
                                                        @foreach ($users as $user)
                                                            <option value="{{ $user->id }}"
                                                                {{ old('reassigned_to', $lead->reassigned_to) == $user->id ? 'selected' : '' }}>
                                                                {{ $user->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
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
                                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addDestinationModal">
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
                                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addArrivalDepartureModal">
                                                    <i data-feather="plus" style="width: 14px; height: 14px;"></i>
                                                    Add
                                                </button>
                                            @endif
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-sm mb-0" id="arrivalDepartureTable">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th style="width: 12%;">Mode</th>
                                                        <th style="width: 15%;">Info</th>
                                                        <th style="width: 12%;">From City</th>
                                                        <th style="width: 12%;">To City</th>
                                                        <th style="width: 18%;">Dep Date & Time</th>
                                                        <th style="width: 18%;">Arrival Date & Time</th>
                                                        @if (!($isViewOnly && ($isOpsDept || ($isPostSales ?? false))))
                                                            <th style="width: 13%;" class="text-center">Action</th>
                                                        @endif
                                                    </tr>
                                                </thead>
                                                <tbody id="arrivalDepartureTableBody">
                                                    @php
                                                        $allTransports = $lead->bookingArrivalDepartures ?? collect();
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
                                                                    {{ $transport->departure_time ? ' ' . substr($transport->departure_time, 0, 5) : '' }}
                                                                </td>
                                                                <td>
                                                                    {{ $transport->arrival_date ? ($transport->arrival_date instanceof \DateTime ? $transport->arrival_date->format('d/m/Y') : date('d/m/Y', strtotime($transport->arrival_date))) : '' }}
                                                                    {{ $transport->arrival_time ? ' ' . substr($transport->arrival_time, 0, 5) : '' }}
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
                                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addAccommodationModal">
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
                                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addItineraryModal">
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
                                                                <td>{{ $bi->time ? substr($bi->time, 0, 5) : '' }}</td>
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

                                    <!-- Document Checklist Summary Section (Post Sales Only) -->
                                    @if($isPostSales ?? false)
                                    <div class="mb-4 border rounded-3 p-3">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h6 class="text-uppercase text-muted small fw-semibold mb-0">
                                                <i data-feather="file-text" class="me-1" style="width: 14px; height: 14px;"></i>
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
                                                    <tr>
                                                        <td>Passports</td>
                                                        <td class="text-center">4</td>
                                                        <td class="text-center">3</td>
                                                        <td class="text-center">1</td>
                                                        <td class="text-center">0</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Visa</td>
                                                        <td class="text-center">4</td>
                                                        <td class="text-center">3</td>
                                                        <td class="text-center">0</td>
                                                        <td class="text-center">1 incorrect</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Pan Card</td>
                                                        <td class="text-center">4</td>
                                                        <td class="text-center">4</td>
                                                        <td class="text-center">0</td>
                                                        <td class="text-center">0</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Voter ID</td>
                                                        <td class="text-center">0</td>
                                                        <td class="text-center">0</td>
                                                        <td class="text-center">0</td>
                                                        <td class="text-center">0</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Driving License</td>
                                                        <td class="text-center">0</td>
                                                        <td class="text-center">0</td>
                                                        <td class="text-center">0</td>
                                                        <td class="text-center">0</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Govt. ID</td>
                                                        <td class="text-center">0</td>
                                                        <td class="text-center">0</td>
                                                        <td class="text-center">0</td>
                                                        <td class="text-center">0</td>
                                                    </tr>
                                                    <tr>
                                                        <td>School ID</td>
                                                        <td class="text-center">1</td>
                                                        <td class="text-center">1</td>
                                                        <td class="text-center">0</td>
                                                        <td class="text-center">0</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Birth Certificate</td>
                                                        <td class="text-center">0</td>
                                                        <td class="text-center">0</td>
                                                        <td class="text-center">0</td>
                                                        <td class="text-center">0</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Marriage Certificate</td>
                                                        <td class="text-center">0</td>
                                                        <td class="text-center">0</td>
                                                        <td class="text-center">0</td>
                                                        <td class="text-center">0</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Aadhar</td>
                                                        <td class="text-center">4</td>
                                                        <td class="text-center">4</td>
                                                        <td class="text-center">0</td>
                                                        <td class="text-center">0</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Photos</td>
                                                        <td class="text-center">4</td>
                                                        <td class="text-center">3</td>
                                                        <td class="text-center">1</td>
                                                        <td class="text-center">0</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Insurance</td>
                                                        <td class="text-center">4</td>
                                                        <td class="text-center">2</td>
                                                        <td class="text-center">2</td>
                                                        <td class="text-center">0</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    @endif

                                    <!-- Vendor Payments Section (Ops Only) -->
                                    @if($isOpsDept ?? false)
                                        <div class="mb-4 border rounded-3 p-3">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <div>
                                                    <h6 class="text-uppercase text-muted small fw-semibold mb-0">
                                                        <i data-feather="dollar-sign" class="me-1" style="width: 14px; height: 14px;"></i>
                                                        Vendor Payments (Ops → Accounts)
                                                    </h6>
                                                </div>
                                                {{-- Ops can always edit Vendor Payments, even in view-only mode --}}
                                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addVendorPaymentModal">
                                                    <i data-feather="plus" style="width: 14px; height: 14px;"></i>
                                                    Add
                                                </button>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-sm mb-0" id="vendorPaymentsTable">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>Vendor Code</th>
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
                                                        @if(isset($vendorPayments) && $vendorPayments->count() > 0)
                                                            @foreach($vendorPayments as $vp)
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
                                                                    <td>{{ $vp->purchase_cost ? number_format($vp->purchase_cost, 2) : '-' }}</td>
                                                                    <td>{{ $vp->due_date ? $vp->due_date->format('d/m/Y') : '-' }}</td>
                                                                    @if (!($isViewOnly && ($isOpsDept || ($isPostSales ?? false))))
                                                                        <td style="background-color: #fff3cd;">{{ $vp->paid_amount ? number_format($vp->paid_amount, 2) : '-' }}</td>
                                                                        <td style="background-color: #fff3cd;">{{ $vp->pending_amount ? number_format($vp->pending_amount, 2) : '-' }}</td>
                                                                        <td style="background-color: #fff3cd;">{{ $vp->payment_mode ?? '-' }}</td>
                                                                        <td style="background-color: #fff3cd;">{{ $vp->ref_no ?? '-' }}</td>
                                                                        <td style="background-color: #fff3cd;">{{ $vp->remarks ?? '-' }}</td>
                                                                    @else
                                                                        <td>
                                                                            <span class="badge bg-{{ $vp->status == 'Paid' ? 'success' : ($vp->status == 'Pending' ? 'warning' : 'secondary') }}">
                                                                                {{ $vp->status ?? 'Pending' }}
                                                                            </span>
                                                                        </td>
                                                                    @endif
                                                                    <td class="text-center">
                                                                        {{-- Ops can always edit/delete Vendor Payments, even in view-only mode --}}
                                                                        <button type="button" class="btn btn-sm btn-outline-primary edit-vendor-payment-btn" data-vendor-payment-id="{{ $vp->id }}" data-bs-toggle="modal" data-bs-target="#addVendorPaymentModal">
                                                                            <i data-feather="edit" style="width: 14px; height: 14px;"></i>
                                                                        </button>
                                                                        <button type="button" class="btn btn-sm btn-outline-danger delete-vendor-payment-btn" data-vendor-payment-id="{{ $vp->id }}">
                                                                            <i data-feather="trash-2" style="width: 14px; height: 14px;"></i>
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            <tr>
                                                                <td colspan="{{ ($isViewOnly && $isOpsDept) ? '7' : '11' }}" class="text-center text-muted py-4">No vendor payments found</td>
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

    <!-- Add Destination Modal -->
    <div class="modal fade" id="addDestinationModal" tabindex="-1" aria-labelledby="addDestinationModalLabel" aria-hidden="true">
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
    <div class="modal fade" id="addArrivalDepartureModal" tabindex="-1" aria-labelledby="addArrivalDepartureModalLabel" aria-hidden="true">
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
                                <input type="text" class="form-control form-control-sm" id="modalInfo" placeholder="Info">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">From City</label>
                                <input type="text" class="form-control form-control-sm" id="modalFromCity" placeholder="From City">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">To City</label>
                                <input type="text" class="form-control form-control-sm" id="modalToCity" placeholder="To City">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Departure Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control form-control-sm" id="modalDepartureDate" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Departure Time</label>
                                <input type="time" class="form-control form-control-sm" id="modalDepartureTime">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Arrival Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control form-control-sm" id="modalArrivalDate" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Arrival Time</label>
                                <input type="time" class="form-control form-control-sm" id="modalArrivalTime">
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
    <div class="modal fade" id="addAccommodationModal" tabindex="-1" aria-labelledby="addAccommodationModalLabel" aria-hidden="true">
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
                                <input type="text" class="form-control form-control-sm" id="modalAccDestination" placeholder="Destination">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Location</label>
                                <input type="text" class="form-control form-control-sm" id="modalAccLocation" placeholder="Location">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Stay At</label>
                                <input type="text" class="form-control form-control-sm" id="modalStayAt" placeholder="Stay At">
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
                                <select class="form-select form-select-sm" id="modalRoomType">
                                    <option value="">-- Select --</option>
                                    <option value="Single">Single</option>
                                    <option value="Double">Double</option>
                                    <option value="Triple">Triple</option>
                                </select>
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
    <div class="modal fade" id="addItineraryModal" tabindex="-1" aria-labelledby="addItineraryModalLabel" aria-hidden="true">
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
                                <input type="text" class="form-control form-control-sm" id="modalDayDate" placeholder="Day & Date">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Time</label>
                                <input type="time" class="form-control form-control-sm" id="modalItineraryTime">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Location</label>
                                <input type="text" class="form-control form-control-sm" id="modalItineraryLocation" placeholder="Location">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Stay At</label>
                                <input type="text" class="form-control form-control-sm" id="modalItineraryStayAt" placeholder="Stay at">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Activity/Tour Description</label>
                                <textarea class="form-control form-control-sm" id="modalActivity" rows="3" placeholder="Activity/Tour Description"></textarea>
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
    @if($isOpsDept ?? false)
    <div class="modal fade" id="addVendorPaymentModal" tabindex="-1" aria-labelledby="addVendorPaymentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addVendorPaymentModalLabel">Add Vendor Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addVendorPaymentForm">
                        @csrf
                        <input type="hidden" id="vendorPaymentId" name="vendor_payment_id" value="">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Vendor Code <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" id="modalVendorCode" name="vendor_code" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Booking Type <span class="text-danger">*</span></label>
                                <select class="form-select form-select-sm" id="modalBookingType" name="booking_type" required>
                                    <option value="">-- Select --</option>
                                    <option value="Hotel">Hotel</option>
                                    <option value="TT">TT</option>
                                    <option value="Hotel + TT">Hotel + TT</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Location <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" id="modalLocation" name="location" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Purchase Cost <span class="text-danger">*</span></label>
                                <input type="number" class="form-control form-control-sm" id="modalPurchaseCost" name="purchase_cost" step="0.01" min="0" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Due Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control form-control-sm" id="modalDueDate" name="due_date" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select form-select-sm" id="modalStatus" name="status" required>
                                    <option value="Pending" selected>Pending</option>
                                    <option value="Paid">Paid</option>
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
                                    locationSelect.disabled = false;
                                })
                                .catch(error => {
                                    console.error('Error loading locations:', error);
                                    locationSelect.innerHTML = '<option value="">Error loading locations</option>';
                                    locationSelect.disabled = false;
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
                    if (addDestinationFromModal()) {
                        // Close modal
                        const modal = bootstrap.Modal.getInstance(document.getElementById('addDestinationModal'));
                        if (modal) {
                            modal.hide();
                        }
                        
                        // Clear modal form
                        document.getElementById('addDestinationForm').reset();
                        document.getElementById('modalLocationSelect').innerHTML = '<option value="">-- Select Location --</option>';
                    }
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
                                    locationSelect.disabled = false;
                                })
                                .catch(error => {
                                    console.error('Error loading locations:', error);
                                    locationSelect.innerHTML = '<option value="">Error loading locations</option>';
                                    locationSelect.disabled = false;
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
                    const departureDate = document.getElementById('modalDepartureDate').value;
                    const departureTime = document.getElementById('modalDepartureTime').value;
                    const arrivalDate = document.getElementById('modalArrivalDate').value;
                    const arrivalTime = document.getElementById('modalArrivalTime').value;

                    // Validation
                    if (!mode || !fromCity || !toCity || !departureDate || !arrivalDate) {
                        alert('Please fill in all required fields (Mode, From City, To City, Departure Date, Arrival Date)');
                        return false;
                    }

                    // Create new data row
                    const tbody = document.getElementById('arrivalDepartureTableBody');
                    const newRow = document.createElement('tr');
                    newRow.className = 'arrival-departure-data-row';
                    newRow.setAttribute('data-row-index', arrivalDepartureRowIndex);

                    const depDateDisplay = formatDateDisplay(departureDate);
                    const arrDateDisplay = formatDateDisplay(arrivalDate);
                    const depTimeDisplay = departureTime ? ' ' + departureTime : '';
                    const arrTimeDisplay = arrivalTime ? ' ' + arrivalTime : '';

                    newRow.innerHTML = `
                        <td>${mode}</td>
                        <td>${info}</td>
                        <td>${fromCity}</td>
                        <td>${toCity}</td>
                        <td>${depDateDisplay}${depTimeDisplay}</td>
                        <td>${arrDateDisplay}${arrTimeDisplay}</td>
                        <td class="text-center">
                            <input type="hidden" name="arrival_departure[${arrivalDepartureRowIndex}][mode]" value="${mode}">
                            <input type="hidden" name="arrival_departure[${arrivalDepartureRowIndex}][info]" value="${info}">
                            <input type="hidden" name="arrival_departure[${arrivalDepartureRowIndex}][from_city]" value="${fromCity}">
                            <input type="hidden" name="arrival_departure[${arrivalDepartureRowIndex}][to_city]" value="${toCity}">
                            <input type="hidden" name="arrival_departure[${arrivalDepartureRowIndex}][departure_date]" value="${departureDate}">
                            <input type="hidden" name="arrival_departure[${arrivalDepartureRowIndex}][departure_time]" value="${departureTime}">
                            <input type="hidden" name="arrival_departure[${arrivalDepartureRowIndex}][arrival_date]" value="${arrivalDate}">
                            <input type="hidden" name="arrival_departure[${arrivalDepartureRowIndex}][arrival_time]" value="${arrivalTime}">
                            <i data-feather="trash-2" class="removeArrivalDepartureRow" style="width: 16px; height: 16px; color: #dc3545; cursor: pointer;"></i>
                        </td>
                    `;

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
                        const modal = bootstrap.Modal.getInstance(document.getElementById('addArrivalDepartureModal'));
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
                });

                // Accommodation table management
                let accommodationRowIndex =
                    {{ $lead->bookingAccommodations ? $lead->bookingAccommodations->count() : 0 }};

                // Function to add accommodation from modal
                function addAccommodationFromModal() {
                    const destination = document.getElementById('modalAccDestination').value;
                    const location = document.getElementById('modalAccLocation').value;
                    const stayAt = document.getElementById('modalStayAt').value;
                    const checkinDate = document.getElementById('modalCheckinDate').value;
                    const checkoutDate = document.getElementById('modalCheckoutDate').value;
                    const roomType = document.getElementById('modalRoomType').value;
                    const mealPlan = document.getElementById('modalMealPlan').value;

                    // Validation
                    if (!destination || !location || !stayAt || !checkinDate || !checkoutDate) {
                        alert('Please fill in all required fields (Destination, Location, Stay At, Check-in Date, Check-out Date)');
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
                            <i data-feather="trash-2" class="removeAccommodationRow" style="width: 16px; height: 16px; color: #dc3545; cursor: pointer;"></i>
                        </td>
                    `;

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
                        const modal = bootstrap.Modal.getInstance(document.getElementById('addAccommodationModal'));
                        if (modal) {
                            modal.hide();
                        }
                        document.getElementById('addAccommodationForm').reset();
                    }
                });

                // Remove accommodation row handler
                document.addEventListener('click', function(e) {
                    if (e.target.closest('.removeAccommodationRow')) {
                        if (!confirm('Are you sure you want to delete this accommodation row?')) {
                            return;
                        }
                        const row = e.target.closest('tr');
                        row.remove();
                    }
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

                // Handle modal form submission
                document.getElementById('submitItineraryModal')?.addEventListener('click', function() {
                    if (addItineraryFromModal()) {
                        const modal = bootstrap.Modal.getInstance(document.getElementById('addItineraryModal'));
                        if (modal) {
                            modal.hide();
                        }
                        document.getElementById('addItineraryForm').reset();
                    }
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
            @if($isOpsDept ?? false)
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
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
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
                                tbody.innerHTML = '<tr><td colspan="11" class="text-center text-muted py-4">No vendor payments found</td></tr>';
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
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
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
        </script>
    @endpush
@endsection
