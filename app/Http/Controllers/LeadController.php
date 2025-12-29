<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\Lead;
use App\Models\Service;
use App\Models\User;
use App\Models\LeadHistory;
use App\Models\LeadRemark;
use App\Models\VendorPayment;
use App\Models\BookingDestination;
use App\Models\BookingArrivalDeparture;
use App\Models\BookingAccommodation;
use App\Models\BookingItinerary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LeadController extends Controller
{

    /**
     * Check if employee is Admin or Manager (can see all leads)
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
            $user->hasRole('Delivery Manager') ||
            $user->hasRole('Customer Care');
    }

    /**
     * Check if employee is from Operation, Delivery, Post Sales, or Accounts department
     * These employees should only see Booking File in view-only mode
     */
    private function isNonSalesDepartment()
    {
        $user = Auth::user();
        $role = $user->role ?? $user->getRoleNameAttribute();
        
        if (!$role) {
            return false;
        }
        
        $nonSalesDepartments = ['Delivery', 'Delivery Manager', 
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
            'cancelled' => 'Cancelled',
            'refunded' => 'Refunded',
        ];

        $filters = [
            'status' => $request->input('status'),
            'search' => $request->input('search'),
        ];

        $leadsQuery = Lead::with(['service', 'destination', 'assignedUser', 'remarks' => function ($q) {
            $q->orderBy('created_at', 'desc')->limit(1);
        }])->orderBy('created_at', 'desc');

        $user = Auth::user();
        
        // Filter leads based on user role (only for Sales leads section, not Customer Care)
        if (!request()->routeIs('customer-care.*')) {
            if ($user->hasRole('Admin')) {
                // Admin sees all leads assigned to Sales department users (only assigned leads, not unassigned)
                $salesUserIds = User::where('department', 'Sales')->pluck('id')->toArray();
                if (!empty($salesUserIds)) {
                    $leadsQuery->whereIn('assigned_user_id', $salesUserIds);
                } else {
                    // If no sales users exist, show no leads
                    $leadsQuery->whereRaw('1 = 0');
                }
            } elseif ($user->hasRole('Sales') || ($user->department === 'Sales' && !$user->hasRole('Sales Manager'))) {
                // Sales users see only their own assigned leads (not unassigned leads)
                $userId = $this->getCurrentUserId();
                if ($userId) {
                    $leadsQuery->where('assigned_user_id', $userId);
                }
            } elseif (!$this->canSeeAllLeads()) {
                // Other non-admin/manager users see only their own assigned leads
                $userId = $this->getCurrentUserId();
                if ($userId) {
                    $leadsQuery->where('assigned_user_id', $userId);
                }
            }
            // Sales Manager and other managers can see all leads (no additional filtering)
        } else {
            // For Customer Care routes - show unassigned leads AND leads assigned to current Customer Care user
            $userId = $this->getCurrentUserId();
            $leadsQuery->where(function ($query) use ($userId) {
                $query->whereNull('assigned_user_id') // Unassigned leads
                    ->orWhere('assigned_user_id', $userId); // Leads assigned to current user
            });
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

        $leads = $leadsQuery->paginate(25);
        $leads->appends($request->query());

        // Add latest remark to each lead
        $leads->getCollection()->transform(function ($lead) {
            $lead->latest_remark = $lead->remarks->first();
            return $lead;
        });

        $services = Service::orderBy('name')->get();
        $destinations = Destination::orderBy('name')->get();
        
        // Filter employees by department for Customer Care tab
        $employeesQuery = User::whereNotNull('user_id');
        if (request()->routeIs('customer-care.*')) {
            $employeesQuery->whereIn('department', ['Admin', 'Customer Care']);
        }
        $employees = $employeesQuery->orderBy('name')->get();

        return view('leads.index', [
            'leads' => $leads,
            'statuses' => $statuses,
            'filters' => $filters,
            'services' => $services,
            'destinations' => $destinations,
            'employees' => $employees,
            'indexRoute' => request()->routeIs('customer-care.*') ? 'customer-care.leads.index' : 'leads.index',
            'storeRoute' => request()->routeIs('customer-care.*') ? 'customer-care.leads.store' : 'leads.store',
            'destroyRoute' => request()->routeIs('customer-care.*') ? 'customer-care.leads.destroy' : 'leads.destroy',
            'editRoute' => request()->routeIs('customer-care.*') ? 'customer-care.leads.edit' : 'leads.edit',
            'bulkAssignRoute' => request()->routeIs('customer-care.*') ? 'customer-care.leads.bulkAssign' : 'leads.bulkAssign',
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

        $user = Auth::user();
        
        // Filter bookings based on user role (same logic as leads index)
        if ($user->hasRole('Admin')) {
            // Admin sees all booking files assigned to Sales department users (only assigned bookings, not unassigned)
            $salesUserIds = User::where('department', 'Sales')->pluck('id')->toArray();
            if (!empty($salesUserIds)) {
                $leadsQuery->whereIn('assigned_user_id', $salesUserIds);
            } else {
                // If no sales users exist, show no bookings
                $leadsQuery->whereRaw('1 = 0');
            }
        } elseif ($user->hasRole('Sales') || ($user->department === 'Sales' && !$user->hasRole('Sales Manager'))) {
            // Sales users see only their own assigned booking files (not unassigned bookings)
            $userId = $this->getCurrentUserId();
            if ($userId) {
                $leadsQuery->where('assigned_user_id', $userId);
            }
        } elseif (!$this->canSeeAllLeads()) {
            // Other non-admin/manager users see only their own assigned booking files
            $userId = $this->getCurrentUserId();
            if ($userId) {
                $leadsQuery->where('assigned_user_id', $userId);
            }
        }
        // Sales Manager and other managers can see all bookings (no additional filtering)

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

        $leads = $leadsQuery->paginate(25);
        $leads->appends($request->query());

        // Add latest remark to each lead
        $leads->getCollection()->transform(function ($lead) {
            $lead->latest_remark = $lead->remarks->first();
            return $lead;
        });

        $services = Service::orderBy('name')->get();
        $destinations = Destination::orderBy('name')->get();
        $employees = User::whereNotNull('user_id')->orderBy('name')->get();

        return view('booking.bookings', [
            'leads' => $leads,
            'filters' => $filters,
            'services' => $services,
            'destinations' => $destinations,
            'employees' => $employees,
        ]);
    }

    public function bookingForm(Lead $lead)
    {
        if (Auth::user()->hasRole('Customer Care')) {
            abort(403, 'Unauthorized access to Booking File.');
        }

        $lead->load([
            'service',
            'destination',
            'assignedUser',
            'createdBy',
            'bookedBy',
            'reassignedTo',
            'costComponents',
            'payments',
            'travellerDocuments',
            'bookingDestinations',
            'bookingArrivalDepartures',
            'bookingAccommodations',
            'bookingItineraries',
            'vendorPayments'
        ]);

        $employees = User::whereNotNull('user_id')->orderBy('name')->get();
        $destinations = \App\Models\Destination::with('locations')->orderBy('name')->get();
        
        // Check if user is from non-Sales department (Delivery, Post Sales, Accounts)
        // Operations can edit booking file, but Delivery, Post Sales, and Accounts are view-only
        $isViewOnly = $this->isNonSalesDepartment();
        
        // Determine back URL based on employee department and referrer
        $backUrl = route('bookings.index');
        $employee = Auth::user();
        $role = $employee->role ?? $employee->getRoleNameAttribute();
        
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

        // Customer payment summary (for red / yellow / green UI)
        $totalReceived = $lead->payments->where('status', 'received')->sum('amount');
        $sellingPrice = $lead->selling_price ?? 0;
        if ($sellingPrice <= 0 || $totalReceived <= 0) {
            $customerPaymentState = 'none';      // no payment received
        } elseif ($totalReceived >= $sellingPrice) {
            $customerPaymentState = 'full';      // fully received
        } else {
            $customerPaymentState = 'partial';   // partially received
        }
        
        // Check if user is from Ops department
        $user = Auth::user();
        $role = $user->role ?? $user->getRoleNameAttribute();
        $isOpsDept = $role && in_array($role, ['Operation', 'Operation Manager']);

        return view('booking.booking-form', [
            'lead' => $lead,
            'employees' => $employees,
            'destinations' => $destinations,
            'isViewOnly' => $isViewOnly,
            'backUrl' => $backUrl,
            'vendorPayments' => $vendorPayments,
            'isOpsDept' => $isOpsDept,
            'customerPaymentState' => $customerPaymentState,
            'totalCustomerReceived' => $totalReceived,
        ]);
    }

    public function create()
    {
        $services = Service::all();
        $destinations = Destination::all();
        $employees = User::whereNotNull('user_id')->orderBy('name')->get();
        return view('leads.create', compact('services', 'destinations', 'employees'));
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
            'return_date' => 'nullable|date',
            'adults' => 'required|integer|min:1',
            'children' => 'nullable|integer|min:0',
            'children_2_5' => 'nullable|integer|min:0',
            'children_6_11' => 'nullable|integer|min:0',
            'infants' => 'nullable|integer|min:0',
            'assigned_user_id' => 'nullable|exists:users,id',
            'status' => 'required|in:new,contacted,follow_up,priority,booked,closed,cancelled,refunded',
            'tsq' => 'nullable|string|max:255|unique:leads,tsq',
        ]);

        $data = $validated;
        $data['children_2_5'] = $data['children_2_5'] ?? 0;
        $data['children_6_11'] = $data['children_6_11'] ?? 0;
        $data['children'] = ($data['children_2_5'] ?? 0) + ($data['children_6_11'] ?? 0);
        
        // User ID is directly provided in the form now
        $data['assigned_user_id'] = $data['assigned_user_id'] ?? $this->getCurrentUserId();
        $data['status'] = $data['status'] ?? 'new';
        $data['created_by'] = $this->getCurrentUserId();

        // Set booked_by and booked_on if status is booked
        if ($data['status'] === 'booked') {
            $data['booked_by'] = $this->getCurrentUserId();
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
                    'follow_up_at' => $remark->follow_up_at ? $remark->follow_up_at->format('Y-m-d H:i:s') : null,
                    'follow_up_date' => $remark->follow_up_at ? $remark->follow_up_at->format('d M, Y') : null,
                    'follow_up_time' => $remark->follow_up_at ? $remark->follow_up_at->format('h:i A') : null,
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

            // Compute next follow-up (nearest future follow_up_at)
            $nextFollowUpRemark = $lead->remarks()->whereNotNull('follow_up_at')->where('follow_up_at', '>', now())->orderBy('follow_up_at', 'asc')->first();
            $nextFollowUp = null;
            if ($nextFollowUpRemark) {
                $nextFollowUp = [
                    'id' => $nextFollowUpRemark->id,
                    'follow_up_at' => $nextFollowUpRemark->follow_up_at ? $nextFollowUpRemark->follow_up_at->format('Y-m-d H:i:s') : null,
                    'follow_up_date' => $nextFollowUpRemark->follow_up_at ? $nextFollowUpRemark->follow_up_at->format('d M, Y') : null,
                    'follow_up_time' => $nextFollowUpRemark->follow_up_at ? $nextFollowUpRemark->follow_up_at->format('h:i A') : null,
                    'remark' => 
                        strlen($nextFollowUpRemark->remark) > 120 ? substr($nextFollowUpRemark->remark, 0, 120) . '...' : $nextFollowUpRemark->remark,
                ];
            }

            return response()->json([
                'lead' => [
                    'id' => $lead->id,
                    'tsq' => $lead->tsq,
                    'customer_name' => $lead->customer_name,
                    'salutation' => $lead->salutation,
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
                    'return_date' => $lead->return_date ? $lead->return_date->format('d M, Y') : null,
                    'return_date_raw' => $lead->return_date ? $lead->return_date->format('Y-m-d') : null,
                    'adults' => $lead->adults,
                    'children' => $lead->children,
                    'children_2_5' => $lead->children_2_5 ?? 0,
                    'children_6_11' => $lead->children_6_11 ?? 0,
                    'infants' => $lead->infants,
                    'assigned_user' => $lead->assignedUser?->name,
                    'assigned_user_email' => $lead->assignedUser?->email,
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
                'next_follow_up' => $nextFollowUp,
            ]);
        }

        return view('leads.index', compact('lead'));
    }

    public function edit(Lead $lead)
    {
        $services = Service::all();
        $destinations = Destination::all();
        $employees = User::whereNotNull('user_id')->orderBy('name')->get();
        return view('leads.edit', compact('lead', 'services', 'destinations', 'employees'));
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
            if (!empty($validated['reassigned_to'])) {
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
                'return_date' => 'nullable|date',
                'adults' => 'required|integer|min:1',
                'children' => 'nullable|integer|min:0',
                'children_2_5' => 'nullable|integer|min:0',
                'children_6_11' => 'nullable|integer|min:0',
                'infants' => 'nullable|integer|min:0',
                'assigned_user_id' => 'nullable|exists:users,id',
                'status' => 'required|in:new,contacted,follow_up,priority,booked,closed,cancelled,refunded',
                'reassigned_to' => 'nullable|exists:users,id',
                'tsq' => 'nullable|string|max:255|unique:leads,tsq,' . $lead->id,
            ]);

            $validated['children_2_5'] = $validated['children_2_5'] ?? 0;
            $validated['children_6_11'] = $validated['children_6_11'] ?? 0;
            $validated['children'] = ($validated['children_2_5'] ?? 0) + ($validated['children_6_11'] ?? 0);

            // Set booked_by and booked_on if status is changing to booked
            if ($validated['status'] === 'booked' && $lead->status !== 'booked') {
                $validated['booked_by'] = $this->getCurrentUserId();
                $validated['booked_on'] = now();
            }

            $lead->update($validated);
        }

        // Handle booking destinations - Removed legacy sync logic as it is now handled via AJAX

        // Handle unified arrival/departure details - Removed legacy sync logic as it is now handled via AJAX

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


        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Lead updated successfully!',
            ]);
        }

        return redirect()->back()->with('success', 'Lead updated successfully!');
    }

    public function destroy(Lead $lead)
    {
        $lead->delete();
        return redirect()->route('leads.index')->with('success', 'Lead deleted successfully!');
    }

    public function updateStatus(Request $request, Lead $lead)
    {
        $validated = $request->validate([
            'status' => 'required|in:new,contacted,follow_up,priority,booked,closed,cancelled,refunded',
            'note' => 'nullable|string',
        ]);

        $oldStatus = $lead->status;
        $updateData = ['status' => $validated['status']];

        // Set booked_by and booked_on if status is changing to booked
        if ($validated['status'] === 'booked' && $oldStatus !== 'booked') {
                $updateData['booked_by'] = $this->getCurrentUserId();
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

        $userId = $validated['assigned_user_id'];
        $lead->update(['assigned_user_id' => $userId]);
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

    public function updateSalesCost(Request $request, Lead $lead)
    {
        $validated = $request->validate([
            'selling_price' => 'required|numeric|min:0',
        ]);

        $lead->update([
            'selling_price' => $validated['selling_price'],
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Sales cost updated successfully!',
                'selling_price' => number_format($lead->selling_price, 2),
            ]);
        }

        return redirect()->back()->with('success', 'Sales cost updated successfully!');
    }

    public function updateReassignedUser(Request $request, Lead $lead)
    {
        $validated = $request->validate([
            'reassigned_to' => 'required|exists:users,id',
        ]);

        $lead->update([
            'reassigned_to' => $validated['reassigned_to'],
        ]);

        return redirect()->back()->with('success', 'Lead reassigned successfully!');
    }

    public function bulkAssign(Request $request)
    {
        $validated = $request->validate([
            'lead_ids' => 'required|array|min:1',
            'lead_ids.*' => 'required|exists:leads,id',
            'assigned_user_id' => 'required|exists:users,id',
        ]);

        $leadIds = $validated['lead_ids'];
        $userId = $validated['assigned_user_id'];

        $updatedCount = Lead::whereIn('id', $leadIds)->update(['assigned_user_id' => $userId]);

        $assignedUser = \App\Models\User::find($userId);

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

        // Only Operations team (or Admin) should update via this endpoint
        if (! $request->user()->hasAnyRole(['Admin', 'Operation', 'Operation Manager'])) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 403);
        }

        $validated = $request->validate([
            'vendor_code' => 'required|string|max:255',
            'booking_type' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'purchase_cost' => 'required|numeric|min:0',
            'due_date' => 'required|date',
            // Ops may only set Pending or Cancelled here; Paid can only be set by Accounts team
            'status' => 'nullable|string|in:Pending,Cancelled',
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

    public function storeBookingDestination(Request $request, Lead $lead)
    {
        $validated = $request->validate([
            'destination' => 'required|string',
            'location' => 'required|string',
            'only_hotel' => 'required|boolean',
            'only_tt' => 'required|boolean',
            'hotel_tt' => 'required|boolean',
            'from_date' => 'required|date',
            'to_date' => 'required|date',
        ]);

        $destination = $lead->bookingDestinations()->create($validated);
        session()->flash('success', 'Destination added successfully!');

        return response()->json([
            'message' => 'Destination added successfully!',
            'destination' => $destination
        ]);
    }

    public function updateBookingDestination(Request $request, Lead $lead, BookingDestination $bookingDestination)
    {
        $validated = $request->validate([
            'destination' => 'required|string',
            'location' => 'required|string',
            'only_hotel' => 'required|boolean',
            'only_tt' => 'required|boolean',
            'hotel_tt' => 'required|boolean',
            'from_date' => 'required|date',
            'to_date' => 'required|date',
        ]);

        $bookingDestination->update($validated);
        session()->flash('success', 'Destination updated successfully!');

        return response()->json([
            'message' => 'Destination updated successfully!',
            'destination' => $bookingDestination
        ]);
    }

    public function destroyBookingDestination(Lead $lead, BookingDestination $bookingDestination)
    {
        $bookingDestination->delete();
        session()->flash('success', 'Destination removed successfully!');

        return response()->json([
            'message' => 'Destination removed successfully!'
        ]);
    }

    public function storeBookingArrivalDeparture(Request $request, Lead $lead)
    {
        $validated = $request->validate([
            'mode' => 'required|string',
            'info' => 'nullable|string',
            'from_city' => 'required|string',
            'to_city' => 'required|string',
            'departure_date' => 'required|date',
            'departure_time' => 'required|string',
            'arrival_date' => 'required|date',
            'arrival_time' => 'required|string',
        ]);

        $arrivalDeparture = $lead->bookingArrivalDepartures()->create($validated);
        session()->flash('success', 'Arrival/Departure added successfully!');

        return response()->json([
            'message' => 'Arrival/Departure added successfully!',
            'arrivalDeparture' => $arrivalDeparture
        ]);
    }

    public function updateBookingArrivalDeparture(Request $request, Lead $lead, BookingArrivalDeparture $arrivalDeparture)
    {
        $validated = $request->validate([
            'mode' => 'required|string',
            'info' => 'nullable|string',
            'from_city' => 'required|string',
            'to_city' => 'required|string',
            'departure_date' => 'required|date',
            'departure_time' => 'required|string',
            'arrival_date' => 'required|date',
            'arrival_time' => 'required|string',
        ]);

        $arrivalDeparture->update($validated);
        session()->flash('success', 'Arrival/Departure updated successfully!');

        return response()->json([
            'message' => 'Arrival/Departure updated successfully!',
            'arrivalDeparture' => $arrivalDeparture
        ]);
    }

    public function destroyBookingArrivalDeparture(Lead $lead, BookingArrivalDeparture $arrivalDeparture)
    {
        $arrivalDeparture->delete();
        session()->flash('success', 'Arrival/Departure removed successfully!');

        return response()->json([
            'message' => 'Arrival/Departure removed successfully!'
        ]);
    }

    public function storeBookingAccommodation(Request $request, Lead $lead)
    {
        $validated = $request->validate([
            'destination' => 'required|string',
            'location' => 'required|string',
            'stay_at' => 'required|string',
            'checkin_date' => 'required|date',
            'checkout_date' => 'required|date',
            'room_type' => 'nullable|string',
            'meal_plan' => 'nullable|string',
        ]);

        $accommodation = $lead->bookingAccommodations()->create($validated);
        session()->flash('success', 'Accommodation added successfully!');

        return response()->json([
            'message' => 'Accommodation added successfully!',
            'accommodation' => $accommodation
        ]);
    }

    public function updateBookingAccommodation(Request $request, Lead $lead, BookingAccommodation $accommodation)
    {
        $validated = $request->validate([
            'destination' => 'required|string',
            'location' => 'required|string',
            'stay_at' => 'required|string',
            'checkin_date' => 'required|date',
            'checkout_date' => 'required|date',
            'room_type' => 'nullable|string',
            'meal_plan' => 'nullable|string',
        ]);

        $accommodation->update($validated);
        session()->flash('success', 'Accommodation updated successfully!');

        return response()->json([
            'message' => 'Accommodation updated successfully!',
            'accommodation' => $accommodation
        ]);
    }

    public function destroyBookingAccommodation(Lead $lead, BookingAccommodation $accommodation)
    {
        $accommodation->delete();
        session()->flash('success', 'Accommodation removed successfully!');

        return response()->json([
            'message' => 'Accommodation removed successfully!'
        ]);
    }

    public function storeBookingItinerary(Request $request, Lead $lead)
    {
        $validated = $request->validate([
            'day_and_date' => 'required|string',
            'time' => 'nullable|string',
            'location' => 'required|string',
            'activity_tour_description' => 'required|string',
            'stay_at' => 'nullable|string',
            'remarks' => 'nullable|string',
        ]);

        $itinerary = $lead->bookingItineraries()->create($validated);
        session()->flash('success', 'Itinerary entry added successfully!');

        return response()->json([
            'message' => 'Itinerary entry added successfully!',
            'itinerary' => $itinerary
        ]);
    }

    public function updateBookingItinerary(Request $request, Lead $lead, BookingItinerary $itinerary)
    {
        $validated = $request->validate([
            'day_and_date' => 'required|string',
            'time' => 'nullable|string',
            'location' => 'required|string',
            'activity_tour_description' => 'required|string',
            'stay_at' => 'nullable|string',
            'remarks' => 'nullable|string',
        ]);

        $itinerary->update($validated);
        session()->flash('success', 'Itinerary entry updated successfully!');

        return response()->json([
            'message' => 'Itinerary entry updated successfully!',
            'itinerary' => $itinerary
        ]);
    }

    public function destroyBookingItinerary(Lead $lead, BookingItinerary $itinerary)
    {
        $itinerary->delete();
        session()->flash('success', 'Itinerary entry removed successfully!');

        return response()->json([
            'message' => 'Itinerary entry removed successfully!'
        ]);
    }
}
