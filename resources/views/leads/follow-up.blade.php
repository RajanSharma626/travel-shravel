@extends('layouts.app')
@section('title', 'Follow Up Leads | Travel Shravel')
@section('content')
    <div class="hk-pg-wrapper pb-0">
        <div class="hk-pg-body py-0">
            <div class="contactapp-wrap">
                <div class="contactapp-content">
                    <div class="contactapp-detail-wrap">
                        <header class="contact-header">
                            <div class="w-100 align-items-center justify-content-between d-flex contactapp-title link-dark">
                                <h1>Follow Up Leads</h1>
                            </div>
                        </header>

                        <div class="contact-body">
                            <div data-simplebar class="nicescroll-bar">
                                @if (session('success'))
                                    <div class="alert alert-success mt-3">{{ session('success') }}</div>
                                @endif

                                @if ($errors->any())
                                    <div class="alert alert-danger mt-3">
                                        @foreach ($errors->all() as $error)
                                            {{ $error }}<br>
                                        @endforeach
                                    </div>
                                @endif

                                <div class="card p-4 mt-3">
                                    <form method="GET" action="{{ route('leads.follow-up') }}" class="row g-3 mb-4"
                                        id="followUpFiltersForm">
                                        <div class="col-md-4 col-lg-3">
                                            <label for="follow_up_filter" class="form-label">Follow-Up Date</label>
                                            <select name="follow_up_filter" id="follow_up_filter"
                                                class="form-select form-select-sm">
                                                <option value="all" @selected(($filters['follow_up_filter'] ?? 'all') === 'all')>-- All --</option>
                                                <option value="today" @selected(($filters['follow_up_filter'] ?? 'all') === 'today')>Today</option>
                                                <option value="overdue" @selected(($filters['follow_up_filter'] ?? 'all') === 'overdue')>Overdue</option>
                                                <option value="upcoming" @selected(($filters['follow_up_filter'] ?? 'all') === 'upcoming')>Upcoming</option>
                                                <option value="no_date" @selected(($filters['follow_up_filter'] ?? 'all') === 'no_date')>No Follow-Up Date
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col-md-5 col-lg-4">
                                            <label for="search" class="form-label">Search</label>
                                            <div class="input-group">
                                                <input type="text" name="search" id="search"
                                                    class="form-control border-end-0 form-control-sm"
                                                    placeholder="Name, ref no., or phone"
                                                    value="{{ $filters['search'] ?? '' }}">
                                                <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                                            </div>
                                        </div>
                                        @if (($filters['search'] ?? null) || ($filters['follow_up_filter'] ?? 'all') !== 'all')
                                            <div class="col-md-3 col-lg-2 align-self-end ms-auto">
                                                <a href="{{ route('leads.follow-up') }}"
                                                    class="btn btn-outline-danger btn-sm w-100">Clear Filters</a>
                                            </div>
                                        @endif
                                    </form>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered w-100 mb-3" id="followUpTable">
                                            <thead>
                                                <tr>
                                                    <th>TSQ</th>
                                                    <th>Customer Name</th>
                                                    <th>Phone</th>
                                                    <th>Service</th>
                                                    <th>Destination</th>
                                                    @if ($isAdmin)
                                                        <th>Assigned To</th>
                                                    @endif
                                                    <th>Last Remark</th>
                                                    <th>Follow Up Date</th>
                                                    <th>Last Updated</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($leads as $lead)
                                                    <tr>
                                                        <td><strong>{{ $lead->tsq }}</strong></td>
                                                        <td>{{ $lead->customer_name }}</td>
                                                        <td>{{ $lead->primary_phone ?? $lead->phone }}</td>
                                                        <td>{{ $lead->service?->name ?? 'N/A' }}</td>
                                                        <td>{{ $lead->destination?->name ?? 'N/A' }}</td>
                                                        @if ($isAdmin)
                                                            <td>
                                                                @if ($lead->assignedUser && $lead->assigned_user_id == Auth::id())
                                                                    <span class="badge bg-success text-white fw-bold">
                                                                        <i data-feather="user-check"
                                                                            style="width: 14px; height: 14px; vertical-align: middle;"></i>
                                                                        {{ $lead->assignedUser->name }}
                                                                    </span>
                                                                @else
                                                                    {{ $lead->assignedUser?->name ?? 'Unassigned' }}
                                                                @endif
                                                            </td>
                                                        @endif
                                                        <td>
                                                            @if ($lead->latest_remark)
                                                                <div class="text-truncate" style="max-width: 200px;"
                                                                    title="{{ $lead->latest_remark->remark }}">
                                                                    {{ Str::limit($lead->latest_remark->remark, 50) }}
                                                                </div>
                                                                <small class="text-muted">
                                                                    by {{ $lead->latest_remark->user->name ?? 'N/A' }}
                                                                    @if ($lead->latest_remark->created_at)
                                                                        -
                                                                        {{ $lead->latest_remark->created_at->format('d M, Y') }}
                                                                    @endif
                                                                </small>
                                                            @else
                                                                <span class="text-muted">No remarks yet</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($lead->latest_remark && $lead->latest_remark->follow_up_date)
                                                                @php
                                                                    $followUpDate =
                                                                        $lead->latest_remark->follow_up_date;
                                                                    $isOverdue =
                                                                        $followUpDate->isPast() &&
                                                                        !$followUpDate->isToday();
                                                                    $isToday = $followUpDate->isToday();
                                                                @endphp
                                                                <span
                                                                    class=" {{ $isOverdue ? 'text-danger' : ($isToday ? 'text-warning' : '') }}">
                                                                    {{ $followUpDate->format('d M, Y') }}
                                                                    @if ($isToday)
                                                                        (Today)
                                                                    @endif
                                                                </span>
                                                            @else
                                                                <span class="text-muted">-</span>
                                                            @endif
                                                        </td>
                                                        <td>{{ $lead->updated_at->format('d M, Y h:i A') }}</td>
                                                        <td>
                                                            <a href="{{ route('leads.show', $lead->id) }}"
                                                                class="btn btn-outline-primary btn-sm">View</a>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="{{ $isAdmin ? '10' : '9' }}"
                                                            class="text-center text-muted py-4">
                                                            <i data-feather="inbox" class="mb-2"
                                                                style="width: 48px; height: 48px; opacity: 0.3;"></i>
                                                            <p class="mb-0">No follow-up leads found</p>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Pagination -->
                                    @if ($leads->hasPages())
                                        <div class="d-flex justify-content-center mt-3">
                                            {{ $leads->links('pagination::bootstrap-5') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.footer')
    </div>

    <script>
        $(document).ready(function() {
            $('#followUpTable').DataTable({
                scrollX: true,
                autoWidth: false,
                paging: false, // Disable DataTables pagination since we're using Laravel pagination
                searching: true,
                ordering: true,
                info: false,
                language: {
                    search: "",
                    searchPlaceholder: "Search leads...",
                },
                order: [
                    [7, 'asc']
                ], // Sort by Follow Up Date column (index 7)
                columnDefs: [{
                        orderable: false,
                        targets: [{{ $isAdmin ? 9 : 8 }}]
                    } // Disable sorting on Actions column
                ]
            });

            // Initialize Feather icons
            if (typeof feather !== 'undefined') {
                feather.replace();
            }

            const followUpFilterSelect = document.getElementById('follow_up_filter');
            const filtersForm = document.getElementById('followUpFiltersForm');

            if (followUpFilterSelect && filtersForm) {
                followUpFilterSelect.addEventListener('change', function() {
                    filtersForm.submit();
                });
            }
        });
    </script>
@endsection
