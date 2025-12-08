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
                                                <label class="form-label">Emergency No.</label>
                                                <input type="text" value="{{ $lead->other_phone ?? '' }}" class="form-control form-control-sm" readonly disabled style="background-color: #f8f9fa; cursor: not-allowed;">
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
                                                        <th style="width: 10%;" class="text-center">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="destinationTableBody">
                                                    <!-- Always show input row for new entry first -->
                                                    <tr class="destination-input-row" data-is-input-row="true">
                                                        <td>
                                                            <select class="form-select form-select-sm destination-select-input" {{ $disabledAttr }} {!! $disabledStyle !!}>
                                                                <option value="">-- Select Destination --</option>
                                                                @foreach($destinations as $dest)
                                                                    <option value="{{ $dest->name }}" data-destination-id="{{ $dest->id }}">{{ $dest->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select class="form-select form-select-sm location-select-input" {{ $disabledAttr }} {!! $disabledStyle !!}>
                                                                <option value="">-- Select Location --</option>
                                                            </select>
                                                        </td>
                                                        <td class="text-center">
                                                            <input type="checkbox" class="form-check-input only-hotel-input" {{ $disabledAttr }}>
                                                        </td>
                                                        <td class="text-center">
                                                            <input type="checkbox" class="form-check-input only-tt-input" {{ $disabledAttr }}>
                                                        </td>
                                                        <td class="text-center">
                                                            <input type="checkbox" class="form-check-input hotel-tt-input" {{ $disabledAttr }}>
                                                        </td>
                                                        <td>
                                                            <input type="date" class="form-control form-control-sm from-date-input" {{ $disabledAttr }} {!! $disabledStyle !!}>
                                                        </td>
                                                        <td>
                                                            <input type="date" class="form-control form-control-sm to-date-input" {{ $disabledAttr }} {!! $disabledStyle !!}>
                                                        </td>
                                                        <td class="text-center">
                                                            @if(!$isViewOnly)
                                                                <button type="button" class="btn btn-sm btn-primary addDestinationFromInput">
                                                                    <i data-feather="plus" style="width: 14px; height: 14px;"></i>
                                                                    Add
                                                                </button>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @if($lead->bookingDestinations && $lead->bookingDestinations->count() > 0)
                                                        @foreach($lead->bookingDestinations as $index => $bd)
                                                            <tr class="destination-data-row" data-destination-id="{{ $bd->id }}" data-row-index="{{ $index }}">
                                                                <td>{{ $bd->destination }}</td>
                                                                <td>{{ $bd->location }}</td>
                                                                <td class="text-center">
                                                                    @if($bd->only_hotel)
                                                                        <i data-feather="check" style="width: 16px; height: 16px; color: #28a745;"></i>
                                                                    @endif
                                                                </td>
                                                                <td class="text-center">
                                                                    @if($bd->only_tt)
                                                                        <i data-feather="check" style="width: 16px; height: 16px; color: #28a745;"></i>
                                                                    @endif
                                                                </td>
                                                                <td class="text-center">
                                                                    @if($bd->hotel_tt)
                                                                        <i data-feather="check" style="width: 16px; height: 16px; color: #28a745;"></i>
                                                                    @endif
                                                                </td>
                                                                <td>{{ $bd->from_date ? $bd->from_date->format('d/m/Y') : '' }}</td>
                                                                <td>{{ $bd->to_date ? $bd->to_date->format('d/m/Y') : '' }}</td>
                                                                <td class="text-center">
                                                                    @if(!$isViewOnly)
                                                                        <input type="hidden" name="booking_destinations[{{ $index }}][id]" value="{{ $bd->id }}">
                                                                        <input type="hidden" name="booking_destinations[{{ $index }}][destination]" value="{{ $bd->destination }}">
                                                                        <input type="hidden" name="booking_destinations[{{ $index }}][location]" value="{{ $bd->location }}">
                                                                        <input type="hidden" name="booking_destinations[{{ $index }}][only_hotel]" value="{{ $bd->only_hotel ? '1' : '0' }}">
                                                                        <input type="hidden" name="booking_destinations[{{ $index }}][only_tt]" value="{{ $bd->only_tt ? '1' : '0' }}">
                                                                        <input type="hidden" name="booking_destinations[{{ $index }}][hotel_tt]" value="{{ $bd->hotel_tt ? '1' : '0' }}">
                                                                        <input type="hidden" name="booking_destinations[{{ $index }}][from_date]" value="{{ $bd->from_date ? $bd->from_date->format('Y-m-d') : '' }}">
                                                                        <input type="hidden" name="booking_destinations[{{ $index }}][to_date]" value="{{ $bd->to_date ? $bd->to_date->format('Y-m-d') : '' }}">
                                                                        <i data-feather="trash-2" class="removeDestinationRow" style="width: 16px; height: 16px; color: #dc3545; cursor: pointer;"></i>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
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
                                                    <!-- Always show input row for new entry first -->
                                                    <tr class="arrival-departure-input-row" data-is-input-row="true">
                                                        <td>
                                                            <select class="form-select form-select-sm mode-input" {{ $disabledAttr }} {!! $disabledStyle !!}>
                                                                <option value="By Air">By Air</option>
                                                                <option value="By Surface">By Surface</option>
                                                                <option value="By Sea">By Sea</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control form-control-sm info-input" placeholder="Info" {{ $disabledAttr }} {!! $disabledStyle !!}>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control form-control-sm from-city-input" placeholder="From City" {{ $disabledAttr }} {!! $disabledStyle !!}>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control form-control-sm to-city-input" placeholder="To City" {{ $disabledAttr }} {!! $disabledStyle !!}>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex gap-1">
                                                                <input type="date" class="form-control form-control-sm departure-date-input" style="flex: 1;" {{ $disabledAttr }} {!! $disabledStyle !!}>
                                                                <input type="time" class="form-control form-control-sm departure-time-input" style="flex: 1;" {{ $disabledAttr }} {!! $disabledStyle !!}>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex gap-1">
                                                                <input type="date" class="form-control form-control-sm arrival-date-input" style="flex: 1;" {{ $disabledAttr }} {!! $disabledStyle !!}>
                                                                <input type="time" class="form-control form-control-sm arrival-time-input" style="flex: 1;" {{ $disabledAttr }} {!! $disabledStyle !!}>
                                                            </div>
                                                        </td>
                                                        <td class="text-center">
                                                            @if(!$isViewOnly)
                                                                <button type="button" class="btn btn-sm btn-primary addArrivalDepartureFromInput">
                                                                    <i data-feather="plus" style="width: 14px; height: 14px;"></i>
                                                                    Add
                                                                </button>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @php
                                                        $allTransports = $lead->bookingArrivalDepartures ?? collect();
                                                    @endphp
                                                    @if($allTransports && $allTransports->count() > 0)
                                                        @foreach($allTransports as $index => $transport)
                                                            <tr class="arrival-departure-data-row" data-transport-id="{{ $transport->id }}" data-row-index="{{ $index }}">
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
                                                                <td class="text-center">
                                                                    @if(!$isViewOnly)
                                                                        <input type="hidden" name="arrival_departure[{{ $index }}][id]" value="{{ $transport->id }}">
                                                                        <input type="hidden" name="arrival_departure[{{ $index }}][mode]" value="{{ $transport->mode }}">
                                                                        <input type="hidden" name="arrival_departure[{{ $index }}][info]" value="{{ $transport->info }}">
                                                                        <input type="hidden" name="arrival_departure[{{ $index }}][from_city]" value="{{ $transport->from_city }}">
                                                                        <input type="hidden" name="arrival_departure[{{ $index }}][to_city]" value="{{ $transport->to_city ?? '' }}">
                                                                        <input type="hidden" name="arrival_departure[{{ $index }}][departure_date]" value="{{ $transport->departure_date ? ($transport->departure_date instanceof \DateTime ? $transport->departure_date->format('Y-m-d') : $transport->departure_date) : '' }}">
                                                                        <input type="hidden" name="arrival_departure[{{ $index }}][departure_time]" value="{{ $transport->departure_time ? substr($transport->departure_time, 0, 5) : '' }}">
                                                                        <input type="hidden" name="arrival_departure[{{ $index }}][arrival_date]" value="{{ $transport->arrival_date ? ($transport->arrival_date instanceof \DateTime ? $transport->arrival_date->format('Y-m-d') : $transport->arrival_date) : '' }}">
                                                                        <input type="hidden" name="arrival_departure[{{ $index }}][arrival_time]" value="{{ $transport->arrival_time ? substr($transport->arrival_time, 0, 5) : '' }}">
                                                                        <i data-feather="trash-2" class="removeArrivalDepartureRow" style="width: 16px; height: 16px; color: #dc3545; cursor: pointer;"></i>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
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
                                                        <th style="width: 4%;" class="text-center">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="accommodationTableBody">
                                                    <!-- Always show input row for new entry first -->
                                                    <tr class="accommodation-input-row" data-is-input-row="true">
                                                        <td>
                                                            <input type="text" class="form-control form-control-sm destination-input" placeholder="Destination" {{ $disabledAttr }} {!! $disabledStyle !!}>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control form-control-sm location-input" placeholder="Location" {{ $disabledAttr }} {!! $disabledStyle !!}>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control form-control-sm stay-at-input" placeholder="Stay At" {{ $disabledAttr }} {!! $disabledStyle !!}>
                                                        </td>
                                                        <td>
                                                            <input type="date" class="form-control form-control-sm checkin-date-input" {{ $disabledAttr }} {!! $disabledStyle !!}>
                                                        </td>
                                                        <td>
                                                            <input type="date" class="form-control form-control-sm checkout-date-input" {{ $disabledAttr }} {!! $disabledStyle !!}>
                                                        </td>
                                                        <td>
                                                            <select class="form-select form-select-sm room-type-input" {{ $disabledAttr }} {!! $disabledStyle !!}>
                                                                <option value="">-- Select --</option>
                                                                <option value="Single">Single</option>
                                                                <option value="Double">Double</option>
                                                                <option value="Triple">Triple</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select class="form-select form-select-sm meal-plan-input" {{ $disabledAttr }} {!! $disabledStyle !!}>
                                                                <option value="">-- Select --</option>
                                                                <option value="CP">CP</option>
                                                                <option value="MAP">MAP</option>
                                                                <option value="AP">AP</option>
                                                                <option value="AI">AI</option>
                                                            </select>
                                                        </td>
                                                        <td class="text-center">
                                                            @if(!$isViewOnly)
                                                                <button type="button" class="btn btn-sm btn-primary addAccommodationFromInput">
                                                                    <i data-feather="plus" style="width: 14px; height: 14px;"></i>
                                                                    Add
                                                                </button>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @if($lead->bookingAccommodations && $lead->bookingAccommodations->count() > 0)
                                                        @foreach($lead->bookingAccommodations as $index => $ba)
                                                            <tr class="accommodation-data-row" data-row-index="{{ $index }}">
                                                                <td>{{ $ba->destination }}</td>
                                                                <td>{{ $ba->location }}</td>
                                                                <td>{{ $ba->stay_at }}</td>
                                                                <td>{{ $ba->checkin_date ? $ba->checkin_date->format('d/m/Y') : '' }}</td>
                                                                <td>{{ $ba->checkout_date ? $ba->checkout_date->format('d/m/Y') : '' }}</td>
                                                                <td>{{ $ba->room_type }}</td>
                                                                <td>{{ $ba->meal_plan }}</td>
                                                                <td class="text-center">
                                                                    @if(!$isViewOnly)
                                                                        <input type="hidden" name="booking_accommodations[{{ $index }}][id]" value="{{ $ba->id }}">
                                                                        <input type="hidden" name="booking_accommodations[{{ $index }}][destination]" value="{{ $ba->destination }}">
                                                                        <input type="hidden" name="booking_accommodations[{{ $index }}][location]" value="{{ $ba->location }}">
                                                                        <input type="hidden" name="booking_accommodations[{{ $index }}][stay_at]" value="{{ $ba->stay_at }}">
                                                                        <input type="hidden" name="booking_accommodations[{{ $index }}][checkin_date]" value="{{ $ba->checkin_date ? $ba->checkin_date->format('Y-m-d') : '' }}">
                                                                        <input type="hidden" name="booking_accommodations[{{ $index }}][checkout_date]" value="{{ $ba->checkout_date ? $ba->checkout_date->format('Y-m-d') : '' }}">
                                                                        <input type="hidden" name="booking_accommodations[{{ $index }}][room_type]" value="{{ $ba->room_type }}">
                                                                        <input type="hidden" name="booking_accommodations[{{ $index }}][meal_plan]" value="{{ $ba->meal_plan }}">
                                                                        <i data-feather="trash-2" class="removeAccommodationRow" style="width: 16px; height: 16px; color: #dc3545; cursor: pointer;"></i>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
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
                                                        <th style="width: 7%;" class="text-center">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="itineraryTableBody">
                                                    <!-- Always show input row for new entry first -->
                                                    <tr class="itinerary-input-row" data-is-input-row="true">
                                                        <td>
                                                            <input type="text" class="form-control form-control-sm day-date-input" placeholder="Day & Date" {{ $disabledAttr }} {!! $disabledStyle !!}>
                                                        </td>
                                                        <td>
                                                            <input type="time" class="form-control form-control-sm time-input" {{ $disabledAttr }} {!! $disabledStyle !!}>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control form-control-sm location-input" placeholder="Location" {{ $disabledAttr }} {!! $disabledStyle !!}>
                                                        </td>
                                                        <td>
                                                            <textarea class="form-control form-control-sm activity-input" rows="2" placeholder="Activity/Tour Description" {{ $disabledAttr }} {!! $disabledStyle !!}></textarea>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control form-control-sm stay-at-input" placeholder="Stay at" {{ $disabledAttr }} {!! $disabledStyle !!}>
                                                        </td>
                                                        <td>
                                                            <textarea class="form-control form-control-sm remarks-input" rows="2" placeholder="Remarks" {{ $disabledAttr }} {!! $disabledStyle !!}></textarea>
                                                        </td>
                                                        <td class="text-center">
                                                            @if(!$isViewOnly)
                                                                <button type="button" class="btn btn-sm btn-primary addItineraryFromInput">
                                                                    <i data-feather="plus" style="width: 14px; height: 14px;"></i>
                                                                    Add
                                                                </button>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @if($lead->bookingItineraries && $lead->bookingItineraries->count() > 0)
                                                        @foreach($lead->bookingItineraries as $index => $bi)
                                                            <tr class="itinerary-data-row" data-row-index="{{ $index }}">
                                                                <td>{{ $bi->day_and_date }}</td>
                                                                <td>{{ $bi->time ? substr($bi->time, 0, 5) : '' }}</td>
                                                                <td>{{ $bi->location }}</td>
                                                                <td>{{ $bi->activity_tour_description }}</td>
                                                                <td>{{ $bi->stay_at }}</td>
                                                                <td>{{ $bi->remarks }}</td>
                                                                <td class="text-center">
                                                                    @if(!$isViewOnly)
                                                                        <input type="hidden" name="booking_itineraries[{{ $index }}][id]" value="{{ $bi->id }}">
                                                                        <input type="hidden" name="booking_itineraries[{{ $index }}][day_and_date]" value="{{ $bi->day_and_date }}">
                                                                        <input type="hidden" name="booking_itineraries[{{ $index }}][time]" value="{{ $bi->time ? substr($bi->time, 0, 5) : '' }}">
                                                                        <input type="hidden" name="booking_itineraries[{{ $index }}][location]" value="{{ $bi->location }}">
                                                                        <input type="hidden" name="booking_itineraries[{{ $index }}][activity_tour_description]" value="{{ $bi->activity_tour_description }}">
                                                                        <input type="hidden" name="booking_itineraries[{{ $index }}][stay_at]" value="{{ $bi->stay_at }}">
                                                                        <input type="hidden" name="booking_itineraries[{{ $index }}][remarks]" value="{{ $bi->remarks }}">
                                                                        <i data-feather="trash-2" class="removeItineraryRow" style="width: 16px; height: 16px; color: #dc3545; cursor: pointer;"></i>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
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

                // Function to load locations for input row destination
                function loadLocationsForInputRow(destinationSelect) {
                    const locationSelect = document.querySelector('.location-select-input');
                    const destinationId = destinationSelect.options[destinationSelect.selectedIndex]?.getAttribute('data-destination-id');
                    
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

                // Handle destination change in input row
                const destinationSelectInput = document.querySelector('.destination-select-input');
                if (destinationSelectInput) {
                    destinationSelectInput.addEventListener('change', function() {
                        loadLocationsForInputRow(this);
                    });
                }

                // Handle service type checkboxes mutual exclusivity in input row
                const serviceTypeCheckboxes = document.querySelectorAll('.only-hotel-input, .only-tt-input, .hotel-tt-input');
                serviceTypeCheckboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        if (this.checked) {
                            serviceTypeCheckboxes.forEach(cb => {
                                if (cb !== this) {
                                    cb.checked = false;
                                }
                            });
                        }
                    });
                });

                // Function to add destination from input row
                function addDestinationFromInput() {
                    const inputRow = document.querySelector('.destination-input-row');
                    const destination = inputRow.querySelector('.destination-select-input').value;
                    const location = inputRow.querySelector('.location-select-input').value;
                    const onlyHotel = inputRow.querySelector('.only-hotel-input').checked;
                    const onlyTT = inputRow.querySelector('.only-tt-input').checked;
                    const hotelTT = inputRow.querySelector('.hotel-tt-input').checked;
                    const fromDate = inputRow.querySelector('.from-date-input').value;
                    const toDate = inputRow.querySelector('.to-date-input').value;

                    // Validation
                    if (!destination || !location || !fromDate || !toDate) {
                        alert('Please fill in all required fields (Destination, Location, From Date, To Date)');
                        return;
                    }

                    if (!onlyHotel && !onlyTT && !hotelTT) {
                        alert('Please select at least one service type (Only Hotel, Only TT, or Hotel + TT)');
                        return;
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
                    let onlyHotelMark = onlyHotel ? '<i data-feather="check" style="width: 16px; height: 16px; color: #28a745;"></i>' : '';
                    let onlyTTMark = onlyTT ? '<i data-feather="check" style="width: 16px; height: 16px; color: #28a745;"></i>' : '';
                    let hotelTTMark = hotelTT ? '<i data-feather="check" style="width: 16px; height: 16px; color: #28a745;"></i>' : '';

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

                    // Insert after the input row (so input row stays first)
                    if (inputRow && inputRow.nextSibling) {
                        tbody.insertBefore(newRow, inputRow.nextSibling);
                    } else {
                        tbody.appendChild(newRow);
                    }

                    // Clear input row
                    inputRow.querySelector('.destination-select-input').value = '';
                    inputRow.querySelector('.location-select-input').innerHTML = '<option value="">-- Select Location --</option>';
                    inputRow.querySelector('.only-hotel-input').checked = false;
                    inputRow.querySelector('.only-tt-input').checked = false;
                    inputRow.querySelector('.hotel-tt-input').checked = false;
                    inputRow.querySelector('.from-date-input').value = '';
                    inputRow.querySelector('.to-date-input').value = '';

                    // Re-initialize Feather icons
                    if (typeof feather !== 'undefined') {
                        feather.replace();
                    }

                    destinationRowIndex++;

                    // Check itinerary visibility
                    checkItineraryVisibility();
                }

                // Handle Add button click
                document.addEventListener('click', function(e) {
                    if (e.target.closest('.addDestinationFromInput')) {
                        e.preventDefault();
                        addDestinationFromInput();
                    }
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

                // Function to add arrival/departure from input row
                function addArrivalDepartureFromInput() {
                    const inputRow = document.querySelector('.arrival-departure-input-row');
                    const mode = inputRow.querySelector('.mode-input').value;
                    const info = inputRow.querySelector('.info-input').value;
                    const fromCity = inputRow.querySelector('.from-city-input').value;
                    const toCity = inputRow.querySelector('.to-city-input').value;
                    const departureDate = inputRow.querySelector('.departure-date-input').value;
                    const departureTime = inputRow.querySelector('.departure-time-input').value;
                    const arrivalDate = inputRow.querySelector('.arrival-date-input').value;
                    const arrivalTime = inputRow.querySelector('.arrival-time-input').value;

                    // Validation
                    if (!mode || !fromCity || !toCity || !departureDate || !arrivalDate) {
                        alert('Please fill in all required fields (Mode, From City, To City, Departure Date, Arrival Date)');
                        return;
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

                    // Insert after the input row
                    if (inputRow && inputRow.nextSibling) {
                        tbody.insertBefore(newRow, inputRow.nextSibling);
                    } else {
                        tbody.appendChild(newRow);
                    }

                    // Clear input row
                    inputRow.querySelector('.mode-input').value = 'By Air';
                    inputRow.querySelector('.info-input').value = '';
                    inputRow.querySelector('.from-city-input').value = '';
                    inputRow.querySelector('.to-city-input').value = '';
                    inputRow.querySelector('.departure-date-input').value = '';
                    inputRow.querySelector('.departure-time-input').value = '';
                    inputRow.querySelector('.arrival-date-input').value = '';
                    inputRow.querySelector('.arrival-time-input').value = '';

                    // Re-initialize Feather icons
                    if (typeof feather !== 'undefined') {
                        feather.replace();
                    }

                    arrivalDepartureRowIndex++;
                }

                // Handle Add button click
                document.addEventListener('click', function(e) {
                    if (e.target.closest('.addArrivalDepartureFromInput')) {
                        e.preventDefault();
                        addArrivalDepartureFromInput();
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
                let accommodationRowIndex = {{ $lead->bookingAccommodations ? $lead->bookingAccommodations->count() : 0 }};

                // Function to add accommodation from input row
                function addAccommodationFromInput() {
                    const inputRow = document.querySelector('.accommodation-input-row');
                    const destination = inputRow.querySelector('.destination-input').value;
                    const location = inputRow.querySelector('.location-input').value;
                    const stayAt = inputRow.querySelector('.stay-at-input').value;
                    const checkinDate = inputRow.querySelector('.checkin-date-input').value;
                    const checkoutDate = inputRow.querySelector('.checkout-date-input').value;
                    const roomType = inputRow.querySelector('.room-type-input').value;
                    const mealPlan = inputRow.querySelector('.meal-plan-input').value;

                    // Validation
                    if (!destination || !location || !stayAt || !checkinDate || !checkoutDate) {
                        alert('Please fill in all required fields (Destination, Location, Stay At, Check-in Date, Check-out Date)');
                        return;
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

                    // Insert after the input row
                    if (inputRow && inputRow.nextSibling) {
                        tbody.insertBefore(newRow, inputRow.nextSibling);
                    } else {
                        tbody.appendChild(newRow);
                    }

                    // Clear input row
                    inputRow.querySelector('.destination-input').value = '';
                    inputRow.querySelector('.location-input').value = '';
                    inputRow.querySelector('.stay-at-input').value = '';
                    inputRow.querySelector('.checkin-date-input').value = '';
                    inputRow.querySelector('.checkout-date-input').value = '';
                    inputRow.querySelector('.room-type-input').value = '';
                    inputRow.querySelector('.meal-plan-input').value = '';

                    // Re-initialize Feather icons
                    if (typeof feather !== 'undefined') {
                        feather.replace();
                    }

                    accommodationRowIndex++;
                }

                // Handle Add button click
                document.addEventListener('click', function(e) {
                    if (e.target.closest('.addAccommodationFromInput')) {
                        e.preventDefault();
                        addAccommodationFromInput();
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

                // Function to add itinerary from input row
                function addItineraryFromInput() {
                    const inputRow = document.querySelector('.itinerary-input-row');
                    const dayDate = inputRow.querySelector('.day-date-input').value;
                    const time = inputRow.querySelector('.time-input').value;
                    const location = inputRow.querySelector('.location-input').value;
                    const activity = inputRow.querySelector('.activity-input').value;
                    const stayAt = inputRow.querySelector('.stay-at-input').value;
                    const remarks = inputRow.querySelector('.remarks-input').value;

                    // Validation
                    if (!dayDate || !location || !activity) {
                        alert('Please fill in all required fields (Day & Date, Location, Activity/Tour Description)');
                        return;
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

                    // Insert after the input row
                    if (inputRow && inputRow.nextSibling) {
                        tbody.insertBefore(newRow, inputRow.nextSibling);
                    } else {
                        tbody.appendChild(newRow);
                    }

                    // Clear input row
                    inputRow.querySelector('.day-date-input').value = '';
                    inputRow.querySelector('.time-input').value = '';
                    inputRow.querySelector('.location-input').value = '';
                    inputRow.querySelector('.activity-input').value = '';
                    inputRow.querySelector('.stay-at-input').value = '';
                    inputRow.querySelector('.remarks-input').value = '';

                    // Re-initialize Feather icons
                    if (typeof feather !== 'undefined') {
                        feather.replace();
                    }

                    itineraryRowIndex++;
                }

                // Handle Add button click
                document.addEventListener('click', function(e) {
                    if (e.target.closest('.addItineraryFromInput')) {
                        e.preventDefault();
                        addItineraryFromInput();
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
                        
                        if ((onlyTTInput && onlyTTInput.value === '1') || (hotelTTInput && hotelTTInput.value === '1')) {
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
                const inputServiceTypeCheckboxes = document.querySelectorAll('.only-hotel-input, .only-tt-input, .hotel-tt-input');
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

