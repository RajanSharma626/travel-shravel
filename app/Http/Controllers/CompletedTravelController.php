<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompletedTravelController extends Controller
{
    public function index(Request $request)
    {
        $filters = [
            'search' => $request->input('search'),
            'service_id' => $request->input('service_id'),
            'destination_id' => $request->input('destination_id'),
        ];

        // Query for leads where return_date has passed (travels are completed)
        $leadsQuery = Lead::with([
            'service',
            'destination',
            'assignedUser',
            'remarks' => function ($q) {
                $q->orderBy('created_at', 'desc')->limit(1);
            },
            'bookingFileRemarks' => function ($q) {
                $q->orderBy('created_at', 'desc')->limit(1)->with('user');
            }
        ])
            ->where('status', 'booked')
            ->whereNotNull('return_date')
            ->whereDate('return_date', '<', now()->toDateString())
            ->orderBy('return_date', 'desc');

        // Apply search filter
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $leadsQuery->where(function ($query) use ($search) {
                $query->where('tsq', 'like', "%{$search}%")
                    ->orWhere('customer_name', 'like', "%{$search}%")
                    ->orWhere('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Apply service filter
        if (!empty($filters['service_id'])) {
            $leadsQuery->where('service_id', $filters['service_id']);
        }

        // Apply destination filter
        if (!empty($filters['destination_id'])) {
            $leadsQuery->where('destination_id', $filters['destination_id']);
        }

        $leads = $leadsQuery->paginate(20)->withQueryString();

        // Transform leads to add latest remark
        $leads->getCollection()->transform(function ($lead) {
            $lead->latest_remark = $lead->remarks->first();
            $lead->latest_booking_file_remark = $lead->bookingFileRemarks->first();
            return $lead;
        });

        // Get filter options
        $services = \App\Models\Service::orderBy('name')->get();
        $destinations = \App\Models\Destination::orderBy('name')->get();

        return view('completed-travels.index', [
            'leads' => $leads,
            'filters' => $filters,
            'services' => $services,
            'destinations' => $destinations,
        ]);
    }

    public function bookingFile(Lead $lead)
    {
        // Verify that this lead is a completed travel (return_date has passed)
        if (!$lead->return_date || $lead->return_date->isFuture()) {
            abort(403, 'This travel is not yet completed.');
        }

        // Load all necessary relationships
        $lead->load([
            'service',
            'destination',
            'assignedUser',
            'createdBy',
            'bookedBy',
            'reassignedTo',
            'costComponents',
            'payments',
            'vendorPayments',
            'accountSummaries',
            'travellerDocuments',
            'bookingDestinations',
            'bookingArrivalDepartures',
            'bookingAccommodations',
            'bookingItineraries',
            'operation',
            'delivery',
            'delivery.assignedTo',
            'delivery.files',
            'bookingFileRemarks.user',
            'histories.changedBy'
        ]);

        $employees = \App\Models\User::whereNotNull('user_id')->orderBy('name')->get();
        $users = \App\Models\User::orderBy('name')->get();
        $destinations = \App\Models\Destination::with('locations')->orderBy('name')->get();
        
        // Completed travels booking file is completely read-only
        $isViewOnly = true;
        $isCompletedTravel = true;
        $isOpsDept = false; // Completed travels are not from Ops department
        $isPostSales = false; // Completed travels are not from Post Sales department
        $backUrl = route('completed-travels.index');
        
        $accountSummaries = $lead->accountSummaries ?? collect();
        $vendorPayments = $lead->vendorPayments ?? collect();
        
        // Customer payment summary
        $totalReceived = $lead->payments->where('status', 'received')->sum('amount');
        $sellingPrice = $lead->selling_price ?? 0;
        if ($sellingPrice <= 0 || $totalReceived <= 0) {
            $customerPaymentState = 'none';
        } elseif ($totalReceived >= $sellingPrice) {
            $customerPaymentState = 'full';
        } else {
            $customerPaymentState = 'partial';
        }

        return view('booking.booking-form', compact(
            'lead',
            'employees',
            'users',
            'destinations',
            'isViewOnly',
            'isCompletedTravel',
            'isOpsDept',
            'isPostSales',
            'backUrl',
            'accountSummaries',
            'vendorPayments',
            'customerPaymentState',
            'totalReceived'
        ));
    }
}

