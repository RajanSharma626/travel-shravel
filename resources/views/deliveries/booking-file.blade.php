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
                                <div class="d-flex align-items-center gap-3 flex-grow-1">
                                    <a href="{{ $backUrl ?? route('deliveries.index') }}"
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
                                <div class="d-flex align-items-center gap-2">
                                  
                                    @can('edit leads')
                                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                            data-bs-target="#reassignLeadModal">
                                            <i data-feather="user-check" class="me-1" style="width: 14px; height: 14px;"></i>
                                            Re-assign
                                        </button>
                                    @endcan
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

                                <!-- Customer Details Section (View Mode) -->
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
                                        <div class="col-md-3">
                                            <label class="form-label">Sales Cost</label>
                                            <input type="text"
                                                value="{{ $lead->selling_price ? number_format($lead->selling_price, 2) : '0.00' }}"
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

                                <!-- Destination Section (View Mode) -->
                                <div class="mb-4 border rounded-3 p-3">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h6 class="text-uppercase text-muted small fw-semibold mb-0">
                                            <i data-feather="map-pin" class="me-1" style="width: 14px; height: 14px;"></i>
                                            Destination
                                        </h6>
                                        @php
                                            $hasDestinationData = $lead->bookingDestinations && $lead->bookingDestinations->count() > 0;
                                        @endphp
                                        <a href="{{ route('deliveries.download-voucher', ['lead' => $lead, 'type' => 'destination']) }}" 
                                           class="btn btn-sm btn-outline-success {{ !$hasDestinationData ? 'disabled' : '' }}" 
                                           target="_blank"
                                           @if(!$hasDestinationData) onclick="return false;" style="pointer-events: none; opacity: 0.6;" @endif>
                                            <i data-feather="download" class="me-1" style="width: 14px; height: 14px;"></i>
                                            Download Voucher
                                        </a>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th style="width: 15%;">Destination</th>
                                                    <th style="width: 15%;">Location</th>
                                                    <th style="width: 12%;" class="text-center">Only Hotel</th>
                                                    <th style="width: 12%;" class="text-center">Only TT</th>
                                                    <th style="width: 12%;" class="text-center">Hotel + TT</th>
                                                    <th style="width: 10%;">From Date</th>
                                                    <th style="width: 10%;">To Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($lead->bookingDestinations && $lead->bookingDestinations->count() > 0)
                                                    @foreach ($lead->bookingDestinations as $bd)
                                                        <tr>
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
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="7" class="text-center text-muted py-4">
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

                                <!-- Arrival/Departure Details Section (View Mode) -->
                                <div class="mb-4 border rounded-3 p-3">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h6 class="text-uppercase text-muted small fw-semibold mb-0">
                                            <i data-feather="navigation" class="me-1" style="width: 14px; height: 14px;"></i>
                                            Arrival/Departure Details
                                        </h6>
                                        @php
                                            $hasArrivalDepartureData = $lead->bookingArrivalDepartures && $lead->bookingArrivalDepartures->count() > 0;
                                        @endphp
                                        <a href="{{ route('deliveries.download-voucher', ['lead' => $lead, 'type' => 'service-voucher']) }}" 
                                           class="btn btn-sm btn-outline-success {{ !$hasArrivalDepartureData ? 'disabled' : '' }}" 
                                           target="_blank"
                                           @if(!$hasArrivalDepartureData) onclick="return false;" style="pointer-events: none; opacity: 0.6;" @endif>
                                            <i data-feather="download" class="me-1" style="width: 14px; height: 14px;"></i>
                                            Download Voucher
                                        </a>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th style="width: 12%;" rowspan="2">Mode</th>
                                                    <th style="width: 15%;" rowspan="2">Info</th>
                                                    <th style="width: 12%;" rowspan="2">From City</th>
                                                    <th style="width: 12%;" rowspan="2">To City</th>
                                                    <th colspan="2" style="width: 18%;">Dep Date & Time</th>
                                                    <th colspan="2" style="width: 18%;">Arrival Date & Time</th>
                                                </tr>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Time</th>
                                                    <th>Date</th>
                                                    <th>Time</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $allTransports = $lead->bookingArrivalDepartures ?? collect();
                                                @endphp
                                                @if ($allTransports && $allTransports->count() > 0)
                                                    @foreach ($allTransports as $transport)
                                                        <tr>
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
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="8" class="text-center text-muted py-4">
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

                                <!-- Day-Wise Itinerary Section (View Mode) -->
                                <div class="mb-4 border rounded-3 p-3" id="dayWiseItinerarySection">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h6 class="text-uppercase text-muted small fw-semibold mb-0">
                                            <i data-feather="calendar" class="me-1" style="width: 14px; height: 14px;"></i>
                                            Day-Wise Itinerary
                                        </h6>
                                        @php
                                            $hasItineraryData = $lead->bookingItineraries && $lead->bookingItineraries->count() > 0;
                                        @endphp
                                        <a href="{{ route('deliveries.download-voucher', ['lead' => $lead, 'type' => 'itinerary']) }}" 
                                           class="btn btn-sm btn-outline-success {{ !$hasItineraryData ? 'disabled' : '' }}" 
                                           target="_blank"
                                           @if(!$hasItineraryData) onclick="return false;" style="pointer-events: none; opacity: 0.6;" @endif>
                                            <i data-feather="download" class="me-1" style="width: 14px; height: 14px;"></i>
                                            Download Voucher
                                        </a>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th style="width: 12%;">Day & Date</th>
                                                    <th style="width: 8%;">Time</th>
                                                    <th style="width: 10%;">Location</th>
                                                    <th style="width: 20%;">Activity/Tour Description</th>
                                                    <th style="width: 10%;">Stay at</th>
                                                    <th style="width: 15%;">Remarks</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($lead->bookingItineraries && $lead->bookingItineraries->count() > 0)
                                                    @foreach ($lead->bookingItineraries as $bi)
                                                        <tr>
                                                            <td>{{ $bi->day_and_date }}</td>
                                                            <td>{{ $bi->time ? substr($bi->time, 0, 5) : '' }}</td>
                                                            <td>{{ $bi->location }}</td>
                                                            <td>
                                                                @if ($bi->activity_tour_description)
                                                                    @php
                                                                        $text = str_replace(
                                                                            ["\r\n", "\r"],
                                                                            "\n",
                                                                            $bi->activity_tour_description,
                                                                        );
                                                                        $activities = array_filter(
                                                                            array_map('trim', explode("\n", $text)),
                                                                            function ($item) {
                                                                                return !empty($item);
                                                                            },
                                                                        );
                                                                    @endphp
                                                                    @if (count($activities) > 0)
                                                                        <div class="mb-0" style="padding-left: 0; margin-bottom: 0;">
                                                                            @foreach ($activities as $activity)
                                                                                <div style="margin-bottom: 4px; padding-left: 0;">
                                                                                    <span style="margin-right: 8px;">•</span>{{ $activity }}
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
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="6" class="text-center text-muted py-4">
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

                                <!-- Remarks History Section -->
                                <div class="mb-4 border rounded-3 p-3">
                                    <h6 class="text-uppercase text-muted small fw-semibold mb-3">
                                        <i data-feather="message-square" class="me-1" style="width: 14px; height: 14px;"></i>
                                        Remarks History
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
                                                                    <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
                                                                        <strong class="text-dark">{{ $remark->user->name ?? 'Unknown' }}</strong>
                                                                        @if ($remark->department)
                                                                            <span class="badge bg-info">{{ $remark->department }}</span>
                                                                        @endif
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
                                <select name="reassigned_employee_id" class="form-select form-select-sm" required>
                                    <option value="">-- Select Employee --</option>
                                    @foreach ($employees as $employee)
                                        @php
                                            $matchingUser = \App\Models\User::where(
                                                'email',
                                                $employee->email,
                                            )
                                                ->orWhere('user_id', $employee->user_id)
                                                ->first();
                                            $isSelected = false;
                                            if (
                                                $lead->assigned_user_id &&
                                                $matchingUser &&
                                                $lead->assigned_user_id == $matchingUser->id
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
    @endpush
@endsection
