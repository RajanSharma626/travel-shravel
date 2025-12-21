@extends('layouts.app')
@section('title', 'Services | Travel Shreval')

@section('content')
    <div class="hk-pg-wrapper pb-0">
        <!-- Page Body -->
        <div class="hk-pg-body py-0">
            <div class="contactapp-wrap">
                <div class="contactapp-content">
                    <div class="contactapp-detail-wrap">
                        <header class="contact-header">
                            <div class="w-100 align-items-center justify-content-between d-flex contactapp-title link-dark">
                                <h1>Services</h1>
                                <a href="{{ route('services.create') }}" class="btn btn-primary btn-sm">
                                    + Add Service
                                </a>
                            </div>
                        </header>

                        <div class="contact-body">
                            <div data-simplebar class="nicescroll-bar">
                                <!-- Alerts -->
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

                                @if (isset($services) && $services->count() > 0)
                                    <div class="text-muted small mb-2 px-3">
                                        Showing {{ $services->firstItem() ?? 0 }} out of {{ $services->total() }}
                                    </div>
                                @endif

                                <!-- Table -->
                                <div class="table-responsive">
                                    <table id="ServiceTable"
                                        class="table table-striped table-bordered align-middle w-100 mb-3">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Service Name</th>
                                                <th>Status</th>
                                                <th>Created On</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $sno = 1;
                                            @endphp
                                            @forelse ($services as $service)
                                                <tr>
                                                    <td>{{ $sno }}</td>
                                                    <td>{{ $service->name }}</td>
                                                    <td>
                                                        @if ($service->is_active)
                                                            <span class="badge bg-success">Active</span>
                                                        @else
                                                            <span class="badge bg-secondary">Inactive</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $service->created_at->format('d M, Y') }}</td>
                                                    <td>
                                                        <a href="{{ route('services.edit', $service->id) }}"
                                                            class="btn btn-outline-warning btn-sm">
                                                            <i class="bi bi-pencil-square"></i> Edit
                                                        </a>
                                                        <form action="{{ route('services.destroy', $service->id) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-outline-danger btn-sm"
                                                                onclick="return confirm('Delete this service?')">
                                                                <i class="bi bi-trash"></i> Delete
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                                @php
                                                    $sno++
                                                @endphp
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center text-muted">
                                                        No services found.
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Pagination -->
                                <div class="d-flex justify-content-center mt-3">
                                    {{ $services->links('pagination::bootstrap-5') }}
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        @include('layouts.footer')
    </div>
@endsection
