@extends('layouts.app')
@section('title', 'Add Destination | Travel Shreval')

@section('content')
    <div class="hk-pg-wrapper pb-0">
        <div class="hk-pg-body py-0">
            <div class="contactapp-wrap">
                <div class="contactapp-content">
                    <div class="contactapp-detail-wrap">
                        <header class="contact-header">
                            <div class="w-100 align-items-center justify-content-between d-flex contactapp-title link-dark">
                                <h1>Add Destination</h1>
                                <a href="{{ route('destinations.index') }}" class="btn btn-outline-warning btn-sm">Back</a>
                            </div>
                        </header>

                        <div class="contact-body">
                            <div data-simplebar class="nicescroll-bar">
                                @if (session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @endif

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        @foreach ($errors->all() as $error)
                                            {{ $error }}<br>
                                        @endforeach
                                    </div>
                                @endif

                                <div class="card p-5">
                                    <form action="{{ route('destinations.store') }}" method="POST">
                                        @csrf

                                        <div class="row gx-3">
                                            <div class="col-sm-4 mb-3">
                                                <label class="form-label">Destination Name*</label>
                                                <input type="text" name="name" class="form-control"
                                                    placeholder="Enter destination name" required>
                                            </div>

                                            <div class="col-sm-4 mb-3">
                                                <label class="form-label">Country</label>
                                                <input type="text" name="country" class="form-control"
                                                    placeholder="Enter country name">
                                            </div>

                                            <div class="col-sm-4 mb-3">
                                                <label class="form-label">State</label>
                                                <input type="text" name="state" class="form-control"
                                                    placeholder="Enter state name">
                                            </div>

                                            <div class="col-sm-4 mb-3">
                                                <label class="form-label">City</label>
                                                <input type="text" name="city" class="form-control"
                                                    placeholder="Enter city name">
                                            </div>

                                            <div class="col-sm-8 mb-3">
                                                <label class="form-label">Description</label>
                                                <textarea name="description" class="form-control" placeholder="Write short description..."></textarea>
                                            </div>

                                            <div class="col-sm-4 mb-3">
                                                <label class="form-label">Status</label>
                                                <select name="is_active" class="form-select">
                                                    <option value="1" selected>Active</option>
                                                    <option value="0">Inactive</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="text-end mt-3">
                                            <button type="submit" class="btn btn-success">Save Destination</button>
                                            <a href="{{ route('destinations.index') }}" class="btn btn-secondary">Cancel</a>
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
