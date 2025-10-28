@extends('layouts.app')
@section('title', 'Add Lead | Travel Shreval')

@section('content')
    <div class="hk-pg-wrapper pb-0">
        <!-- Page Body -->
        <div class="hk-pg-body py-0">
            <div class="contactapp-wrap">
                <div class="contactapp-content">
                    <div class="contactapp-detail-wrap">

                        <!-- Header -->
                        <header class="contact-header">
                            <div class="w-100 align-items-center justify-content-between d-flex contactapp-title link-dark">
                                <h1>Add Lead</h1>
                                <a href="{{ route('leads.index') }}" class="btn btn-outline-warning btn-sm">Back</a>
                            </div>
                        </header>

                        <!-- Body -->
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

                                <div class="card p-5 mt-3">
                                    <form action="{{ route('leads.store') }}" method="POST">
                                        @csrf
                                        <h5 class="mb-4 text-primary">Lead Details</h5>

                                        <div class="row gx-3">
                                            <!-- Customer Name -->
                                            <div class="col-sm-4 mb-3">
                                                <label class="form-label">Customer Name*</label>
                                                <input type="text" name="customer_name" class="form-control"
                                                    placeholder="Enter full name" required>
                                            </div>

                                            <!-- Phone -->
                                            <div class="col-sm-4 mb-3">
                                                <label class="form-label">Phone*</label>
                                                <input type="text" name="phone" class="form-control"
                                                    placeholder="Enter phone number" maxlength="20" required>
                                            </div>

                                            <!-- Email -->
                                            <div class="col-sm-4 mb-3">
                                                <label class="form-label">Email</label>
                                                <input type="email" name="email" class="form-control"
                                                    placeholder="Enter email">
                                            </div>

                                            <!-- Address -->
                                            <div class="col-sm-6 mb-3">
                                                <label class="form-label">Address</label>
                                                <input type="text" name="address" class="form-control"
                                                    placeholder="Enter address">
                                            </div>

                                            <!-- Service -->
                                            <div class="col-sm-3 mb-3">
                                                <label class="form-label">Service*</label>
                                                <select name="service_id" class="form-select" required>
                                                    <option value="">-- Select Service --</option>
                                                    @foreach ($services as $service)
                                                        <option value="{{ $service->id }}">{{ $service->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <!-- Destination -->
                                            <div class="col-sm-3 mb-3">
                                                <label class="form-label">Destination*</label>
                                                <select name="destination_id" class="form-select" required>
                                                    <option value="">-- Select Destination --</option>
                                                    @foreach ($destinations as $destination)
                                                        <option value="{{ $destination->id }}">{{ $destination->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <!-- Travel Date -->
                                            <div class="col-sm-3 mb-3">
                                                <label class="form-label">Travel Date</label>
                                                <input type="date" name="travel_date" class="form-control">
                                            </div>

                                            <!-- Adults -->
                                            <div class="col-sm-1 mb-3">
                                                <label class="form-label">Adults</label>
                                                <input type="number" name="adults" value="1" min="0"
                                                    class="form-control">
                                            </div>

                                            <!-- Children -->
                                            <div class="col-sm-1 mb-3">
                                                <label class="form-label">Children</label>
                                                <input type="number" name="children" value="0" min="0"
                                                    class="form-control">
                                            </div>

                                            <!-- Infants -->
                                            <div class="col-sm-1 mb-3">
                                                <label class="form-label">Infants</label>
                                                <input type="number" name="infants" value="0" min="0"
                                                    class="form-control">
                                            </div>

                                            <!-- Assigned To -->
                                            <div class="col-sm-3 mb-3">
                                                <label class="form-label">Assign To</label>
                                                <select name="assigned_user_id" class="form-select">
                                                    <option value="">-- Select User --</option>
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->id }}"
                                                            {{ $user->id == Auth::id() ? 'Selected' : '' }}>
                                                            {{ $user->name }} ({{ $user->email }})</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <!-- Selling Price -->
                                            <div class="col-sm-3 mb-3">
                                                <label class="form-label">Selling Price (INR)</label>
                                                <input type="number" name="selling_price" class="form-control"
                                                    placeholder="₹0" step="0.01">
                                            </div>

                                            <!-- Booked Value -->
                                            <div class="col-sm-3 mb-3">
                                                <label class="form-label">Booked Value (INR)</label>
                                                <input type="number" name="booked_value" class="form-control"
                                                    placeholder="₹0" step="0.01">
                                            </div>

                                            <!-- Status -->
                                            <div class="col-sm-2 mb-3">
                                                <label class="form-label">Status*</label>
                                                <select name="status" class="form-select" required>
                                                    <option value="new" selected>New</option>
                                                    <option value="contacted">Contacted</option>
                                                    <option value="follow_up">Follow Up</option>
                                                    <option value="booked">Booked</option>
                                                    <option value="closed">Closed</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="text-end mt-4">
                                            <button type="submit" class="btn btn-success">Save Lead</button>
                                            <a href="{{ route('leads.index') }}" class="btn btn-secondary">Cancel</a>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                        <!-- /Body -->
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.footer')
    </div>
@endsection
