@extends('layouts.app')
@section('title', 'Completed Travels | Travel Shravel')
@section('content')
    <div class="hk-pg-wrapper pb-0">
        <div class="hk-pg-body py-0">
            <div class="contactapp-wrap">
                <div class="contactapp-content">
                    <div class="contactapp-detail-wrap">
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

                                <form method="GET" action="{{ route('completed-travels.index') }}" class="row g-3 mb-4"
                                    id="completedTravelsFiltersForm">
                                    <div class="col-md-4 col-lg-3">
                                        <label for="search" class="form-label">Search</label>
                                        <input type="text" name="search" id="search"
                                            class="form-control form-control-sm" placeholder="Enter name, TSQ, or phone"
                                            value="{{ $filters['search'] ?? '' }}">
                                    </div>
                                    <div class="col-md-3 col-lg-2">
                                        <label for="service_id" class="form-label">Service</label>
                                        <select name="service_id" id="service_id" class="form-select form-select-sm">
                                            <option value="">All Services</option>
                                            @foreach ($services as $service)
                                                <option value="{{ $service->id }}"
                                                    {{ ($filters['service_id'] ?? '') == $service->id ? 'selected' : '' }}>
                                                    {{ $service->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3 col-lg-2">
                                        <label for="destination_id" class="form-label">Destination</label>
                                        <select name="destination_id" id="destination_id" class="form-select form-select-sm">
                                            <option value="">All Destinations</option>
                                            @foreach ($destinations as $destination)
                                                <option value="{{ $destination->id }}"
                                                    {{ ($filters['destination_id'] ?? '') == $destination->id ? 'selected' : '' }}>
                                                    {{ $destination->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3 col-lg-2 align-self-end">
                                        <button type="submit" class="btn btn-primary btn-sm w-100">
                                            <i class="ri-search-line me-1"></i> Filter
                                        </button>
                                    </div>
                                    @if (!empty($filters['search']) || !empty($filters['service_id']) || !empty($filters['destination_id']))
                                        <div class="col-md-3 col-lg-2 align-self-end">
                                            <a href="{{ route('completed-travels.index') }}"
                                                class="btn btn-outline-danger w-100 btn-sm">Clear Filters</a>
                                        </div>
                                    @endif
                                </form>

                                <!-- Completed Travels Table -->
                                @if(isset($leads) && $leads->count() > 0)
                                <div class="text-muted small mb-2 px-3">
                                    Showing {{ $leads->firstItem() ?? 0 }} to {{ $leads->lastItem() ?? 0 }} out of {{ $leads->total() }} completed travels
                                </div>
                                @endif

                                <table class="table table-striped small table-bordered w-100 mb-5" id="completedTravelsTable">
                                    <thead>
                                        <tr>
                                            <th>TSQ</th>
                                            <th>Customer Name</th>
                                            <th>Phone</th>
                                            <th>Service</th>
                                            <th>Destination</th>
                                            <th>Travel Date</th>
                                            <th>Return Date</th>
                                            <th>Assigned To</th>
                                            <th>Booking File Recent Remark</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($leads as $lead)
                                        <tr data-lead-id="{{ $lead->id }}">
                                            <td><strong>{{ $lead->tsq }}</strong></td>
                                            <td>
                                                <a href="{{ route('completed-travels.booking-file', $lead) }}"
                                                    class="text-primary text-decoration-none fw-semibold">
                                                    {{ $lead->customer_name }}
                                                </a>
                                            </td>
                                            <td>{{ $lead->primary_phone ?? $lead->phone }}</td>
                                            <td>{{ $lead->service->name ?? '-' }}</td>
                                            <td>{{ $lead->destination->name ?? '-' }}</td>
                                            <td>{{ $lead->travel_date ? $lead->travel_date->format('d M, Y') : '-' }}</td>
                                            <td>
                                                <span class="badge bg-secondary">{{ $lead->return_date ? $lead->return_date->format('d M, Y') : '-' }}</span>
                                            </td>
                                            <td>
                                                {{ $lead->assignedUser ? $lead->assignedUser->name : 'Unassigned' }}
                                            </td>
                                            <td>
                                                @if ($lead->latest_booking_file_remark)
                                                    <div class="d-flex align-items-start">
                                                        <div class="flex-grow-1">
                                                            <div class="small text-muted mb-1">
                                                                <strong>{{ $lead->latest_booking_file_remark->user->name ?? 'Unknown' }}</strong>
                                                                <span class="ms-2">{{ $lead->latest_booking_file_remark->created_at->format('d/m/Y h:i A') }}</span>
                                                            </div>
                                                            <div class="text-truncate" style="max-width: 200px;" title="{{ $lead->latest_booking_file_remark->remark }}">
                                                                {{ Str::limit($lead->latest_booking_file_remark->remark, 50) }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('completed-travels.booking-file', $lead) }}" 
                                                   class="btn btn-sm btn-outline-primary" 
                                                   title="View Booking File (Read-Only)">
                                                    <i data-feather="eye" style="width: 14px; height: 14px;"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="10" class="text-center py-4">
                                                <div class="text-muted">
                                                    <i data-feather="inbox" style="width: 48px; height: 48px; opacity: 0.3;"></i>
                                                    <p class="mt-2 mb-0">No completed travels found.</p>
                                                    @if (!empty($filters['search']) || !empty($filters['service_id']) || !empty($filters['destination_id']))
                                                        <p class="small">Try adjusting your filters.</p>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>

                                <!-- Pagination -->
                                @if(isset($leads) && $leads->hasPages())
                                <div class="d-flex justify-content-center mt-4">
                                    {{ $leads->links() }}
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Feather icons
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        });
    </script>
    @endpush
@endsection

