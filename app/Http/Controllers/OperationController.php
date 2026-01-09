<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Operation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OperationController extends Controller
{
    public function index(Request $request)
    {
        $filters = [
            'search' => $request->input('search'),
        ];

        // Show booked leads for Operations team
        $leadsQuery = Lead::with(['service', 'destination', 'assignedUser', 'operation', 'remarks' => function ($q) {
            $q->orderBy('created_at', 'desc')->limit(1);
        }, 'bookingFileRemarks' => function ($q) {
            $q->orderBy('created_at', 'desc')->limit(1)->with('user');
        }])
            ->where('status', 'booked')
            ->orderBy('created_at', 'desc');

        $currentUser = Auth::user();
        $isAdmin = $currentUser->hasRole('Admin') || $currentUser->hasRole('Developer');
        $userRole = $currentUser->role ?? $currentUser->getRoleNameAttribute();
        $userDepartment = $currentUser->department;

        // Filter booking files based on user role
        if ($isAdmin) {
            // Admin/Developer: Show all booked leads assigned to Operation, Ticketing, Cruise, Visa, Insurance department users
            $opsDepartmentUserIds = User::where(function ($query) {
                $query->where('department', 'Operation')
                    ->orWhere('department', 'Ticketing')
                    ->orWhere('department', 'Cruise')
                    ->orWhere('department', 'Visa')
                    ->orWhere('department', 'Insurance')
                    ->orWhere('role', 'Operation')
                    ->orWhere('role', 'Operation Manager')
                    ->orWhere('role', 'Ticketing')
                    ->orWhere('role', 'Cruise')
                    ->orWhere('role', 'Visa')
                    ->orWhere('role', 'Insurance');
            })->pluck('id');
            
            $leadsQuery->whereIn('assigned_user_id', $opsDepartmentUserIds);
        } else {
            // Operation/Ticketing/Cruise/Visa/Insurance users: Show only their own assigned booking files
            $userId = $this->getCurrentUserId();
            if ($userId) {
                $leadsQuery->where('assigned_user_id', $userId);
            }
        }

        // Search filter - same as bookings page
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

        // Add latest remark and booking file remark to each lead
        $leads->getCollection()->transform(function ($lead) {
            $lead->latest_remark = $lead->remarks->first();
            $lead->latest_booking_file_remark = $lead->bookingFileRemarks->first();
            return $lead;
        });

        $services = \App\Models\Service::orderBy('name')->get();
        $destinations = \App\Models\Destination::orderBy('name')->get();
        $employees = User::whereNotNull('user_id')->orderBy('name')->get();

        return view('operations.index', compact('leads', 'filters', 'services', 'destinations', 'employees'));
    }

    public function store(Request $request, Lead $lead)
    {
        $validated = $request->validate([
            'operation_status' => 'required|in:pending,in_progress,completed,cancelled',
            'nett_cost' => 'nullable|numeric|min:0',
            'internal_notes' => 'nullable|string',
        ]);

        $operation = $lead->operation()->create($validated);

        // Check if nett cost causes loss
        if ($validated['nett_cost'] && $lead->selling_price) {
            $profit = $lead->selling_price - $validated['nett_cost'];
            if ($profit < 0) {
                $operation->update([
                    'admin_approval_required' => true,
                    'approval_reason' => 'Nett cost exceeds selling price. Profit: ' . number_format($profit, 2),
                    'approval_requested_by' => $this->getCurrentUserId(),
                    'approval_requested_at' => now(),
                ]);
            }
        }

        return redirect()->back()->with('success', 'Operation record created successfully!');
    }

    public function update(Request $request, Lead $lead, Operation $operation)
    {
        $validated = $request->validate([
            'operation_status' => 'required|in:pending,in_progress,completed,cancelled',
            'nett_cost' => 'nullable|numeric|min:0',
            'internal_notes' => 'nullable|string',
        ]);

        $oldNettCost = $operation->nett_cost;
        $newNettCost = $validated['nett_cost'] ?? $oldNettCost;

        // Check if nett cost change causes loss
        if ($newNettCost && $lead->selling_price && $newNettCost != $oldNettCost) {
            $profit = $lead->selling_price - $newNettCost;
            if ($profit < 0) {
                $validated['admin_approval_required'] = true;
                $validated['approval_reason'] = 'Nett cost exceeds selling price. Profit: ' . number_format($profit, 2);
                $validated['approval_requested_by'] = $this->getCurrentUserId();
                $validated['approval_requested_at'] = now();
            } else {
                $validated['admin_approval_required'] = false;
                $validated['approval_reason'] = null;
            }
        }

        $operation->update($validated);
        return redirect()->back()->with('success', 'Operation updated successfully!');
    }

    public function approve(Request $request, Lead $lead, Operation $operation)
    {
        if (!Auth::user() || !Auth::user()->can('approve operations')) {
            return redirect()->back()->with('error', 'You do not have permission to approve operations!');
        }

        $operation->update([
            'admin_approval_required' => false,
            'approval_approved_by' => $this->getCurrentUserId(),
            'approval_approved_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Operation approved successfully!');
    }

    public function reject(Request $request, Lead $lead, Operation $operation)
    {
        if (!Auth::user() || !Auth::user()->can('approve operations')) {
            return redirect()->back()->with('error', 'You do not have permission to reject operations!');
        }

        $operation->update([
            'admin_approval_required' => false,
            'approval_reason' => 'Rejected: ' . ($request->rejection_reason ?? 'No reason provided'),
        ]);

        return redirect()->back()->with('success', 'Operation rejected!');
    }

    public function bookingFile(Lead $lead)
    {
        $lead->load([
            'service',
            'destination',
            'assignedUser',
            'createdBy',
            'bookedBy',
            'reassignedTo',
            'costComponents',
            'payments',
            'bookingDestinations',
            'bookingArrivalDepartures',
            'bookingAccommodations',
            'bookingItineraries',
            'vendorPayments',
            'operation',
            'bookingFileRemarks.user',
            'histories.changedBy'
        ]);

        $employees = User::whereNotNull('user_id')->orderBy('name')->get();
        $destinations = \App\Models\Destination::with('locations')->orderBy('name')->get();
        
        // Ops booking file is now editable - Operations can add/edit booking file
        $isViewOnly = false;
        $isOpsDept = true; // This is Ops booking file
        $backUrl = route('operations.index');
        $vendorPayments = $lead->vendorPayments;

        // Customer payment summary (for red / yellow / green UI)
        $totalReceived = $lead->payments->where('status', 'received')->sum('amount');
        $sellingPrice = $lead->selling_price ?? 0;
        if ($sellingPrice <= 0 || $totalReceived <= 0) {
            $customerPaymentState = 'none';
        } elseif ($totalReceived >= $sellingPrice) {
            $customerPaymentState = 'full';
        } else {
            $customerPaymentState = 'partial';
        }

        // Get stage info for current user's department
        $userDepartment = $this->getUserDepartment();
        $stageInfo = $this->getDepartmentStages($userDepartment);
        $currentStage = $lead->{$stageInfo['stage_key']} ?? 'Pending';

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
            'stageInfo' => $stageInfo,
            'currentStage' => $currentStage,
        ]);
    }
}
