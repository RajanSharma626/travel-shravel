<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\Lead;
use App\Models\Service;
use App\Models\User;
use App\Models\LeadHistory;
use App\Models\LeadRemark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LeadController extends Controller
{
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

        if (!empty($filters['status'])) {
            $leadsQuery->where('status', $filters['status']);
        }

        if (!empty($filters['search'])) {
            $searchTerm = trim($filters['search']);
            $likeTerm = '%' . $searchTerm . '%';

            $leadsQuery->where(function ($query) use ($likeTerm) {
                $query->where('customer_name', 'like', $likeTerm)
                    ->orWhere('first_name', 'like', $likeTerm)
                    ->orWhere('middle_name', 'like', $likeTerm)
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
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
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

            return response()->json([
                'lead' => [
                    'id' => $lead->id,
                    'tsq' => $lead->tsq,
                    'customer_name' => $lead->customer_name,
                    'first_name' => $lead->first_name,
                    'middle_name' => $lead->middle_name,
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
                    'updated_at' => $lead->updated_at?->format('d M, Y h:i A'),
                    'urls' => [
                        'show' => route('leads.show', $lead),
                        'remarks_store' => route('leads.remarks.store', $lead),
                    ],
                ],
                'remarks' => $remarks,
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
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
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

        $validated['children_2_5'] = $validated['children_2_5'] ?? 0;
        $validated['children_6_11'] = $validated['children_6_11'] ?? 0;
        $validated['children'] = ($validated['children_2_5'] ?? 0) + ($validated['children_6_11'] ?? 0);

        $lead->update($validated);

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
        $lead->update(['status' => $validated['status']]);

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

}
