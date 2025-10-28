@extends('layouts.app')
@section('title', 'Leads | Travel Shreval')
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

                                <table class="table table-striped table-bordered w-100 mb-5">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Loan Amount</th>
                                            <th>Mobile</th>
                                            <th>City</th>
                                            <th>Salary</th>
                                            <th>Created On</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($leads as $lead)
                                            <tr>
                                                <td>#{{ $lead->id }}</td>
                                                <td>{{ $lead->first_name }} {{ $lead->last_name }}</td>
                                                <td>₹{{ number_format($lead->loan_amount) }}</td>
                                                <td>{{ $lead->mobile }}</td>
                                                <td>{{ $lead->city }}</td>
                                                <td>₹{{ number_format($lead->monthly_salary) }}</td>
                                                <td>{{ $lead->created_at->format('d M, Y') }}</td>
                                                <td>
                                                    <a href="{{ route('leads.edit', $lead->id) }}"
                                                        class="btn btn-outline-warning btn-sm">Edit</a>
                                                    <form action="{{ route('leads.destroy', $lead->id) }}" method="POST"
                                                        class="d-inline">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="btn btn-outline-danger btn-sm"
                                                            onclick="return confirm('Delete this lead?')">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center">No leads found</td>
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
@endsection
