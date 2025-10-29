@extends('layouts.app')
@section('title', 'Edit Lead | Travel Shravel')

@section('content')
    <div class="hk-pg-wrapper pb-0">
        <div class="hk-pg-body py-0">
            <div class="contactapp-wrap">
                <div class="contactapp-content">
                    <div class="contactapp-detail-wrap">
                        <header class="contact-header">
                            <div class="w-100 align-items-center justify-content-between d-flex contactapp-title link-dark">
                                <h1>Edit Lead - {{ $lead->tsq }}</h1>
                                <a href="{{ route('leads.show', $lead->id) }}" class="btn btn-outline-warning btn-sm">Back</a>
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

                                <div class="card p-5 mt-3">
                                    <form action="{{ route('leads.update', $lead->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <h5 class="mb-4 text-primary">Lead Details</h5>

                                        <div class="row gx-3">
                                            <!-- Customer Name -->
                                            <div class="col-sm-4 mb-3">
                                                <label class="form-label">Customer Name*</label>
                                                <input type="text" name="customer_name" class="form-control"
                                                    placeholder="Enter full name" value="{{ old('customer_name', $lead->customer_name) }}" required>
                                            </div>

                                            <!-- Phone -->
                                            <div class="col-sm-4 mb-3">
                                                <label class="form-label">Phone*</label>
                                                <input type="text" name="phone" class="form-control"
                                                    placeholder="Enter phone number" maxlength="20" value="{{ old('phone', $lead->phone) }}" required>
                                            </div>

                                            <!-- Email -->
                                            <div class="col-sm-4 mb-3">
                                                <label class="form-label">Email</label>
                                                <input type="email" name="email" class="form-control"
                                                    placeholder="Enter email" value="{{ old('email', $lead->email) }}">
                                            </div>

                                            <!-- Address -->
                                            <div class="col-sm-6 mb-3">
                                                <label class="form-label">Address</label>
                                                <input type="text" name="address" class="form-control"
                                                    placeholder="Enter address" value="{{ old('address', $lead->address) }}">
                                            </div>

                                            <!-- Service -->
                                            <div class="col-sm-3 mb-3">
                                                <label class="form-label">Service</label>
                                                <select name="service_id" class="form-select">
                                                    <option value="">-- Select Service --</option>
                                                    @foreach ($services as $service)
                                                        <option value="{{ $service->id }}" {{ old('service_id', $lead->service_id) == $service->id ? 'selected' : '' }}>
                                                            {{ $service->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <!-- Destination -->
                                            <div class="col-sm-3 mb-3">
                                                <label class="form-label">Destination</label>
                                                <select name="destination_id" class="form-select">
                                                    <option value="">-- Select Destination --</option>
                                                    @foreach ($destinations as $destination)
                                                        <option value="{{ $destination->id }}" {{ old('destination_id', $lead->destination_id) == $destination->id ? 'selected' : '' }}>
                                                            {{ $destination->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <!-- Travel Date -->
                                            <div class="col-sm-3 mb-3">
                                                <label class="form-label">Travel Date</label>
                                                <input type="date" name="travel_date" class="form-control" value="{{ old('travel_date', $lead->travel_date ? $lead->travel_date->format('Y-m-d') : '') }}">
                                            </div>

                                            <!-- Adults -->
                                            <div class="col-sm-1 mb-3">
                                                <label class="form-label">Adults</label>
                                                <input type="number" name="adults" value="{{ old('adults', $lead->adults ?? 1) }}" min="0"
                                                    class="form-control">
                                            </div>

                                            <!-- Children -->
                                            <div class="col-sm-1 mb-3">
                                                <label class="form-label">Children</label>
                                                <input type="number" name="children" value="{{ old('children', $lead->children ?? 0) }}" min="0"
                                                    class="form-control">
                                            </div>

                                            <!-- Infants -->
                                            <div class="col-sm-1 mb-3">
                                                <label class="form-label">Infants</label>
                                                <input type="number" name="infants" value="{{ old('infants', $lead->infants ?? 0) }}" min="0"
                                                    class="form-control">
                                            </div>

                                            <!-- Assigned To -->
                                            <div class="col-sm-3 mb-3">
                                                <label class="form-label">Assign To</label>
                                                <select name="assigned_user_id" class="form-select">
                                                    <option value="">-- Select User --</option>
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->id }}"
                                                            {{ old('assigned_user_id', $lead->assigned_user_id) == $user->id ? 'selected' : '' }}>
                                                            {{ $user->name }} ({{ $user->email }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <!-- Selling Price -->
                                            <div class="col-sm-3 mb-3">
                                                <label class="form-label">Selling Price (INR)</label>
                                                <input type="number" name="selling_price" class="form-control"
                                                    placeholder="₹0" step="0.01" value="{{ old('selling_price', $lead->selling_price) }}">
                                            </div>

                                            <!-- Booked Value -->
                                            <div class="col-sm-3 mb-3">
                                                <label class="form-label">Booked Value (INR)</label>
                                                <input type="number" name="booked_value" class="form-control"
                                                    placeholder="₹0" step="0.01" value="{{ old('booked_value', $lead->booked_value) }}">
                                            </div>

                                            <!-- Status -->
                                            <div class="col-sm-2 mb-3">
                                                <label class="form-label">Status*</label>
                                                <select name="status" class="form-select" required>
                                                    <option value="new" {{ old('status', $lead->status) == 'new' ? 'selected' : '' }}>New</option>
                                                    <option value="contacted" {{ old('status', $lead->status) == 'contacted' ? 'selected' : '' }}>Contacted</option>
                                                    <option value="follow_up" {{ old('status', $lead->status) == 'follow_up' ? 'selected' : '' }}>Follow Up</option>
                                                    <option value="priority" {{ old('status', $lead->status) == 'priority' ? 'selected' : '' }}>Priority</option>
                                                    <option value="booked" {{ old('status', $lead->status) == 'booked' ? 'selected' : '' }}>Booked</option>
                                                    <option value="closed" {{ old('status', $lead->status) == 'closed' ? 'selected' : '' }}>Closed</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="text-end mt-4">
                                            <button type="submit" class="btn btn-success">Update Lead</button>
                                            <a href="{{ route('leads.show', $lead->id) }}" class="btn btn-secondary">Cancel</a>
                                        </div>
                                    </form>
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

