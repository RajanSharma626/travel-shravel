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
    public function index()
    {
        $leads = Lead::with(['service', 'destination', 'assignedUser', 'remarks' => function($q) {
            $q->latest()->limit(1);
        }])->latest()->paginate(20);
        
        // Add latest remark to each lead
        $leads->getCollection()->transform(function($lead) {
            $lead->latest_remark = $lead->remarks->first();
            return $lead;
        });
        
        return view('leads.index', compact('leads'));
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
            'customer_name' => 'required|string|max:255',
            'phone' => 'required',
            'email' => 'nullable|email',
            'service_id' => 'nullable|exists:services,id',
            'destination_id' => 'nullable|exists:destinations,id',
            'address' => 'nullable|string',
            'travel_date' => 'nullable|date',
            'adults' => 'nullable|integer|min:1',
            'children' => 'nullable|integer|min:0',
            'infants' => 'nullable|integer|min:0',
            'selling_price' => 'nullable|numeric|min:0',
            'booked_value' => 'nullable|numeric|min:0',
            'assigned_user_id' => 'nullable|exists:users,id',
        ]);
        
        Lead::create($validated + ['assigned_user_id' => $validated['assigned_user_id'] ?? Auth::id(), 'status' => 'new']);
        return redirect()->route('leads.index')->with('success', 'Lead created successfully!');
    }

    public function show(Lead $lead)
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
        
        return view('leads.show', compact('lead'));
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
            'customer_name' => 'required|string|max:255',
            'phone' => 'required',
            'email' => 'nullable|email',
            'service_id' => 'nullable|exists:services,id',
            'destination_id' => 'nullable|exists:destinations,id',
            'address' => 'nullable|string',
            'travel_date' => 'nullable|date',
            'adults' => 'nullable|integer|min:1',
            'children' => 'nullable|integer|min:0',
            'infants' => 'nullable|integer|min:0',
            'selling_price' => 'nullable|numeric|min:0',
            'booked_value' => 'nullable|numeric|min:0',
            'assigned_user_id' => 'nullable|exists:users,id',
            'status' => 'required|in:new,contacted,follow_up,priority,booked,closed',
        ]);
        
        $lead->update($validated);
        return redirect()->route('leads.show', $lead)->with('success', 'Lead updated successfully!');
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

        $lead->update(['assigned_user_id' => $validated['assigned_user_id']]);

        return redirect()->back()->with('success', 'Assigned user updated successfully!');
    }

    public function followUp()
    {
        $user = Auth::user();
        
        // Check if user is Admin
        $isAdmin = $user->hasRole('Admin');
        
        // Check if user is Sales or Post Sales (including managers)
        $isSalesOrPostSales = $user->hasAnyRole(['Admin', 'Sales', 'Sales Manager', 'Post Sales', 'Post Sales Manager']);
        
        // Build query for follow-up leads
        $query = Lead::where('status', 'follow_up')
            ->with(['service', 'destination', 'assignedUser', 'remarks' => function($q) {
                $q->latest()->limit(1);
            }]);
        
        // For Sales and Post Sales users (non-admin), show only their assigned leads
        if (!$isAdmin && $isSalesOrPostSales) {
            $query->where('assigned_user_id', $user->id);
        }
        
        // Get leads with their latest remark
        $leads = $query->get()->map(function($lead) {
            $lead->latest_remark = $lead->remarks->first();
            return $lead;
        })->sortBy(function($lead) {
            // Sort by follow_up_date if available, otherwise by remark created_at, otherwise by lead updated_at
            if ($lead->latest_remark && $lead->latest_remark->follow_up_date) {
                return $lead->latest_remark->follow_up_date->toDateString();
            } elseif ($lead->latest_remark) {
                return $lead->latest_remark->created_at->format('Y-m-d H:i:s');
            } else {
                return $lead->updated_at->format('Y-m-d H:i:s');
            }
        })->values();
        
        // Paginate manually since we sorted after getting data
        $perPage = 20;
        $currentPage = request()->get('page', 1);
        $items = $leads->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $leads = new \Illuminate\Pagination\LengthAwarePaginator(
            $items,
            $leads->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );
        
        return view('leads.follow-up', compact('leads', 'isAdmin'));
    }
}
