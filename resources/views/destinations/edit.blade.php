@extends('layouts.app')
@section('title', 'Edit Destination | Travel Shravel')

@section('content')
    <div class="hk-pg-wrapper pb-0">
        <div class="hk-pg-body py-0">
            <div class="contactapp-wrap">
                <div class="contactapp-content">
                    <div class="contactapp-detail-wrap">
                        <header class="contact-header">
                            <div class="w-100 align-items-center justify-content-between d-flex contactapp-title link-dark">
                                <h1>Edit Destination</h1>
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
                                    <form action="{{ route('destinations.update', $destination->id) }}" method="POST" id="destinationForm">
                                        @csrf
                                        @method('PUT')

                                        <div class="row gx-3">
                                            <div class="col-12 mb-3">
                                                <label class="form-label">Country</label>
                                                <select name="country" class="form-select">
                                                    <option value="">-- Select Country --</option>
                                                    <option value="India" {{ old('country', $destination->country) == 'India' ? 'selected' : '' }}>India</option>
                                                    <option value="Afghanistan" {{ old('country', $destination->country) == 'Afghanistan' ? 'selected' : '' }}>Afghanistan</option>
                                                    <option value="Australia" {{ old('country', $destination->country) == 'Australia' ? 'selected' : '' }}>Australia</option>
                                                    <option value="Bangladesh" {{ old('country', $destination->country) == 'Bangladesh' ? 'selected' : '' }}>Bangladesh</option>
                                                    <option value="Bhutan" {{ old('country', $destination->country) == 'Bhutan' ? 'selected' : '' }}>Bhutan</option>
                                                    <option value="Brazil" {{ old('country', $destination->country) == 'Brazil' ? 'selected' : '' }}>Brazil</option>
                                                    <option value="Canada" {{ old('country', $destination->country) == 'Canada' ? 'selected' : '' }}>Canada</option>
                                                    <option value="China" {{ old('country', $destination->country) == 'China' ? 'selected' : '' }}>China</option>
                                                    <option value="France" {{ old('country', $destination->country) == 'France' ? 'selected' : '' }}>France</option>
                                                    <option value="Germany" {{ old('country', $destination->country) == 'Germany' ? 'selected' : '' }}>Germany</option>
                                                    <option value="Indonesia" {{ old('country', $destination->country) == 'Indonesia' ? 'selected' : '' }}>Indonesia</option>
                                                    <option value="Italy" {{ old('country', $destination->country) == 'Italy' ? 'selected' : '' }}>Italy</option>
                                                    <option value="Japan" {{ old('country', $destination->country) == 'Japan' ? 'selected' : '' }}>Japan</option>
                                                    <option value="Malaysia" {{ old('country', $destination->country) == 'Malaysia' ? 'selected' : '' }}>Malaysia</option>
                                                    <option value="Maldives" {{ old('country', $destination->country) == 'Maldives' ? 'selected' : '' }}>Maldives</option>
                                                    <option value="Mauritius" {{ old('country', $destination->country) == 'Mauritius' ? 'selected' : '' }}>Mauritius</option>
                                                    <option value="Myanmar" {{ old('country', $destination->country) == 'Myanmar' ? 'selected' : '' }}>Myanmar</option>
                                                    <option value="Nepal" {{ old('country', $destination->country) == 'Nepal' ? 'selected' : '' }}>Nepal</option>
                                                    <option value="New Zealand" {{ old('country', $destination->country) == 'New Zealand' ? 'selected' : '' }}>New Zealand</option>
                                                    <option value="Pakistan" {{ old('country', $destination->country) == 'Pakistan' ? 'selected' : '' }}>Pakistan</option>
                                                    <option value="Philippines" {{ old('country', $destination->country) == 'Philippines' ? 'selected' : '' }}>Philippines</option>
                                                    <option value="Russia" {{ old('country', $destination->country) == 'Russia' ? 'selected' : '' }}>Russia</option>
                                                    <option value="Singapore" {{ old('country', $destination->country) == 'Singapore' ? 'selected' : '' }}>Singapore</option>
                                                    <option value="South Africa" {{ old('country', $destination->country) == 'South Africa' ? 'selected' : '' }}>South Africa</option>
                                                    <option value="South Korea" {{ old('country', $destination->country) == 'South Korea' ? 'selected' : '' }}>South Korea</option>
                                                    <option value="Sri Lanka" {{ old('country', $destination->country) == 'Sri Lanka' ? 'selected' : '' }}>Sri Lanka</option>
                                                    <option value="Switzerland" {{ old('country', $destination->country) == 'Switzerland' ? 'selected' : '' }}>Switzerland</option>
                                                    <option value="Thailand" {{ old('country', $destination->country) == 'Thailand' ? 'selected' : '' }}>Thailand</option>
                                                    <option value="Turkey" {{ old('country', $destination->country) == 'Turkey' ? 'selected' : '' }}>Turkey</option>
                                                    <option value="United Arab Emirates" {{ old('country', $destination->country) == 'United Arab Emirates' ? 'selected' : '' }}>United Arab Emirates</option>
                                                    <option value="United Kingdom" {{ old('country', $destination->country) == 'United Kingdom' ? 'selected' : '' }}>United Kingdom</option>
                                                    <option value="United States" {{ old('country', $destination->country) == 'United States' ? 'selected' : '' }}>United States</option>
                                                    <option value="Vietnam" {{ old('country', $destination->country) == 'Vietnam' ? 'selected' : '' }}>Vietnam</option>
                                                    <option value="Other" {{ old('country', $destination->country) == 'Other' ? 'selected' : '' }}>Other</option>
                                                </select>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <label class="form-label">Destination Name*</label>
                                                <input type="text" name="name" class="form-control"
                                                    placeholder="Enter destination name" value="{{ old('name', $destination->name) }}" required>
                                            </div>

                                            <div class="col-12 mb-3">
                                                <label class="form-label mb-2">Locations</label>
                                                <div class="border rounded p-3" id="locationsContainer">
                                                    <div class="d-flex flex-wrap gap-2 mb-2" id="locationBadges">
                                                        @if($destination->locations && $destination->locations->count() > 0)
                                                            @foreach($destination->locations as $location)
                                                                <span class="badge bg-primary d-inline-flex align-items-center gap-1" style="font-size: 0.875rem;">
                                                                    {{ $location->name }}
                                                                    <button type="button" class="btn-close btn-close-white" style="font-size: 0.7rem;" data-location="{{ $location->name }}" data-location-id="{{ $location->id }}"></button>
                                                                </span>
                                                                <input type="hidden" name="location_ids[]" value="{{ $location->id }}">
                                                                <input type="hidden" name="locations[]" value="{{ $location->name }}">
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                    <input type="text" 
                                                        id="locationInput" 
                                                        class="form-control" 
                                                        placeholder="Type location name and press Comma or Enter to add"
                                                        autocomplete="off">
                                                </div>
                                                <small class="text-muted">Type location names and press Comma or Enter to create tags</small>
                                            </div>
                                        </div>

                                        <div class="text-end mt-3">
                                            <button type="submit" class="btn btn-success">Update Destination</button>
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

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const locationInput = document.getElementById('locationInput');
            const locationBadges = document.getElementById('locationBadges');
            const locations = new Set(); // Track unique locations

            // Initialize existing locations
            const existingBadges = locationBadges.querySelectorAll('.badge');
            existingBadges.forEach(badge => {
                const btn = badge.querySelector('button[data-location]');
                if (btn) {
                    locations.add(btn.getAttribute('data-location'));
                }
            });

            // Function to create a badge
            function createLocationBadge(locationName, locationId = '') {
                if (!locationName || locationName.trim() === '' || locations.has(locationName.trim())) {
                    return false;
                }

                const trimmedName = locationName.trim();
                locations.add(trimmedName);

                const badge = document.createElement('span');
                badge.className = 'badge bg-primary d-inline-flex align-items-center gap-1';
                badge.style.fontSize = '0.875rem';
                badge.innerHTML = `
                    ${trimmedName}
                    <button type="button" class="btn-close btn-close-white" style="font-size: 0.7rem;" data-location="${trimmedName}" ${locationId ? `data-location-id="${locationId}"` : ''}></button>
                `;
                locationBadges.appendChild(badge);

                // Add hidden inputs for form submission
                if (locationId) {
                    const hiddenIdInput = document.createElement('input');
                    hiddenIdInput.type = 'hidden';
                    hiddenIdInput.name = 'location_ids[]';
                    hiddenIdInput.value = locationId;
                    locationBadges.appendChild(hiddenIdInput);
                } else {
                    const hiddenIdInput = document.createElement('input');
                    hiddenIdInput.type = 'hidden';
                    hiddenIdInput.name = 'location_ids[]';
                    hiddenIdInput.value = '';
                    locationBadges.appendChild(hiddenIdInput);
                }

                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'locations[]';
                hiddenInput.value = trimmedName;
                locationBadges.appendChild(hiddenInput);

                return true;
            }

            // Function to remove a badge
            function removeLocationBadge(locationName) {
                locations.delete(locationName);
                
                // Find and remove the badge
                const badges = locationBadges.querySelectorAll('.badge');
                badges.forEach(badge => {
                    const btn = badge.querySelector('button[data-location]');
                    if (btn && btn.getAttribute('data-location') === locationName) {
                        const locationId = btn.getAttribute('data-location-id');
                        
                        // Remove associated hidden inputs
                        const hiddenInputs = locationBadges.querySelectorAll('input[type="hidden"]');
                        hiddenInputs.forEach(input => {
                            if (input.name === 'locations[]' && input.value === locationName) {
                                input.remove();
                            }
                            if (input.name === 'location_ids[]' && locationId && input.value === locationId) {
                                input.remove();
                            }
                        });
                        
                        badge.remove();
                    }
                });
            }

            // Handle input events
            locationInput.addEventListener('keydown', function(e) {
                if (e.key === ',' || e.key === 'Enter') {
                    e.preventDefault();
                    let value = this.value.trim();
                    
                    // If comma was pressed, get text before comma
                    if (e.key === ',') {
                        const commaIndex = value.indexOf(',');
                        if (commaIndex !== -1) {
                            value = value.substring(0, commaIndex).trim();
                        }
                    }
                    
                    if (value) {
                        if (createLocationBadge(value)) {
                            this.value = '';
                        }
                    }
                }
            });

            // Handle paste events (split by comma)
            locationInput.addEventListener('paste', function(e) {
                e.preventDefault();
                const pastedText = (e.clipboardData || window.clipboardData).getData('text');
                const words = pastedText.split(',').filter(word => word.trim() !== '');
                words.forEach(word => createLocationBadge(word.trim()));
                this.value = '';
            });

            // Handle badge removal
            locationBadges.addEventListener('click', function(e) {
                if (e.target.classList.contains('btn-close')) {
                    const locationName = e.target.getAttribute('data-location');
                    if (locationName) {
                        removeLocationBadge(locationName);
                    }
                }
            });
        });
    </script>
    @endpush
@endsection

