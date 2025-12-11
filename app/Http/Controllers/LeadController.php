<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\Lead;
use App\Models\Service;
use App\Models\User;
use App\Models\LeadHistory;
use App\Models\LeadRemark;
use App\Models\VendorPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LeadController extends Controller
{
    /**
     * Check if user is Admin or Manager (can see all leads)
     */
    private function canSeeAllLeads()
    {
        $user = Auth::user();
        return $user->hasRole('Admin') ||
            $user->hasRole('Developer') ||
            $user->hasRole('Sales Manager') ||
            $user->hasRole('Operation Manager') ||
            $user->hasRole('Accounts Manager') ||
            $user->hasRole('Post Sales Manager') ||
            $user->hasRole('Delivery Manager');
    }

    /**
     * Check if user is from Operation, Delivery, Post Sales, or Accounts department
     * These users should only see Booking File in view-only mode
     */
    private function isNonSalesDepartment()
    {
        $user = Auth::user();
        $role = $user->role ?? $user->getRoleNameAttribute();
        
        if (!$role) {
            return false;
        }
        
        $nonSalesDepartments = ['Operation', 'Operation Manager', 'Delivery', 'Delivery Manager', 
                                'Post Sales', 'Post Sales Manager', 'Accounts', 'Accounts Manager'];
        
        return in_array($role, $nonSalesDepartments);
    }

    public function index(Request $request)
    {
        $statuses = [
            'new' => 'New',
            'contacted' => 'Contacted',
            'follow_up' => 'Follow Up',
            'priority' => 'Priority',
            'booked' => 'Booked',
            'closed' => 'Closed',
        ];

        $filters = [
            'status' => $request->input('status'),
            'search' => $request->input('search'),
        ];

        $leadsQuery = Lead::with(['service', 'destination', 'assignedUser', 'remarks' => function ($q) {
            $q->orderBy('created_at', 'desc')->limit(1);
        }])->orderBy('created_at', 'desc');

        // Filter by assigned user if not admin/manager
        if (!$this->canSeeAllLeads()) {
            $leadsQuery->where('assigned_user_id', Auth::id());
        }

        if (!empty($filters['status'])) {
            $leadsQuery->where('status', $filters['status']);
        }

        if (!empty($filters['search'])) {
            $searchTerm = trim($filters['search']);
            $likeTerm = '%' . $searchTerm . '%';

            $leadsQuery->where(function ($query) use ($likeTerm) {
                $query->where('customer_name', 'like', $likeTerm)
                    ->orWhere('first_name', 'like', $likeTerm)
                    ->orWhere('last_name', 'like', $likeTerm)
                    ->orWhere('phone', 'like', $likeTerm)
                    ->orWhere('primary_phone', 'like', $likeTerm)
                    ->orWhere('secondary_phone', 'like', $likeTerm)
                    ->orWhere('other_phone', 'like', $likeTerm)
                    ->orWhere('tsq', 'like', $likeTerm)
                    ->orWhere('tsq_number', 'like', $likeTerm);
            });
        }

        $leads = $leadsQuery->paginate(20);
        $leads->appends($request->query());

        // Add latest remark to each lead
        $leads->getCollection()->transform(function ($lead) {
            $lead->latest_remark = $lead->remarks->first();
            return $lead;
        });

        $services = Service::orderBy('name')->get();
        $destinations = Destination::orderBy('name')->get();
        $users = User::orderBy('name')->get();

        return view('leads.index', [
            'leads' => $leads,
            'statuses' => $statuses,
            'filters' => $filters,
            'services' => $services,
            'destinations' => $destinations,
            'users' => $users,
        ]);
    }

    public function bookings(Request $request)
    {
        $filters = [
            'search' => $request->input('search'),
        ];

        // Only show booked leads
        $leadsQuery = Lead::with(['service', 'destination', 'assignedUser', 'remarks' => function ($q) {
            $q->orderBy('created_at', 'desc')->limit(1);
        }])
            ->where('status', 'booked')
            ->orderBy('created_at', 'desc');

        // Filter by assigned user if not admin/manager
        if (!$this->canSeeAllLeads()) {
            $leadsQuery->where('assigned_user_id', Auth::id());
        }

        if (!empty($filters['search'])) {
            $searchTerm = trim($filters['search']);
            $likeTerm = '%' . $searchTerm . '%';

            $leadsQuery->where(function ($query) use ($likeTerm) {
                $query->where('customer_name', 'like', $likeTerm)
                    ->orWhere('first_name', 'like', $likeTerm)
                    ->orWhere('last_name', 'like', $likeTerm)
                    ->orWhere('phone', 'like', $likeTerm)
                    ->orWhere('primary_phone', 'like', $likeTerm)
                    ->orWhere('secondary_phone', 'like', $likeTerm)
                    ->orWhere('other_phone', 'like', $likeTerm)
                    ->orWhere('tsq', 'like', $likeTerm)
                    ->orWhere('tsq_number', 'like', $likeTerm);
            });
        }

        $leads = $leadsQuery->paginate(20);
        $leads->appends($request->query());

        // Add latest remark to each lead
        $leads->getCollection()->transform(function ($lead) {
            $lead->latest_remark = $lead->remarks->first();
            return $lead;
        });

        $services = Service::orderBy('name')->get();
        $destinations = Destination::orderBy('name')->get();
        $users = User::orderBy('name')->get();

        return view('booking.bookings', [
            'leads' => $leads,
            'filters' => $filters,
            'services' => $services,
            'destinations' => $destinations,
            'users' => $users,
        ]);
    }

    public function bookingForm(Lead $lead)
    {
        $lead->load([
            'service',
            'destination',
            'assignedUser',
            'createdBy',
            'bookedBy',
            'reassignedTo',
            'costComponents',
            'bookingDestinations',
            'bookingArrivalDepartures',
            'bookingAccommodations',
            'bookingItineraries',
            'vendorPayments'
        ]);

        $users = \App\Models\User::orderBy('name')->get();
        $destinations = \App\Models\Destination::with('locations')->orderBy('name')->get();
        
        // Check if user is from non-Sales department (Operation, Delivery, Post Sales, Accounts)
        // These users should only view booking file in read-only mode
        $isViewOnly = $this->isNonSalesDepartment();
        
        // Determine back URL based on user department and referrer
        $backUrl = route('bookings.index');
        $user = Auth::user();
        $role = $user->role ?? $user->getRoleNameAttribute();
        
        // Check referrer or user department to determine back URL
        $referrer = request()->header('referer');
        if ($role && in_array($role, ['Operation', 'Operation Manager'])) {
            $backUrl = route('operations.index');
        } elseif ($role && in_array($role, ['Delivery', 'Delivery Manager'])) {
            $backUrl = route('deliveries.index');
        } elseif ($role && in_array($role, ['Post Sales', 'Post Sales Manager'])) {
            $backUrl = route('post-sales.index');
        } elseif ($role && in_array($role, ['Accounts', 'Accounts Manager'])) {
            $backUrl = route('accounts.index');
        } elseif ($referrer) {
            // Check if referrer contains specific routes
            if (str_contains($referrer, '/operations')) {
                $backUrl = route('operations.index');
            } elseif (str_contains($referrer, '/deliveries')) {
                $backUrl = route('deliveries.index');
            } elseif (str_contains($referrer, '/post-sales')) {
                $backUrl = route('post-sales.index');
            } elseif (str_contains($referrer, '/accounts')) {
                $backUrl = route('accounts.index');
            }
        }

        $vendorPayments = $lead->vendorPayments;
        
        // Check if user is from Ops department
        $user = Auth::user();
        $role = $user->role ?? $user->getRoleNameAttribute();
        $isOpsDept = $role && in_array($role, ['Operation', 'Operation Manager']);

        return view('booking.booking-form', [
            'lead' => $lead,
            'users' => $users,
            'destinations' => $destinations,
            'isViewOnly' => $isViewOnly,
            'backUrl' => $backUrl,
            'vendorPayments' => $vendorPayments,
            'isOpsDept' => $isOpsDept,
        ]);
    }

    public function create()
    {
        $services = Service::all();
        $destinations = Destination::all();
        $users = User::all();
        return view('leads.create', compact('services', 'destinations', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'salutation' => 'nullable|string|max:10',
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'primary_phone' => 'required|string|max:20',
            'secondary_phone' => 'nullable|string|max:20',
            'other_phone' => 'nullable|string|max:20',
            'email' => 'required|email',
            'service_id' => 'nullable|exists:services,id',
            'destination_id' => 'nullable|exists:destinations,id',
            'address' => 'nullable|string',
            'address_line' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'pin_code' => 'nullable|string|max:20',
            'travel_date' => 'nullable|date',
            'adults' => 'required|integer|min:1',
            'children' => 'nullable|integer|min:0',
            'children_2_5' => 'nullable|integer|min:0',
            'children_6_11' => 'nullable|integer|min:0',
            'infants' => 'nullable|integer|min:0',
            'assigned_user_id' => 'nullable|exists:users,id',
            'status' => 'required|in:new,contacted,follow_up,priority,booked,closed',
        ]);

        $data = $validated;
        $data['children_2_5'] = $data['children_2_5'] ?? 0;
        $data['children_6_11'] = $data['children_6_11'] ?? 0;
        $data['children'] = ($data['children_2_5'] ?? 0) + ($data['children_6_11'] ?? 0);
        $data['assigned_user_id'] = $data['assigned_user_id'] ?? Auth::id();
        $data['status'] = $data['status'] ?? 'new';
        $data['created_by'] = Auth::id();

        // Set booked_by and booked_on if status is booked
        if ($data['status'] === 'booked') {
            $data['booked_by'] = Auth::id();
            $data['booked_on'] = now();
        }

        Lead::create($data);
        return redirect()->route('leads.index')->with('success', 'Lead created successfully!');
    }

    public function show(Request $request, Lead $lead)
    {
        $lead->load([
            'service',
            'destination',
            'assignedUser',
            'histories.changedBy',
            'remarks.user',
            'payments',
            'costComponents.enteredBy',
            'operation',
            'documents.uploadedBy',
            'documents.receivedBy',
            'documents.verifiedBy',
            'delivery.assignedTo'
        ]);

        if ($request->expectsJson()) {
            $statusLabels = [
                'new' => 'New',
                'contacted' => 'Contacted',
                'follow_up' => 'Follow Up',
                'priority' => 'Priority',
                'booked' => 'Booked',
                'closed' => 'Closed',
            ];

            $statusColors = [
                'new' => 'bg-info text-white',
                'contacted' => 'bg-primary text-white',
                'follow_up' => 'bg-warning text-dark',
                'priority' => 'bg-danger text-white',
                'booked' => 'bg-success text-white',
                'closed' => 'bg-secondary text-white',
            ];

            $remarks = $lead->remarks->sortByDesc('created_at')->take(10)->values()->map(function ($remark) {
                return [
                    'id' => $remark->id,
                    'remark' => $remark->remark,
                    'visibility' => $remark->visibility,
                    'follow_up_date' => $remark->follow_up_date ? $remark->follow_up_date->format('d M, Y') : null,
                    'created_at' => $remark->created_at?->format('d M, Y h:i A'),
                    'user' => [
                        'name' => $remark->user?->name ?? 'Unknown',
                    ],
                ];
            });

            $documents = $lead->documents->map(function ($doc) {
                return [
                    'id' => $doc->id,
                    'type' => $doc->type,
                    'person_number' => $doc->person_number,
                    'status' => $doc->status,
                    'notes' => $doc->notes,
                ];
            });

            return response()->json([
                'lead' => [
                    'id' => $lead->id,
                    'tsq' => $lead->tsq,
                    'customer_name' => $lead->customer_name,
                    'first_name' => $lead->first_name,
                    'last_name' => $lead->last_name,
                    'primary_phone' => $lead->primary_phone ?? $lead->phone,
                    'secondary_phone' => $lead->secondary_phone,
                    'other_phone' => $lead->other_phone,
                    'email' => $lead->email,
                    'address' => $lead->address,
                    'address_line' => $lead->address_line,
                    'city' => $lead->city,
                    'state' => $lead->state,
                    'country' => $lead->country,
                    'pin_code' => $lead->pin_code,
                    'service' => $lead->service?->name,
                    'service_id' => $lead->service_id,
                    'destination' => $lead->destination?->name,
                    'destination_id' => $lead->destination_id,
                    'travel_date' => $lead->travel_date ? $lead->travel_date->format('d M, Y') : null,
                    'travel_date_raw' => $lead->travel_date ? $lead->travel_date->format('Y-m-d') : null,
                    'adults' => $lead->adults,
                    'children' => $lead->children,
                    'children_2_5' => $lead->children_2_5 ?? 0,
                    'children_6_11' => $lead->children_6_11 ?? 0,
                    'infants' => $lead->infants,
                    'assigned_user' => $lead->assignedUser?->name,
                    'assigned_user_id' => $lead->assigned_user_id,
                    'status' => $lead->status,
                    'status_label' => $statusLabels[$lead->status] ?? ucfirst(str_replace('_', ' ', $lead->status)),
                    'status_color' => $statusColors[$lead->status] ?? 'bg-primary text-white',
                    'created_at' => $lead->created_at?->format('d M, Y h:i A'),
                    'selling_price' => $lead->selling_price,
                    'cost_components' => $lead->costComponents->map(function ($cc) {
                        return [
                            'id' => $cc->id,
                            'name' => $cc->name,
                            'amount' => $cc->amount,
                            'entered_by' => [
                                'name' => $cc->enteredBy?->name ?? 'N/A',
                            ],
                            'created_at' => $cc->created_at?->format('Y-m-d'),
                        ];
                    }),
                    'payments' => $lead->payments->map(function ($p) {
                        return [
                            'id' => $p->id,
                            'amount' => $p->amount,
                            'method' => $p->method,
                            'payment_date' => $p->payment_date?->format('Y-m-d'),
                            'reference' => $p->reference,
                            'status' => $p->status,
                        ];
                    }),
                    'updated_at' => $lead->updated_at?->format('d M, Y h:i A'),
                    'urls' => [
                        'show' => route('leads.show', $lead),
                        'remarks_store' => route('leads.remarks.store', $lead),
                    ],
                ],
                'remarks' => $remarks,
                'documents' => $documents,
            ]);
        }

        return view('leads.index', compact('lead'));
    }

    public function edit(Lead $lead)
    {
        $services = Service::all();
        $destinations = Destination::all();
        $users = User::all();
        return view('leads.edit', compact('lead', 'services', 'destinations', 'users'));
    }

    public function update(Request $request, Lead $lead)
    {
        // Check if this is a booking form submission (has booking-related fields)
        $isBookingForm = $request->has('booking_destinations') ||
            $request->has('booking_flights') ||
            $request->has('booking_surface_transports') ||
            $request->has('booking_sea_transports') ||
            $request->has('booking_accommodations') ||
            $request->has('booking_itineraries');

        if ($isBookingForm) {
            // For booking form, validate and update reassigned_to, selling_price and booking-related fields
            $validated = $request->validate([
                'reassigned_to' => 'nullable|exists:users,id',
                'selling_price' => 'nullable|numeric|min:0',
            ]);

            // Update reassigned_to and selling_price if provided
            $updateData = [];
            if (isset($validated['reassigned_to'])) {
                $updateData['reassigned_to'] = $validated['reassigned_to'];
            }
            if (isset($validated['selling_price'])) {
                $updateData['selling_price'] = $validated['selling_price'];
            }
            if (!empty($updateData)) {
                $lead->update($updateData);
            }
        } else {
            // Regular lead update with full validation
            $validated = $request->validate([
                'salutation' => 'nullable|string|max:10',
                'first_name' => 'required|string|max:255',
                'last_name' => 'nullable|string|max:255',
                'primary_phone' => 'required|string|max:20',
                'secondary_phone' => 'nullable|string|max:20',
                'other_phone' => 'nullable|string|max:20',
                'email' => 'required|email',
                'service_id' => 'nullable|exists:services,id',
                'destination_id' => 'nullable|exists:destinations,id',
                'address' => 'nullable|string',
                'address_line' => 'nullable|string|max:255',
                'city' => 'nullable|string|max:255',
                'state' => 'nullable|string|max:255',
                'country' => 'nullable|string|max:255',
                'pin_code' => 'nullable|string|max:20',
                'travel_date' => 'nullable|date',
                'adults' => 'required|integer|min:1',
                'children' => 'nullable|integer|min:0',
                'children_2_5' => 'nullable|integer|min:0',
                'children_6_11' => 'nullable|integer|min:0',
                'infants' => 'nullable|integer|min:0',
                'assigned_user_id' => 'nullable|exists:users,id',
                'status' => 'required|in:new,contacted,follow_up,priority,booked,closed',
                'reassigned_to' => 'nullable|exists:users,id',
            ]);

            $validated['children_2_5'] = $validated['children_2_5'] ?? 0;
            $validated['children_6_11'] = $validated['children_6_11'] ?? 0;
            $validated['children'] = ($validated['children_2_5'] ?? 0) + ($validated['children_6_11'] ?? 0);

            // Set booked_by and booked_on if status is changing to booked
            if ($validated['status'] === 'booked' && $lead->status !== 'booked') {
                $validated['booked_by'] = Auth::id();
                $validated['booked_on'] = now();
            }

            $lead->update($validated);
        }

        // Handle booking destinations
        if ($request->has('booking_destinations')) {
            // Delete existing booking destinations
            $lead->bookingDestinations()->delete();

            // Create new booking destinations
            foreach ($request->booking_destinations as $destData) {
                if (!empty($destData['destination']) || !empty($destData['location'])) {
                    $fromDate = !empty($destData['from_date']) ? $destData['from_date'] : null;
                    $toDate = !empty($destData['to_date']) ? $destData['to_date'] : null;
                    $noOfDays = null;

                    if ($fromDate && $toDate) {
                        $from = new \DateTime($fromDate);
                        $to = new \DateTime($toDate);
                        $diff = $from->diff($to);
                        $noOfDays = $diff->days;
                    }

                    $lead->bookingDestinations()->create([
                        'destination' => $destData['destination'] ?? null,
                        'location' => $destData['location'] ?? null,
                        'only_hotel' => isset($destData['only_hotel']) && $destData['only_hotel'] == '1',
                        'only_tt' => isset($destData['only_tt']) && $destData['only_tt'] == '1',
                        'hotel_tt' => isset($destData['hotel_tt']) && $destData['hotel_tt'] == '1',
                        'from_date' => $fromDate,
                        'to_date' => $toDate,
                        'no_of_days' => $noOfDays,
                    ]);
                }
            }
        }

        // Handle unified arrival/departure details
        if ($request->has('arrival_departure')) {
            // Delete all existing arrival/departure records
            $lead->bookingArrivalDepartures()->delete();

            // Process unified arrival/departure data
            foreach ($request->arrival_departure as $transportData) {
                $mode = $transportData['mode'] ?? '';
                $hasData = !empty($transportData['from_city']) || !empty($transportData['info']) ||
                    !empty($transportData['departure_date']) || !empty($transportData['arrival_date']);

                if (!$hasData || empty($mode)) {
                    continue;
                }

                // Create record in unified table
                $lead->bookingArrivalDepartures()->create([
                    'mode' => $mode,
                    'info' => $transportData['info'] ?? null,
                    'from_city' => $transportData['from_city'] ?? null,
                    'to_city' => $transportData['to_city'] ?? null,
                    'departure_date' => !empty($transportData['departure_date']) ? $transportData['departure_date'] : null,
                    'departure_time' => !empty($transportData['departure_time']) ? $transportData['departure_time'] : null,
                    'arrival_date' => !empty($transportData['arrival_date']) ? $transportData['arrival_date'] : null,
                    'arrival_time' => !empty($transportData['arrival_time']) ? $transportData['arrival_time'] : null,
                ]);
            }
        } else {
            // Fallback: Handle legacy separate booking sections if they exist
            // Handle booking flights
            if ($request->has('booking_flights')) {
                // Delete existing booking flights
                $lead->bookingFlights()->delete();

                // Create new booking flights
                foreach ($request->booking_flights as $flightData) {
                    if (!empty($flightData['airline']) || !empty($flightData['from_city']) || !empty($flightData['to_city'])) {
                        $lead->bookingFlights()->create([
                            'airline' => $flightData['airline'] ?? null,
                            'info' => $flightData['info'] ?? null,
                            'from_city' => $flightData['from_city'] ?? null,
                            'to_city' => $flightData['to_city'] ?? null,
                            'departure_date' => !empty($flightData['departure_date']) ? $flightData['departure_date'] : null,
                            'departure_time' => !empty($flightData['departure_time']) ? $flightData['departure_time'] : null,
                            'arrival_date' => !empty($flightData['arrival_date']) ? $flightData['arrival_date'] : null,
                            'arrival_time' => !empty($flightData['arrival_time']) ? $flightData['arrival_time'] : null,
                        ]);
                    }
                }
            }

            // Handle booking surface transports
            if ($request->has('booking_surface_transports')) {
                // Delete existing booking surface transports
                $lead->bookingSurfaceTransports()->delete();

                // Create new booking surface transports
                foreach ($request->booking_surface_transports as $transportData) {
                    if (!empty($transportData['mode']) || !empty($transportData['from_city'])) {
                        $lead->bookingSurfaceTransports()->create([
                            'mode' => $transportData['mode'] ?? null,
                            'info' => $transportData['info'] ?? null,
                            'from_city' => $transportData['from_city'] ?? null,
                            'departure_date' => !empty($transportData['departure_date']) ? $transportData['departure_date'] : null,
                            'departure_time' => !empty($transportData['departure_time']) ? $transportData['departure_time'] : null,
                            'arrival_date' => !empty($transportData['arrival_date']) ? $transportData['arrival_date'] : null,
                            'arrival_time' => !empty($transportData['arrival_time']) ? $transportData['arrival_time'] : null,
                        ]);
                    }
                }
            }

            // Handle booking sea transports
            if ($request->has('booking_sea_transports')) {
                // Delete existing booking sea transports
                $lead->bookingSeaTransports()->delete();

                // Create new booking sea transports
                foreach ($request->booking_sea_transports as $seaTransportData) {
                    if (!empty($seaTransportData['cruise']) || !empty($seaTransportData['from_city'])) {
                        $lead->bookingSeaTransports()->create([
                            'cruise' => $seaTransportData['cruise'] ?? null,
                            'info' => $seaTransportData['info'] ?? null,
                            'from_city' => $seaTransportData['from_city'] ?? null,
                            'departure_date' => !empty($seaTransportData['departure_date']) ? $seaTransportData['departure_date'] : null,
                            'departure_time' => !empty($seaTransportData['departure_time']) ? $seaTransportData['departure_time'] : null,
                            'arrival_date' => !empty($seaTransportData['arrival_date']) ? $seaTransportData['arrival_date'] : null,
                            'arrival_time' => !empty($seaTransportData['arrival_time']) ? $seaTransportData['arrival_time'] : null,
                        ]);
                    }
                }
            }
        }

        // Handle booking accommodations
        if ($request->has('booking_accommodations')) {
            // Delete existing booking accommodations
            $lead->bookingAccommodations()->delete();

            // Create new booking accommodations
            foreach ($request->booking_accommodations as $accommodationData) {
                if (!empty($accommodationData['destination']) || !empty($accommodationData['location']) || !empty($accommodationData['stay_at'])) {
                    $lead->bookingAccommodations()->create([
                        'destination' => $accommodationData['destination'] ?? null,
                        'location' => $accommodationData['location'] ?? null,
                        'stay_at' => $accommodationData['stay_at'] ?? null,
                        'checkin_date' => !empty($accommodationData['checkin_date']) ? $accommodationData['checkin_date'] : null,
                        'checkout_date' => !empty($accommodationData['checkout_date']) ? $accommodationData['checkout_date'] : null,
                        'room_type' => $accommodationData['room_type'] ?? null,
                        'meal_plan' => $accommodationData['meal_plan'] ?? null,
                        'booking_status' => $accommodationData['booking_status'] ?? 'Pending',
                    ]);
                }
            }
        }

        // Handle booking itineraries
        if ($request->has('booking_itineraries')) {
            // Delete existing booking itineraries
            $lead->bookingItineraries()->delete();

            // Create new booking itineraries
            foreach ($request->booking_itineraries as $itineraryData) {
                if (!empty($itineraryData['day_and_date']) || !empty($itineraryData['location']) || !empty($itineraryData['activity_tour_description'])) {
                    $lead->bookingItineraries()->create([
                        'day_and_date' => $itineraryData['day_and_date'] ?? null,
                        'time' => !empty($itineraryData['time']) ? $itineraryData['time'] : null,
                        'service_type' => $itineraryData['service_type'] ?? null,
                        'location' => $itineraryData['location'] ?? null,
                        'activity_tour_description' => $itineraryData['activity_tour_description'] ?? null,
                        'stay_at' => $itineraryData['stay_at'] ?? null,
                        'sure' => $itineraryData['sure'] ?? null,
                        'remarks' => $itineraryData['remarks'] ?? null,
                    ]);
                }
            }
        }

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Lead updated successfully!',
            ]);
        }

        return redirect()->route('leads.index', $lead)->with('success', 'Lead updated successfully!');
    }

    public function destroy(Lead $lead)
    {
        $lead->delete();
        return redirect()->route('leads.index')->with('success', 'Lead deleted successfully!');
    }

    public function updateStatus(Request $request, Lead $lead)
    {
        $validated = $request->validate([
            'status' => 'required|in:new,contacted,follow_up,priority,booked,closed',
            'note' => 'nullable|string',
        ]);

        $oldStatus = $lead->status;
        $updateData = ['status' => $validated['status']];

        // Set booked_by and booked_on if status is changing to booked
        if ($validated['status'] === 'booked' && $oldStatus !== 'booked') {
            $updateData['booked_by'] = Auth::id();
            $updateData['booked_on'] = now();
        }

        $lead->update($updateData);

        // History is tracked by observer

        return redirect()->back()->with('success', 'Status updated successfully!');
    }

    public function updateAssignedUser(Request $request, Lead $lead)
    {
        $validated = $request->validate([
            'assigned_user_id' => 'required|exists:users,id',
        ]);

        $oldAssignedUser = $lead->assignedUser;
        $lead->update(['assigned_user_id' => $validated['assigned_user_id']]);
        $newAssignedUser = $lead->fresh()->assignedUser;

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'User assigned successfully!',
                'assigned_user' => [
                    'id' => $newAssignedUser?->id,
                    'name' => $newAssignedUser?->name ?? 'Unassigned',
                ],
            ]);
        }

        return redirect()->back()->with('success', 'Assigned user updated successfully!');
    }

    public function bulkAssign(Request $request)
    {
        $validated = $request->validate([
            'lead_ids' => 'required|array|min:1',
            'lead_ids.*' => 'required|exists:leads,id',
            'assigned_user_id' => 'required|exists:users,id',
        ]);

        $leadIds = $validated['lead_ids'];
        $assignedUserId = $validated['assigned_user_id'];

        // Get leads that exist and user has permission to edit
        $leads = Lead::whereIn('id', $leadIds)->get();

        if ($leads->isEmpty()) {
            return response()->json([
                'message' => 'No valid leads found to assign.',
            ], 422);
        }

        $updatedCount = 0;
        foreach ($leads as $lead) {
            // Check permission for each lead (optional - you can remove if not needed)
            // For now, we'll update all leads that were found
            $lead->update(['assigned_user_id' => $assignedUserId]);
            $updatedCount++;
        }

        $assignedUser = \App\Models\User::find($assignedUserId);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => "Successfully assigned {$updatedCount} lead(s) to {$assignedUser->name}.",
                'updated_count' => $updatedCount,
            ]);
        }

        return redirect()->back()->with('success', "Successfully assigned {$updatedCount} lead(s) to {$assignedUser->name}.");
    }

    // Vendor Payment CRUD (Ops only)
    public function storeVendorPayment(Request $request, Lead $lead)
    {
        $validated = $request->validate([
            'vendor_code' => 'required|string|max:255',
            'booking_type' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'purchase_cost' => 'required|numeric|min:0',
            'due_date' => 'required|date',
            'status' => 'nullable|string|in:Pending,Paid,Cancelled',
        ]);

        $vendorPayment = VendorPayment::create([
            'lead_id' => $lead->id,
            'vendor_code' => $validated['vendor_code'],
            'booking_type' => $validated['booking_type'],
            'location' => $validated['location'],
            'purchase_cost' => $validated['purchase_cost'],
            'due_date' => $validated['due_date'],
            'status' => $validated['status'] ?? 'Pending',
            'paid_amount' => 0,
            'pending_amount' => $validated['purchase_cost'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Vendor payment added successfully',
            'vendor_payment' => $vendorPayment,
        ]);
    }

    public function updateVendorPayment(Request $request, Lead $lead, VendorPayment $vendorPayment)
    {
        // Verify vendor payment belongs to lead
        if ($vendorPayment->lead_id !== $lead->id) {
            return response()->json([
                'success' => false,
                'message' => 'Vendor payment not found',
            ], 404);
        }

        $validated = $request->validate([
            'vendor_code' => 'required|string|max:255',
            'booking_type' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'purchase_cost' => 'required|numeric|min:0',
            'due_date' => 'required|date',
            'status' => 'nullable|string|in:Pending,Paid,Cancelled',
        ]);

        $vendorPayment->update([
            'vendor_code' => $validated['vendor_code'],
            'booking_type' => $validated['booking_type'],
            'location' => $validated['location'],
            'purchase_cost' => $validated['purchase_cost'],
            'due_date' => $validated['due_date'],
            'status' => $validated['status'] ?? 'Pending',
            'pending_amount' => $validated['purchase_cost'] - ($vendorPayment->paid_amount ?? 0),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Vendor payment updated successfully',
            'vendor_payment' => $vendorPayment->fresh(),
        ]);
    }

    public function destroyVendorPayment(Request $request, Lead $lead, VendorPayment $vendorPayment)
    {
        // Verify vendor payment belongs to lead
        if ($vendorPayment->lead_id !== $lead->id) {
            return response()->json([
                'success' => false,
                'message' => 'Vendor payment not found',
            ], 404);
        }

        $vendorPayment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Vendor payment deleted successfully',
        ]);
    }
}
