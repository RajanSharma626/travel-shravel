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
                                @if($isAdmin)
                                    <span class="badge bg-info text-white">Viewing All Follow-Up Leads</span>
                                @else
                                    <span class="badge bg-primary text-white">Viewing My Follow-Up Leads</span>
                                @endif
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
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered w-100 mb-3" id="followUpTable">
                                            <thead>
                                                <tr>
                                                    <th>TSQ</th>
                                                    <th>Customer Name</th>
                                                    <th>Phone</th>
                                                    <th>Service</th>
                                                    <th>Destination</th>
                                                    @if($isAdmin)
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
                                                        @if($isAdmin)
                                                            <td>
                                                                @if($lead->assignedUser && $lead->assigned_user_id == Auth::id())
                                                                    <span class="badge bg-success text-white fw-bold">
                                                                        <i data-feather="user-check" style="width: 14px; height: 14px; vertical-align: middle;"></i>
                                                                        {{ $lead->assignedUser->name }}
                                                                    </span>
                                                                @else
                                                                    {{ $lead->assignedUser?->name ?? 'Unassigned' }}
                                                                @endif
                                                            </td>
                                                        @endif
                                                        <td>
                                                            @if($lead->latest_remark)
                                                                <div class="text-truncate" style="max-width: 200px;" title="{{ $lead->latest_remark->remark }}">
                                                                    {{ Str::limit($lead->latest_remark->remark, 50) }}
                                                                </div>
                                                                <small class="text-muted">
                                                                    by {{ $lead->latest_remark->user->name ?? 'N/A' }}
                                                                    @if($lead->latest_remark->created_at)
                                                                        - {{ $lead->latest_remark->created_at->format('d M, Y') }}
                                                                    @endif
                                                                </small>
                                                            @else
                                                                <span class="text-muted">No remarks yet</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($lead->latest_remark && $lead->latest_remark->follow_up_date)
                                                                @php
                                                                    $followUpDate = $lead->latest_remark->follow_up_date;
                                                                    $isOverdue = $followUpDate->isPast() && !$followUpDate->isToday();
                                                                    $isToday = $followUpDate->isToday();
                                                                @endphp
                                                                <span class="badge {{ $isOverdue ? 'bg-danger text-white' : ($isToday ? 'bg-warning text-dark' : 'bg-info text-white') }}">
                                                                    {{ $followUpDate->format('d M, Y') }}
                                                                    @if($isOverdue)
                                                                        (Overdue)
                                                                    @elseif($isToday)
                                                                        (Today)
                                                                    @endif
                                                                </span>
                                                            @else
                                                                <span class="text-muted">-</span>
                                                            @endif
                                                        </td>
                                                        <td>{{ $lead->updated_at->format('d M, Y h:i A') }}</td>
                                                        <td>
                                                            <a href="{{ route('leads.show', $lead->id) }}" class="btn btn-outline-primary btn-sm">View</a>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="{{ $isAdmin ? '10' : '9' }}" class="text-center text-muted py-4">
                                                            <i data-feather="inbox" class="mb-2" style="width: 48px; height: 48px; opacity: 0.3;"></i>
                                                            <p class="mb-0">No follow-up leads found</p>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Pagination -->
                                    @if($leads->hasPages())
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
                order: [[7, 'asc']], // Sort by Follow Up Date column (index 7)
                columnDefs: [
                    { orderable: false, targets: [{{ $isAdmin ? 9 : 8 }}] } // Disable sorting on Actions column
                ]
            });
            
            // Initialize Feather icons
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        });
    </script>
@endsection

