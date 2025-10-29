@extends('layouts.app')
@section('title', 'Leads | Travel Shravel')
@section('content')
    <div class="hk-pg-wrapper pb-0">
        <div class="hk-pg-body py-0">
            <div class="contactapp-wrap">
                <div class="contactapp-content">
                    <div class="contactapp-detail-wrap">
                        <header class="contact-header">
                            <div class="w-100 align-items-center justify-content-between d-flex contactapp-title link-dark">
                                <h1>Leads List</h1>
                                <a href="{{ route('leads.create') }}" class="btn btn-primary btn-sm">+ Add Lead</a>
                            </div>
                        </header>

                        <div class="contact-body">
                            <div data-simplebar class="nicescroll-bar">
                                @if (session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @endif

                                <table class="table table-striped table-bordered w-100 mb-5" id="leadsTable">
                                    <thead>
                                        <tr>
                                            <th>TSQ</th>
                                            <th>Customer Name</th>
                                            <th>Phone</th>
                                            <th>Service</th>
                                            <th>Destination</th>
                                            <th>Assigned To</th>
                                            <th>Status</th>
                                            <th>Last Remark</th>
                                            <th>Created On</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($leads as $lead)
                                            <tr>
                                                <td><strong>{{ $lead->tsq }}</strong></td>
                                                <td>{{ $lead->customer_name }}</td>
                                                <td>{{ $lead->phone }}</td>
                                                <td>{{ $lead->service?->name ?? 'N/A' }}</td>
                                                <td>{{ $lead->destination?->name ?? 'N/A' }}</td>
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
                                                <td>
                                                    @php
                                                        $statusColors = [
                                                            'new' => 'bg-info text-white',
                                                            'contacted' => 'bg-primary text-white',
                                                            'follow_up' => 'bg-warning text-dark',
                                                            'priority' => 'bg-danger text-white',
                                                            'booked' => 'bg-success text-white',
                                                            'closed' => 'bg-secondary text-white'
                                                        ];
                                                        $color = $statusColors[$lead->status] ?? 'bg-primary text-white';
                                                    @endphp
                                                    <span class="badge {{ $color }}">
                                                        {{ ucfirst(str_replace('_', ' ', $lead->status)) }}
                                                    </span>
                                                </td>
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
                                                <td>{{ $lead->created_at->format('d M, Y') }}</td>
                                                <td>
                                                    <a href="{{ route('leads.show', $lead->id) }}" class="btn btn-outline-primary btn-sm">View</a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="10" class="text-center">No leads found</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>

                                <div class="d-flex justify-content-center">
                                    {{ $leads->links('pagination::bootstrap-5') }}
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
            $('#leadsTable').DataTable({
                scrollX: true,
                autoWidth: false,
                language: {
                    search: "",
                    searchPlaceholder: "Search",
                },
            });
            
            // Initialize Feather icons
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        });
    </script>
@endsection
