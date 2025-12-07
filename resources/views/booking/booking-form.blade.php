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
                                    <a href="{{ $backUrl ?? route('bookings.index') }}" class="btn btn-icon btn-flush-dark btn-rounded flush-soft-hover">
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
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif

                                @php
                                    $isViewOnly = $isViewOnly ?? false;
                                    $disabledAttr = $isViewOnly ? 'readonly disabled' : '';
                                    $disabledStyle = $isViewOnly ? 'style="background-color: #f8f9fa; cursor: not-allowed;"' : '';
                                @endphp

                                <form id="bookingFileForm" method="POST" action="{{ route('leads.update', $lead) }}" @if($isViewOnly) onsubmit="return false;" @endif>
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
                                                <input type="text" value="{{ $lead->tsq }}" class="form-control form-control-sm" readonly disabled style="background-color: #f8f9fa; cursor: not-allowed;">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Salutation</label>
                                                <input type="text" value="{{ $lead->salutation ?? '' }}" class="form-control form-control-sm" readonly disabled style="background-color: #f8f9fa; cursor: not-allowed;">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">First Name</label>
                                                <input type="text" value="{{ $lead->first_name }}" class="form-control form-control-sm" readonly disabled style="background-color: #f8f9fa; cursor: not-allowed;">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Middle Name</label>
                                                <input type="text" value="{{ $lead->middle_name ?? '' }}" class="form-control form-control-sm" readonly disabled style="background-color: #f8f9fa; cursor: not-allowed;">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Last Name</label>
                                                <input type="text" value="{{ $lead->last_name ?? '' }}" class="form-control form-control-sm" readonly disabled style="background-color: #f8f9fa; cursor: not-allowed;">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Contact 1</label>
                                                <input type="text" value="{{ $lead->primary_phone ?? $lead->phone }}" class="form-control form-control-sm" readonly disabled style="background-color: #f8f9fa; cursor: not-allowed;">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Contact 2</label>
                                                <input type="text" value="{{ $lead->secondary_phone ?? '' }}" class="form-control form-control-sm" readonly disabled style="background-color: #f8f9fa; cursor: not-allowed;">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Email ID</label>
                                                <input type="email" value="{{ $lead->email }}" class="form-control form-control-sm" readonly disabled style="background-color: #f8f9fa; cursor: not-allowed;">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">No. of Adult(s)</label>
                                                <input type="number" value="{{ $lead->adults }}" class="form-control form-control-sm" readonly disabled style="background-color: #f8f9fa; cursor: not-allowed;">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Child (2-5 years)</label>
                                                <input type="number" value="{{ $lead->children_2_5 ?? 0 }}" class="form-control form-control-sm" readonly disabled style="background-color: #f8f9fa; cursor: not-allowed;">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Child (6-11 years)</label>
                                                <input type="number" value="{{ $lead->children_6_11 ?? 0 }}" class="form-control form-control-sm" readonly disabled style="background-color: #f8f9fa; cursor: not-allowed;">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Infant (>2 years)</label>
                                                <input type="number" value="{{ $lead->infants ?? 0 }}" class="form-control form-control-sm" readonly disabled style="background-color: #f8f9fa; cursor: not-allowed;">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Booked By</label>
                                                <input type="text" value="{{ $lead->bookedBy?->name ?? 'N/A' }}" class="form-control form-control-sm" readonly disabled style="background-color: #f8f9fa; cursor: not-allowed;">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Created By</label>
                                                <input type="text" value="{{ $lead->createdBy?->name ?? 'N/A' }}" class="form-control form-control-sm" readonly disabled style="background-color: #f8f9fa; cursor: not-allowed;">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Booked On</label>
                                                <input type="text" value="{{ $lead->booked_on ? $lead->booked_on->format('d M, Y h:i A') : 'N/A' }}" class="form-control form-control-sm" readonly disabled style="background-color: #f8f9fa; cursor: not-allowed;">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Re-assign To</label>
                                                @if($isViewOnly)
                                                    <input type="text" value="{{ $lead->reassignedTo?->name ?? 'N/A' }}" class="form-control form-control-sm" readonly disabled style="background-color: #f8f9fa; cursor: not-allowed;">
                                                @else
                                                    <select name="reassigned_to" class="form-select form-select-sm">
                                                        <option value="">-- Select User --</option>
                                                        @foreach($users as $user)
                                                            <option value="{{ $user->id }}" {{ old('reassigned_to', $lead->reassigned_to) == $user->id ? 'selected' : '' }}>
                                                                {{ $user->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Destination Section -->
                                    <div class="mb-4 border rounded-3 p-3 bg-light">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h6 class="text-uppercase text-muted small fw-semibold mb-0">
                                                <i data-feather="map-pin" class="me-1" style="width: 14px; height: 14px;"></i>
                                                Destination
                                            </h6>
                                            @if(!$isViewOnly)
                                                <button type="button" class="btn btn-sm btn-primary" id="addDestinationRow">
                                                    <i data-feather="plus" class="me-1" style="width: 14px; height: 14px;"></i>
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
                                                        <th style="width: 10%;">Duration</th>
                                                        <th style="width: 10%;" class="text-center">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="destinationTableBody">
                                                    @if($lead->bookingDestinations && $lead->bookingDestinations->count() > 0)
                                                        @foreach($lead->bookingDestinations as $index => $bd)
                                                            <tr data-row-index="{{ $index }}">
                                                                <td>
                                                                    <select name="booking_destinations[{{ $index }}][destination]" 
                                                                        class="form-select form-select-sm destination-select" 
                                                                        data-row-index="{{ $index }}" {{ $disabledAttr }} {!! $disabledStyle !!}>
                                                                        <option value="">-- Select Destination --</option>
                                                                        @foreach($destinations as $dest)
                                                                            <option value="{{ $dest->name }}" 
                                                                                {{ $bd->destination == $dest->name ? 'selected' : '' }}
                                                                                data-destination-id="{{ $dest->id }}">
                                                                                {{ $dest->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <select name="booking_destinations[{{ $index }}][location]" 
                                                                        class="form-select form-select-sm location-select" 
                                                                        data-row-index="{{ $index }}" {{ $disabledAttr }} {!! $disabledStyle !!}>
                                                                        <option value="">-- Select Location --</option>
                                                                        @php
                                                                            $selectedDestination = $destinations->firstWhere('name', $bd->destination);
                                                                            if ($selectedDestination && $selectedDestination->locations) {
                                                                                foreach ($selectedDestination->locations->where('is_active', true)->sortBy('name') as $loc) {
                                                                                    echo '<option value="' . htmlspecialchars($loc->name) . '" ' . ($bd->location == $loc->name ? 'selected' : '') . '>' . htmlspecialchars($loc->name) . '</option>';
                                                                                }
                                                                            }
                                                                        @endphp
                                                                    </select>
                                                                </td>
                                                                <td class="text-center">
                                                                    <input type="checkbox" name="booking_destinations[{{ $index }}][only_hotel]" 
                                                                        value="1" {{ $bd->only_hotel ? 'checked' : '' }} 
                                                                        class="form-check-input service-type-checkbox" {{ $disabledAttr }}>
                                                                </td>
                                                                <td class="text-center">
                                                                    <input type="checkbox" name="booking_destinations[{{ $index }}][only_tt]" 
                                                                        value="1" {{ $bd->only_tt ? 'checked' : '' }} 
                                                                        class="form-check-input service-type-checkbox" {{ $disabledAttr }}>
                                                                </td>
                                                                <td class="text-center">
                                                                    <input type="checkbox" name="booking_destinations[{{ $index }}][hotel_tt]" 
                                                                        value="1" {{ $bd->hotel_tt ? 'checked' : '' }} 
                                                                        class="form-check-input service-type-checkbox" {{ $disabledAttr }}>
                                                                </td>
                                                                <td>
                                                                    <input type="date" name="booking_destinations[{{ $index }}][from_date]" 
                                                                        value="{{ $bd->from_date ? $bd->from_date->format('Y-m-d') : '' }}" 
                                                                        class="form-control form-control-sm destination-from-date" {{ $disabledAttr }} {!! $disabledStyle !!}>
                                                                </td>
                                                                <td>
                                                                    <input type="date" name="booking_destinations[{{ $index }}][to_date]" 
                                                                        value="{{ $bd->to_date ? $bd->to_date->format('Y-m-d') : '' }}" 
                                                                        class="form-control form-control-sm destination-to-date" {{ $disabledAttr }} {!! $disabledStyle !!}>
                                                                </td>
                                                                <td>
                                                                    <input type="text" 
                                                                        value="{{ $bd->no_of_days ? $bd->no_of_days . ($bd->only_hotel ? ' Nights' : ' Days') : '' }}" 
                                                                        class="form-control form-control-sm destination-duration" readonly>
                                                                </td>
                                                                <td class="text-center">
                                                                    @if(!$isViewOnly)
                                                                        <button type="button" class="btn btn-sm btn-danger removeDestinationRow">
                                                                            <i data-feather="trash-2" style="width: 14px; height: 14px;"></i>
                                                                        </button>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr class="empty-row-message">
                                                            <td colspan="9" class="text-center text-muted py-3">
                                                                No destinations added. Click "Add" to add a destination.
                                                            </td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- Arrival/Departure Details Section -->
                                    <div class="mb-4 border rounded-3 p-3">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h6 class="text-uppercase text-muted small fw-semibold mb-0">
                                                <i data-feather="navigation" class="me-1" style="width: 14px; height: 14px;"></i>
                                                Arrival/Departure Details
                                            </h6>
                                            @if(!$isViewOnly)
                                                <button type="button" class="btn btn-sm btn-primary" id="addArrivalDepartureRow">
                                                    <i data-feather="plus" class="me-1" style="width: 14px; height: 14px;"></i>
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
                                                        <th style="width: 13%;" class="text-center">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="arrivalDepartureTableBody">
                                                    @php
                                                        $allTransports = $lead->bookingArrivalDepartures ?? collect();
                                                    @endphp
                                                    @if($allTransports && $allTransports->count() > 0)
                                                        @foreach($allTransports as $index => $transport)
                                                            <tr data-row-index="{{ $index }}" data-transport-id="{{ $transport->id }}">
                                                                <td>
                                                                    <select name="arrival_departure[{{ $index }}][mode]" class="form-select form-select-sm transport-mode-select">
                                                                        <option value="By Air" {{ $transport->mode == 'By Air' ? 'selected' : '' }}>By Air</option>
                                                                        <option value="By Surface" {{ $transport->mode == 'By Surface' ? 'selected' : '' }}>By Surface</option>
                                                                        <option value="By Sea" {{ $transport->mode == 'By Sea' ? 'selected' : '' }}>By Sea</option>
                                                                    </select>
                                                                    <input type="hidden" name="arrival_departure[{{ $index }}][id]" value="{{ $transport->id }}">
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="arrival_departure[{{ $index }}][info]" 
                                                                        value="{{ $transport->info }}" 
                                                                        class="form-control form-control-sm" placeholder="Info">
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="arrival_departure[{{ $index }}][from_city]" 
                                                                        value="{{ $transport->from_city }}" 
                                                                        class="form-control form-control-sm" placeholder="From City">
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="arrival_departure[{{ $index }}][to_city]" 
                                                                        value="{{ $transport->to_city ?? '' }}" 
                                                                        class="form-control form-control-sm" placeholder="To City">
                                                                </td>
                                                                <td>
                                                                    <div class="d-flex gap-1">
                                                                        <input type="date" name="arrival_departure[{{ $index }}][departure_date]" 
                                                                            value="{{ $transport->departure_date ? ($transport->departure_date instanceof \DateTime ? $transport->departure_date->format('Y-m-d') : $transport->departure_date) : '' }}" 
                                                                            class="form-control form-control-sm" style="flex: 1;">
                                                                        <input type="time" name="arrival_departure[{{ $index }}][departure_time]" 
                                                                            value="{{ $transport->departure_time ? substr($transport->departure_time, 0, 5) : '' }}" 
                                                                            class="form-control form-control-sm" style="flex: 1;">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="d-flex gap-1">
                                                                        <input type="date" name="arrival_departure[{{ $index }}][arrival_date]" 
                                                                            value="{{ $transport->arrival_date ? ($transport->arrival_date instanceof \DateTime ? $transport->arrival_date->format('Y-m-d') : $transport->arrival_date) : '' }}" 
                                                                            class="form-control form-control-sm" style="flex: 1;">
                                                                        <input type="time" name="arrival_departure[{{ $index }}][arrival_time]" 
                                                                            value="{{ $transport->arrival_time ? substr($transport->arrival_time, 0, 5) : '' }}" 
                                                                            class="form-control form-control-sm" style="flex: 1;">
                                                                    </div>
                                                                </td>
                                                                <td class="text-center">
                                                                    @if(!$isViewOnly)
                                                                        <button type="button" class="btn btn-sm btn-danger removeArrivalDepartureRow">
                                                                            <i data-feather="trash-2" style="width: 14px; height: 14px;"></i>
                                                                        </button>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr class="empty-row-message">
                                                            <td colspan="7" class="text-center text-muted py-3">
                                                                No arrival/departure details added. Click "Add" to add details.
                                                            </td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- Accommodation Details Section -->
                                    <div class="mb-4 border rounded-3 p-3 bg-light">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h6 class="text-uppercase text-muted small fw-semibold mb-0">
                                                <i data-feather="home" class="me-1" style="width: 14px; height: 14px;"></i>
                                                Accommodation Details
                                            </h6>
                                            @if(!$isViewOnly)
                                                <button type="button" class="btn btn-sm btn-primary" id="addAccommodationRow">
                                                    <i data-feather="plus" class="me-1" style="width: 14px; height: 14px;"></i>
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
                                                        <th style="width: 12%;">Booking Status</th>
                                                        <th style="width: 4%;" class="text-center">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="accommodationTableBody">
                                                    @if($lead->bookingAccommodations && $lead->bookingAccommodations->count() > 0)
                                                        @foreach($lead->bookingAccommodations as $index => $ba)
                                                            <tr data-row-index="{{ $index }}">
                                                                <td>
                                                                    <input type="text" name="booking_accommodations[{{ $index }}][destination]" 
                                                                        value="{{ $ba->destination }}" 
                                                                        class="form-control form-control-sm" placeholder="Destination">
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="booking_accommodations[{{ $index }}][location]" 
                                                                        value="{{ $ba->location }}" 
                                                                        class="form-control form-control-sm" placeholder="Location">
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="booking_accommodations[{{ $index }}][stay_at]" 
                                                                        value="{{ $ba->stay_at }}" 
                                                                        class="form-control form-control-sm" placeholder="Stay At">
                                                                </td>
                                                                <td>
                                                                    <input type="date" name="booking_accommodations[{{ $index }}][checkin_date]" 
                                                                        value="{{ $ba->checkin_date ? $ba->checkin_date->format('Y-m-d') : '' }}" 
                                                                        class="form-control form-control-sm">
                                                                </td>
                                                                <td>
                                                                    <input type="date" name="booking_accommodations[{{ $index }}][checkout_date]" 
                                                                        value="{{ $ba->checkout_date ? $ba->checkout_date->format('Y-m-d') : '' }}" 
                                                                        class="form-control form-control-sm">
                                                                </td>
                                                                <td>
                                                                    <select name="booking_accommodations[{{ $index }}][room_type]" class="form-select form-select-sm">
                                                                        <option value="">-- Select --</option>
                                                                        <option value="Single" {{ $ba->room_type == 'Single' ? 'selected' : '' }}>Single</option>
                                                                        <option value="Double" {{ $ba->room_type == 'Double' ? 'selected' : '' }}>Double</option>
                                                                        <option value="Triple" {{ $ba->room_type == 'Triple' ? 'selected' : '' }}>Triple</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <select name="booking_accommodations[{{ $index }}][meal_plan]" class="form-select form-select-sm">
                                                                        <option value="">-- Select --</option>
                                                                        <option value="CP" {{ $ba->meal_plan == 'CP' ? 'selected' : '' }}>CP</option>
                                                                        <option value="MAP" {{ $ba->meal_plan == 'MAP' ? 'selected' : '' }}>MAP</option>
                                                                        <option value="AP" {{ $ba->meal_plan == 'AP' ? 'selected' : '' }}>AP</option>
                                                                        <option value="AI" {{ $ba->meal_plan == 'AI' ? 'selected' : '' }}>AI</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <select name="booking_accommodations[{{ $index }}][booking_status]" class="form-select form-select-sm">
                                                                        <option value="Pending" {{ $ba->booking_status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                                                        <option value="In Progress" {{ $ba->booking_status == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                                                        <option value="Complete" {{ $ba->booking_status == 'Complete' ? 'selected' : '' }}>Complete</option>
                                                                    </select>
                                                                </td>
                                                                <td class="text-center">
                                                                    @if(!$isViewOnly)
                                                                        <button type="button" class="btn btn-sm btn-danger removeAccommodationRow">
                                                                            <i data-feather="trash-2" style="width: 14px; height: 14px;"></i>
                                                                        </button>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr class="empty-row-message">
                                                            <td colspan="9" class="text-center text-muted py-3">
                                                                No accommodations added. Click "Add" to add an accommodation.
                                                            </td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- Day-Wise Itinerary Section -->
                                    <div class="mb-4 border rounded-3 p-3" id="dayWiseItinerarySection" style="display: none;">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h6 class="text-uppercase text-muted small fw-semibold mb-0">
                                                <i data-feather="calendar" class="me-1" style="width: 14px; height: 14px;"></i>
                                                Day-Wise Itinerary
                                            </h6>
                                            @if(!$isViewOnly)
                                                <button type="button" class="btn btn-sm btn-primary" id="addItineraryRow">
                                                    <i data-feather="plus" class="me-1" style="width: 14px; height: 14px;"></i>
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
                                                        <th style="width: 10%;">Service Type</th>
                                                        <th style="width: 10%;">Location</th>
                                                        <th style="width: 20%;">Activity/Tour Description</th>
                                                        <th style="width: 10%;">Stay at</th>
                                                        <th style="width: 8%;" class="text-center">Sure? (Y/N)</th>
                                                        <th style="width: 15%;">Remarks</th>
                                                        <th style="width: 7%;" class="text-center">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="itineraryTableBody">
                                                    @if($lead->bookingItineraries && $lead->bookingItineraries->count() > 0)
                                                        @foreach($lead->bookingItineraries as $index => $bi)
                                                            <tr data-row-index="{{ $index }}">
                                                                <td>
                                                                    <input type="text" name="booking_itineraries[{{ $index }}][day_and_date]" 
                                                                        value="{{ $bi->day_and_date }}" 
                                                                        class="form-control form-control-sm" placeholder="Day & Date">
                                                                </td>
                                                                <td>
                                                                    <input type="time" name="booking_itineraries[{{ $index }}][time]" 
                                                                        value="{{ $bi->time ? substr($bi->time, 0, 5) : '' }}" 
                                                                        class="form-control form-control-sm">
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="booking_itineraries[{{ $index }}][service_type]" 
                                                                        value="{{ $bi->service_type }}" 
                                                                        class="form-control form-control-sm" placeholder="Service Type">
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="booking_itineraries[{{ $index }}][location]" 
                                                                        value="{{ $bi->location }}" 
                                                                        class="form-control form-control-sm" placeholder="Location">
                                                                </td>
                                                                <td>
                                                                    <textarea name="booking_itineraries[{{ $index }}][activity_tour_description]" 
                                                                        class="form-control form-control-sm" rows="2" placeholder="Activity/Tour Description">{{ $bi->activity_tour_description }}</textarea>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="booking_itineraries[{{ $index }}][stay_at]" 
                                                                        value="{{ $bi->stay_at }}" 
                                                                        class="form-control form-control-sm" placeholder="Stay at">
                                                                </td>
                                                                <td class="text-center">
                                                                    <select name="booking_itineraries[{{ $index }}][sure]" class="form-select form-select-sm">
                                                                        <option value="">-- Select --</option>
                                                                        <option value="Y" {{ $bi->sure == 'Y' ? 'selected' : '' }}>Y</option>
                                                                        <option value="N" {{ $bi->sure == 'N' ? 'selected' : '' }}>N</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <textarea name="booking_itineraries[{{ $index }}][remarks]" 
                                                                        class="form-control form-control-sm" rows="2" placeholder="Remarks">{{ $bi->remarks }}</textarea>
                                                                </td>
                                                                <td class="text-center">
                                                                    @if(!$isViewOnly)
                                                                        <button type="button" class="btn btn-sm btn-danger removeItineraryRow">
                                                                            <i data-feather="trash-2" style="width: 14px; height: 14px;"></i>
                                                                        </button>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr class="empty-row-message">
                                                            <td colspan="9" class="text-center text-muted py-3">
                                                                No itinerary items added. Click "Add" to add an itinerary item.
                                                            </td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    @if(!$isViewOnly)
                                        <div class="d-flex justify-content-end gap-2 mb-4">
                                            <a href="{{ $backUrl ?? route('bookings.index') }}" class="btn btn-light border">Cancel</a>
                                            <button type="submit" class="btn btn-primary">Save Booking File</button>
                                        </div>
                                    @else
                                        <div class="d-flex justify-content-end gap-2 mb-4">
                                            <a href="{{ $backUrl ?? route('bookings.index') }}" class="btn btn-light border">Back</a>
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

    @push('scripts')
        <script>
            $(document).ready(function() {
                // Disable all form inputs if in view-only mode
                @if($isViewOnly)
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

                // Function to add new destination row
                function addDestinationRow() {
                    const tbody = document.getElementById('destinationTableBody');
                    const emptyRow = tbody.querySelector('.empty-row-message');
                    if (emptyRow) {
                        emptyRow.remove();
                    }

                    const newRow = document.createElement('tr');
                    newRow.setAttribute('data-row-index', destinationRowIndex);
                    
                    // Build destination options
                    let destinationOptions = '<option value="">-- Select Destination --</option>';
                    @foreach($destinations as $dest)
                        destinationOptions += '<option value="{{ $dest->name }}" data-destination-id="{{ $dest->id }}">{{ $dest->name }}</option>';
                    @endforeach
                    
                    newRow.innerHTML = `
                        <td>
                            <select name="booking_destinations[${destinationRowIndex}][destination]" 
                                class="form-select form-select-sm destination-select" 
                                data-row-index="${destinationRowIndex}">
                                ${destinationOptions}
                            </select>
                        </td>
                        <td>
                            <select name="booking_destinations[${destinationRowIndex}][location]" 
                                class="form-select form-select-sm location-select" 
                                data-row-index="${destinationRowIndex}">
                                <option value="">-- Select Location --</option>
                            </select>
                        </td>
                                                        <td class="text-center">
                                                            <input type="checkbox" name="booking_destinations[${destinationRowIndex}][only_hotel]" 
                                                                value="1" class="form-check-input service-type-checkbox">
                                                        </td>
                                                        <td class="text-center">
                                                            <input type="checkbox" name="booking_destinations[${destinationRowIndex}][only_tt]" 
                                                                value="1" class="form-check-input service-type-checkbox">
                                                        </td>
                                                        <td class="text-center">
                                                            <input type="checkbox" name="booking_destinations[${destinationRowIndex}][hotel_tt]" 
                                                                value="1" class="form-check-input service-type-checkbox">
                                                        </td>
                        <td>
                            <input type="date" name="booking_destinations[${destinationRowIndex}][from_date]" 
                                class="form-control form-control-sm destination-from-date">
                        </td>
                        <td>
                            <input type="date" name="booking_destinations[${destinationRowIndex}][to_date]" 
                                class="form-control form-control-sm destination-to-date">
                        </td>
                        <td>
                            <input type="text" 
                                class="form-control form-control-sm destination-duration" readonly>
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm btn-danger removeDestinationRow">
                                <i data-feather="trash-2" style="width: 14px; height: 14px;"></i>
                            </button>
                        </td>
                    `;
                    tbody.appendChild(newRow);

                    // Re-initialize Feather icons
                    if (typeof feather !== 'undefined') {
                        feather.replace();
                    }

                    // Attach event listeners for date calculation
                    attachDurationCalculation(newRow);

                    // Attach mutual exclusivity handler for service type checkboxes
                    attachServiceTypeHandlers(newRow);

                    // Attach destination change handler
                    attachDestinationChangeHandler(newRow);

                    destinationRowIndex++;
                }

                // Function to load locations for a selected destination
                function loadLocationsForDestination(destinationSelect) {
                    const rowIndex = destinationSelect.getAttribute('data-row-index');
                    const locationSelect = document.querySelector(`select.location-select[data-row-index="${rowIndex}"]`);
                    const destinationId = destinationSelect.options[destinationSelect.selectedIndex]?.getAttribute('data-destination-id');
                    
                    // Clear existing options except the first one
                    if (locationSelect) {
                        locationSelect.innerHTML = '<option value="">-- Select Location --</option>';
                        
                        if (destinationId) {
                            // Show loading state
                            locationSelect.disabled = true;
                            locationSelect.innerHTML = '<option value="">Loading locations...</option>';
                            
                            // Fetch locations from API
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

                // Function to attach destination change handler
                function attachDestinationChangeHandler(row) {
                    const destinationSelect = row.querySelector('.destination-select');
                    if (destinationSelect) {
                        destinationSelect.addEventListener('change', function() {
                            loadLocationsForDestination(this);
                        });
                    }
                }

                // Function to calculate duration based on service type
                function calculateDuration(row) {
                    const fromDateInput = row.querySelector('.destination-from-date');
                    const toDateInput = row.querySelector('.destination-to-date');
                    const durationInput = row.querySelector('.destination-duration');
                    const onlyHotelCheckbox = row.querySelector('input[name*="[only_hotel]"]');
                    const onlyTTCheckbox = row.querySelector('input[name*="[only_tt]"]');
                    const hotelTTCheckbox = row.querySelector('input[name*="[hotel_tt]"]');

                    if (!fromDateInput || !toDateInput || !durationInput) {
                        return;
                    }

                    if (fromDateInput.value && toDateInput.value) {
                        const from = new Date(fromDateInput.value);
                        const to = new Date(toDateInput.value);
                        
                        if (to >= from) {
                            const diffTime = to - from;
                            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                            
                            // Determine service type
                            let serviceType = '';
                            if (onlyHotelCheckbox && onlyHotelCheckbox.checked) {
                                serviceType = 'nights';
                                durationInput.value = diffDays + ' Nights';
                            } else if ((onlyTTCheckbox && onlyTTCheckbox.checked) || 
                                      (hotelTTCheckbox && hotelTTCheckbox.checked)) {
                                serviceType = 'days';
                                durationInput.value = diffDays + ' Days';
                            } else {
                                // No service type selected, show days as default
                                durationInput.value = diffDays + ' Days';
                            }
                        } else {
                            durationInput.value = '';
                        }
                    } else {
                        durationInput.value = '';
                    }
                }

                // Function to attach duration calculation handlers
                function attachDurationCalculation(row) {
                    const fromDateInput = row.querySelector('.destination-from-date');
                    const toDateInput = row.querySelector('.destination-to-date');
                    const serviceTypeCheckboxes = row.querySelectorAll('.service-type-checkbox');

                    // Calculate on date change
                    if (fromDateInput && toDateInput) {
                        fromDateInput.addEventListener('change', () => calculateDuration(row));
                        toDateInput.addEventListener('change', () => calculateDuration(row));
                    }

                    // Calculate on service type change
                    serviceTypeCheckboxes.forEach(checkbox => {
                        checkbox.addEventListener('change', () => calculateDuration(row));
                    });

                    // Calculate initial duration if dates are already set
                    calculateDuration(row);
                }

                // Function to handle mutual exclusivity for service type checkboxes
                function attachServiceTypeHandlers(row) {
                    const checkboxes = row.querySelectorAll('.service-type-checkbox');
                    checkboxes.forEach(checkbox => {
                        checkbox.addEventListener('change', function() {
                            if (this.checked) {
                                // Uncheck other checkboxes in the same row
                                checkboxes.forEach(cb => {
                                    if (cb !== this) {
                                        cb.checked = false;
                                    }
                                });
                            }
                            // Recalculate duration when service type changes
                            calculateDuration(row);
                        });
                    });
                }

                // Attach handlers to existing rows
                document.querySelectorAll('#destinationTableBody tr').forEach(row => {
                    if (!row.classList.contains('empty-row-message')) {
                        attachServiceTypeHandlers(row);
                        attachDurationCalculation(row);
                        attachDestinationChangeHandler(row);
                    }
                });

                // Add row button click handler
                const addDestinationBtn = document.getElementById('addDestinationRow');
                if (addDestinationBtn) {
                    addDestinationBtn.addEventListener('click', addDestinationRow);
                }

                // Remove row button click handler (using event delegation)
                document.addEventListener('click', function(e) {
                    if (e.target.closest('.removeDestinationRow')) {
                        if (!confirm('Are you sure you want to delete this destination row?')) {
                            return;
                        }
                        const row = e.target.closest('tr');
                        const tbody = document.getElementById('destinationTableBody');
                        row.remove();
                        
                        // Add default row if no rows left (instead of showing empty message)
                        if (tbody.children.length === 0 || (tbody.children.length === 1 && tbody.querySelector('.empty-row-message'))) {
                            const emptyRow = tbody.querySelector('.empty-row-message');
                            if (emptyRow) {
                                emptyRow.remove();
                            }
                            addDestinationRow();
                        }
                        
                        // Check itinerary visibility after removing destination row
                        checkItineraryVisibility();
                    }
                });

                // Add default row if destination table is empty
                const destinationTbody = document.getElementById('destinationTableBody');
                const hasDestinationEmptyMessage = destinationTbody.querySelector('.empty-row-message');
                const hasDestinationExistingRows = destinationTbody.querySelectorAll('tr[data-row-index]').length > 0;
                
                if (hasDestinationEmptyMessage && !hasDestinationExistingRows) {
                    // Remove empty message and add default row
                    addDestinationRow();
                }

                // Arrival/Departure unified table management
                @php
                    $totalTransports = $lead->bookingArrivalDepartures ? $lead->bookingArrivalDepartures->count() : 0;
                @endphp
                let arrivalDepartureRowIndex = {{ $totalTransports }};

                // Function to add new arrival/departure row
                function addArrivalDepartureRow() {
                    const tbody = document.getElementById('arrivalDepartureTableBody');
                    const emptyRow = tbody.querySelector('.empty-row-message');
                    if (emptyRow) {
                        emptyRow.remove();
                    }

                    const newRow = document.createElement('tr');
                    newRow.setAttribute('data-row-index', arrivalDepartureRowIndex);
                    newRow.innerHTML = `
                        <td>
                            <select name="arrival_departure[${arrivalDepartureRowIndex}][mode]" class="form-select form-select-sm transport-mode-select">
                                <option value="By Air">By Air</option>
                                <option value="By Surface">By Surface</option>
                                <option value="By Sea">By Sea</option>
                            </select>
                            <input type="hidden" name="arrival_departure[${arrivalDepartureRowIndex}][type]" value="new">
                        </td>
                        <td>
                            <input type="text" name="arrival_departure[${arrivalDepartureRowIndex}][info]" 
                                class="form-control form-control-sm" placeholder="Info">
                        </td>
                        <td>
                            <input type="text" name="arrival_departure[${arrivalDepartureRowIndex}][from_city]" 
                                class="form-control form-control-sm" placeholder="From City">
                        </td>
                        <td>
                            <input type="text" name="arrival_departure[${arrivalDepartureRowIndex}][to_city]" 
                                class="form-control form-control-sm" placeholder="To City">
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <input type="date" name="arrival_departure[${arrivalDepartureRowIndex}][departure_date]" 
                                    class="form-control form-control-sm" style="flex: 1;">
                                <input type="time" name="arrival_departure[${arrivalDepartureRowIndex}][departure_time]" 
                                    class="form-control form-control-sm" style="flex: 1;">
                            </div>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <input type="date" name="arrival_departure[${arrivalDepartureRowIndex}][arrival_date]" 
                                    class="form-control form-control-sm" style="flex: 1;">
                                <input type="time" name="arrival_departure[${arrivalDepartureRowIndex}][arrival_time]" 
                                    class="form-control form-control-sm" style="flex: 1;">
                            </div>
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm btn-danger removeArrivalDepartureRow">
                                <i data-feather="trash-2" style="width: 14px; height: 14px;"></i>
                            </button>
                        </td>
                    `;
                    tbody.appendChild(newRow);

                    // Re-initialize Feather icons
                    if (typeof feather !== 'undefined') {
                        feather.replace();
                    }

                    arrivalDepartureRowIndex++;
                }

                // Add arrival/departure row button click handler
                const addArrivalDepartureBtn = document.getElementById('addArrivalDepartureRow');
                if (addArrivalDepartureBtn) {
                    addArrivalDepartureBtn.addEventListener('click', addArrivalDepartureRow);
                }

                // Remove arrival/departure row button click handler (using event delegation)
                document.addEventListener('click', function(e) {
                    if (e.target.closest('.removeArrivalDepartureRow')) {
                        if (!confirm('Are you sure you want to delete this arrival/departure row?')) {
                            return;
                        }
                        const row = e.target.closest('tr');
                        const tbody = document.getElementById('arrivalDepartureTableBody');
                        row.remove();
                        
                        // Add default row if no rows left (instead of showing empty message)
                        if (tbody.children.length === 0 || (tbody.children.length === 1 && tbody.querySelector('.empty-row-message'))) {
                            const emptyRow = tbody.querySelector('.empty-row-message');
                            if (emptyRow) {
                                emptyRow.remove();
                            }
                            addArrivalDepartureRow();
                        }
                    }
                });

                // Add default row if table is empty
                const arrivalDepartureTbody = document.getElementById('arrivalDepartureTableBody');
                const hasEmptyMessage = arrivalDepartureTbody.querySelector('.empty-row-message');
                const hasExistingRows = arrivalDepartureTbody.querySelectorAll('tr[data-row-index]').length > 0;
                
                if (hasEmptyMessage && !hasExistingRows) {
                    // Remove empty message and add default row
                    addArrivalDepartureRow();
                }

                // Accommodation table management
                let accommodationRowIndex = {{ $lead->bookingAccommodations ? $lead->bookingAccommodations->count() : 0 }};

                // Function to add new accommodation row
                function addAccommodationRow() {
                    const tbody = document.getElementById('accommodationTableBody');
                    const emptyRow = tbody.querySelector('.empty-row-message');
                    if (emptyRow) {
                        emptyRow.remove();
                    }

                    const newRow = document.createElement('tr');
                    newRow.setAttribute('data-row-index', accommodationRowIndex);
                    newRow.innerHTML = `
                        <td>
                            <input type="text" name="booking_accommodations[${accommodationRowIndex}][destination]" 
                                class="form-control form-control-sm" placeholder="Destination">
                        </td>
                        <td>
                            <input type="text" name="booking_accommodations[${accommodationRowIndex}][location]" 
                                class="form-control form-control-sm" placeholder="Location">
                        </td>
                        <td>
                            <input type="text" name="booking_accommodations[${accommodationRowIndex}][stay_at]" 
                                class="form-control form-control-sm" placeholder="Stay At">
                        </td>
                        <td>
                            <input type="date" name="booking_accommodations[${accommodationRowIndex}][checkin_date]" 
                                class="form-control form-control-sm">
                        </td>
                        <td>
                            <input type="date" name="booking_accommodations[${accommodationRowIndex}][checkout_date]" 
                                class="form-control form-control-sm">
                        </td>
                        <td>
                            <select name="booking_accommodations[${accommodationRowIndex}][room_type]" class="form-select form-select-sm">
                                <option value="">-- Select --</option>
                                <option value="Single">Single</option>
                                <option value="Double">Double</option>
                                <option value="Triple">Triple</option>
                            </select>
                        </td>
                        <td>
                            <select name="booking_accommodations[${accommodationRowIndex}][meal_plan]" class="form-select form-select-sm">
                                <option value="">-- Select --</option>
                                <option value="CP">CP</option>
                                <option value="MAP">MAP</option>
                                <option value="AP">AP</option>
                                <option value="AI">AI</option>
                            </select>
                        </td>
                        <td>
                            <select name="booking_accommodations[${accommodationRowIndex}][booking_status]" class="form-select form-select-sm">
                                <option value="Pending">Pending</option>
                                <option value="In Progress">In Progress</option>
                                <option value="Complete">Complete</option>
                            </select>
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm btn-danger removeAccommodationRow">
                                <i data-feather="trash-2" style="width: 14px; height: 14px;"></i>
                            </button>
                        </td>
                    `;
                    tbody.appendChild(newRow);

                    // Re-initialize Feather icons
                    if (typeof feather !== 'undefined') {
                        feather.replace();
                    }

                    accommodationRowIndex++;
                }

                // Add accommodation row button click handler
                const addAccommodationBtn = document.getElementById('addAccommodationRow');
                if (addAccommodationBtn) {
                    addAccommodationBtn.addEventListener('click', addAccommodationRow);
                }

                // Remove accommodation row button click handler (using event delegation)
                document.addEventListener('click', function(e) {
                    if (e.target.closest('.removeAccommodationRow')) {
                        if (!confirm('Are you sure you want to delete this accommodation row?')) {
                            return;
                        }
                        const row = e.target.closest('tr');
                        const tbody = document.getElementById('accommodationTableBody');
                        row.remove();
                        
                        // Add default row if no rows left (instead of showing empty message)
                        if (tbody.children.length === 0 || (tbody.children.length === 1 && tbody.querySelector('.empty-row-message'))) {
                            const emptyRow = tbody.querySelector('.empty-row-message');
                            if (emptyRow) {
                                emptyRow.remove();
                            }
                            addAccommodationRow();
                        }
                    }
                });

                // Add default row if accommodation table is empty
                const accommodationTbody = document.getElementById('accommodationTableBody');
                const hasAccommodationEmptyMessage = accommodationTbody.querySelector('.empty-row-message');
                const hasAccommodationExistingRows = accommodationTbody.querySelectorAll('tr[data-row-index]').length > 0;
                
                if (hasAccommodationEmptyMessage && !hasAccommodationExistingRows) {
                    // Remove empty message and add default row
                    addAccommodationRow();
                }

                // Itinerary table management
                let itineraryRowIndex = {{ $lead->bookingItineraries ? $lead->bookingItineraries->count() : 0 }};

                // Function to add new itinerary row
                function addItineraryRow() {
                    const tbody = document.getElementById('itineraryTableBody');
                    const emptyRow = tbody.querySelector('.empty-row-message');
                    if (emptyRow) {
                        emptyRow.remove();
                    }

                    const newRow = document.createElement('tr');
                    newRow.setAttribute('data-row-index', itineraryRowIndex);
                    newRow.innerHTML = `
                        <td>
                            <input type="text" name="booking_itineraries[${itineraryRowIndex}][day_and_date]" 
                                class="form-control form-control-sm" placeholder="Day & Date">
                        </td>
                        <td>
                            <input type="time" name="booking_itineraries[${itineraryRowIndex}][time]" 
                                class="form-control form-control-sm">
                        </td>
                        <td>
                            <input type="text" name="booking_itineraries[${itineraryRowIndex}][service_type]" 
                                class="form-control form-control-sm" placeholder="Service Type">
                        </td>
                        <td>
                            <input type="text" name="booking_itineraries[${itineraryRowIndex}][location]" 
                                class="form-control form-control-sm" placeholder="Location">
                        </td>
                        <td>
                            <textarea name="booking_itineraries[${itineraryRowIndex}][activity_tour_description]" 
                                class="form-control form-control-sm" rows="2" placeholder="Activity/Tour Description"></textarea>
                        </td>
                        <td>
                            <input type="text" name="booking_itineraries[${itineraryRowIndex}][stay_at]" 
                                class="form-control form-control-sm" placeholder="Stay at">
                        </td>
                        <td class="text-center">
                            <select name="booking_itineraries[${itineraryRowIndex}][sure]" class="form-select form-select-sm">
                                <option value="">-- Select --</option>
                                <option value="Y">Y</option>
                                <option value="N">N</option>
                            </select>
                        </td>
                        <td>
                            <textarea name="booking_itineraries[${itineraryRowIndex}][remarks]" 
                                class="form-control form-control-sm" rows="2" placeholder="Remarks"></textarea>
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm btn-danger removeItineraryRow">
                                <i data-feather="trash-2" style="width: 14px; height: 14px;"></i>
                            </button>
                        </td>
                    `;
                    tbody.appendChild(newRow);

                    // Re-initialize Feather icons
                    if (typeof feather !== 'undefined') {
                        feather.replace();
                    }

                    itineraryRowIndex++;
                }

                // Add itinerary row button click handler
                const addItineraryBtn = document.getElementById('addItineraryRow');
                if (addItineraryBtn) {
                    addItineraryBtn.addEventListener('click', addItineraryRow);
                }

                // Remove itinerary row button click handler (using event delegation)
                document.addEventListener('click', function(e) {
                    if (e.target.closest('.removeItineraryRow')) {
                        if (!confirm('Are you sure you want to delete this itinerary row?')) {
                            return;
                        }
                        const row = e.target.closest('tr');
                        const tbody = document.getElementById('itineraryTableBody');
                        row.remove();
                        
                        // Add default row if no rows left (instead of showing empty message)
                        if (tbody.children.length === 0 || (tbody.children.length === 1 && tbody.querySelector('.empty-row-message'))) {
                            const emptyRow = tbody.querySelector('.empty-row-message');
                            if (emptyRow) {
                                emptyRow.remove();
                            }
                            addItineraryRow();
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
                    const destinationRows = destinationTableBody.querySelectorAll('tr[data-row-index]');
                    
                    destinationRows.forEach(row => {
                        const onlyTT = row.querySelector('input[name*="[only_tt]"]');
                        const hotelTT = row.querySelector('input[name*="[hotel_tt]"]');
                        
                        if ((onlyTT && onlyTT.checked) || (hotelTT && hotelTT.checked)) {
                            shouldShow = true;
                        }
                    });

                    // Show/hide itinerary section
                    if (shouldShow) {
                        itinerarySection.style.display = '';
                        
                        // Add default row if table is empty
                        const itineraryTbody = document.getElementById('itineraryTableBody');
                        const hasItineraryEmptyMessage = itineraryTbody.querySelector('.empty-row-message');
                        const hasItineraryExistingRows = itineraryTbody.querySelectorAll('tr[data-row-index]').length > 0;
                        
                        if (hasItineraryEmptyMessage && !hasItineraryExistingRows) {
                            const emptyRow = itineraryTbody.querySelector('.empty-row-message');
                            if (emptyRow) {
                                emptyRow.remove();
                            }
                            addItineraryRow();
                        }
                    } else {
                        itinerarySection.style.display = 'none';
                    }
                }

                // Check itinerary visibility when service type checkboxes change
                document.addEventListener('change', function(e) {
                    if (e.target.classList.contains('service-type-checkbox')) {
                        checkItineraryVisibility();
                    }
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
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || formData.get('_token'),
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
                                window.scrollTo({ top: 0, behavior: 'smooth' });

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
                                window.scrollTo({ top: 0, behavior: 'smooth' });
                            })
                            .finally(() => {
                                // Re-enable submit button
                                submitButton.disabled = false;
                                submitButton.textContent = originalButtonText;
                            });
                    });
                }
            });
        </script>
    @endpush
@endsection

