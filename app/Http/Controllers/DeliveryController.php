<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Delivery;
use App\Models\DeliveryFile;
use App\Models\Operation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DeliveryController extends Controller
{
    public function index(Request $request)
    {
        $filters = [
            'search' => $request->input('search'),
            'delivery_status' => $request->input('delivery_status'),
        ];

        // Show leads that have operations with status 'completed' (vouchered) or have deliveries
        $leadsQuery = Lead::with([
            'service', 
            'destination', 
            'assignedUser', 
            'delivery', 
            'delivery.assignedTo',
            'delivery.operation',
            'delivery.files',
            'operation', 
            'remarks' => function ($q) {
                $q->orderBy('created_at', 'desc')->limit(1);
            }
        ])
            ->where('status', 'booked')
            ->whereHas('operation', function ($q) {
                $q->where('operation_status', 'completed'); // Vouchered/Completed operations
            })
            ->orderBy('created_at', 'desc');

        // Search filter
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

        // Filter by delivery status if provided
        if (!empty($filters['delivery_status'])) {
            $leadsQuery->whereHas('delivery', function ($q) use ($filters) {
                $q->where('delivery_status', $filters['delivery_status']);
            });
        }

        $leads = $leadsQuery->paginate(20);
        $leads->appends($request->query());

        // Add latest remark to each lead
        $leads->getCollection()->transform(function ($lead) {
            $lead->latest_remark = $lead->remarks->first();
            return $lead;
        });

        $services = \App\Models\Service::orderBy('name')->get();
        $destinations = \App\Models\Destination::orderBy('name')->get();
        $users = \App\Models\User::orderBy('name')->get();
        
        // Get delivery team users
        $deliveryUsers = User::whereHas('roles', function ($q) {
            $q->whereIn('name', ['Delivery', 'Admin']);
        })->orderBy('name')->get();

        return view('deliveries.index', compact('leads', 'filters', 'services', 'destinations', 'users', 'deliveryUsers'));
    }

    /**
     * API: Get deliveries with pending/assigned filter
     */
    public function apiIndex(Request $request)
    {
        if (!$request->user()->hasAnyRole(['Admin', 'Delivery', 'Operations'])) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $query = Delivery::with(['lead', 'lead.service', 'lead.destination', 'operation', 'assignedTo', 'files']);

        // Filter by status
        if ($request->has('status')) {
            $query->where('delivery_status', $request->status);
        }

        // Filter by assigned
        if ($request->has('assigned')) {
            if ($request->assigned === 'true') {
                $query->whereNotNull('assigned_to_delivery_user_id');
            } else {
                $query->whereNull('assigned_to_delivery_user_id');
            }
        }

        $deliveries = $query->orderBy('created_at', 'desc')->get();

        return response()->json([
            'success' => true,
            'deliveries' => $deliveries->map(function ($delivery) {
                return [
                    'id' => $delivery->id,
                    'lead_id' => $delivery->lead_id,
                    'lead' => [
                        'id' => $delivery->lead->id,
                        'tsq' => $delivery->lead->tsq,
                        'customer_name' => $delivery->lead->customer_name,
                    ],
                    'operation_id' => $delivery->operation_id,
                    'assigned_to_delivery_user_id' => $delivery->assigned_to_delivery_user_id,
                    'assigned_to' => $delivery->assignedTo ? [
                        'id' => $delivery->assignedTo->id,
                        'name' => $delivery->assignedTo->name,
                    ] : null,
                    'delivery_status' => $delivery->delivery_status,
                    'courier_id' => $delivery->courier_id,
                    'delivery_method' => $delivery->delivery_method,
                    'remarks' => $delivery->remarks,
                    'delivered_at' => $delivery->delivered_at ? $delivery->delivered_at->format('Y-m-d H:i:s') : null,
                    'files' => $delivery->files->map(function ($file) {
                        return [
                            'id' => $file->id,
                            'file_path' => $file->file_path,
                            'file_name' => $file->file_name,
                            'file_type' => $file->file_type,
                            'description' => $file->description,
                        ];
                    }),
                    'created_at' => $delivery->created_at->format('Y-m-d H:i:s'),
                ];
            }),
        ]);
    }

    /**
     * API: Assign delivery to delivery team
     */
    public function assign(Request $request, Delivery $delivery)
    {
        // Only Operations and Admin can assign
        if (!$request->user()->hasAnyRole(['Admin', 'Operations'])) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'assigned_to_delivery_user_id' => 'required|exists:users,id',
        ]);

        $delivery->update($validated);

        // TODO: Send notification to delivery user, admin, and salesperson
        // Notification::send(...)

        return response()->json([
            'success' => true,
            'message' => 'Delivery assigned successfully',
            'delivery' => $delivery->load('assignedTo'),
        ]);
    }

    /**
     * API: Update delivery status and attach metadata
     */
    public function updateStatus(Request $request, Delivery $delivery)
    {
        // Only Delivery Team and Admin can update status
        if (!$request->user()->hasAnyRole(['Admin', 'Delivery'])) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'delivery_status' => 'required|in:Pending,In_Process,Delivered',
            'courier_id' => 'nullable|string|max:255',
            'delivery_method' => 'nullable|in:soft_copy,courier,hand_delivery',
            'remarks' => 'nullable|string',
        ]);

        // Set delivered_at if status is Delivered
        if ($validated['delivery_status'] === 'Delivered' && !$delivery->delivered_at) {
            $validated['delivered_at'] = now();
        }

        $delivery->update($validated);

        // TODO: Send notification if delivered
        if ($validated['delivery_status'] === 'Delivered') {
            // Notification::send(...)
        }

        return response()->json([
            'success' => true,
            'message' => 'Delivery status updated successfully',
            'delivery' => $delivery->fresh(),
        ]);
    }

    /**
     * API: Upload delivery files
     */
    public function uploadFiles(Request $request, Delivery $delivery)
    {
        if (!$request->user()->hasAnyRole(['Admin', 'Delivery'])) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'files' => 'required|array',
            'files.*' => 'file|max:10240', // 10MB max
            'descriptions' => 'nullable|array',
        ]);

        $uploadedFiles = [];

        foreach ($request->file('files') as $index => $file) {
            $path = $file->store('deliveries/' . $delivery->lead_id, 'public');
            
            $description = $validated['descriptions'][$index] ?? null;

            $deliveryFile = DeliveryFile::create([
                'delivery_id' => $delivery->id,
                'file_path' => $path,
                'file_name' => $file->getClientOriginalName(),
                'file_type' => $file->getMimeType(),
                'file_size' => $file->getSize(),
                'description' => $description,
            ]);

            $uploadedFiles[] = $deliveryFile;
        }

        return response()->json([
            'success' => true,
            'message' => 'Files uploaded successfully',
            'files' => $uploadedFiles,
        ]);
    }

    /**
     * API: Export deliveries (Admin only)
     */
    public function export(Request $request)
    {
        if (!$request->user()->hasRole('Admin')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $deliveries = Delivery::with(['lead', 'assignedTo', 'operation'])
            ->orderBy('created_at', 'desc')
            ->get();

        $data = $deliveries->map(function ($delivery) {
            return [
                'TSQ' => $delivery->lead->tsq ?? 'N/A',
                'Customer Name' => $delivery->lead->customer_name,
                'Delivery Status' => $delivery->delivery_status,
                'Assigned To' => $delivery->assignedTo ? $delivery->assignedTo->name : 'Unassigned',
                'Delivery Method' => $delivery->delivery_method ?? 'N/A',
                'Courier ID' => $delivery->courier_id ?? 'N/A',
                'Delivered At' => $delivery->delivered_at ? $delivery->delivered_at->format('Y-m-d H:i:s') : 'N/A',
                'Created At' => $delivery->created_at->format('Y-m-d H:i:s'),
            ];
        });

        $filename = 'deliveries_export_' . date('Y-m-d_His') . '.csv';

        return Excel::download(new class($data) implements FromCollection, WithHeadings {
            private $data;

            public function __construct($data) {
                $this->data = $data;
            }

            public function collection() {
                return $this->data;
            }

            public function headings(): array {
                return ['TSQ', 'Customer Name', 'Delivery Status', 'Assigned To', 'Delivery Method', 'Courier ID', 'Delivered At', 'Created At'];
            }
        }, $filename);
    }

    public function show(Lead $lead)
    {
        return redirect()->route('leads.show', $lead)->with('active_tab', 'delivery');
    }

    public function store(Request $request, Lead $lead)
    {
        // Only Operations and Admin can create deliveries
        if (!Auth::user()->hasAnyRole(['Admin', 'Operations'])) {
            return redirect()->back()->with('error', 'Unauthorized');
        }

        // Check if operation is completed (vouchered)
        if (!$lead->operation || $lead->operation->operation_status !== 'completed') {
            return redirect()->back()->with('error', 'Delivery can only be created after operation is vouchered');
        }

        $validated = $request->validate([
            'assigned_to_delivery_user_id' => 'required|exists:users,id',
            'delivery_method' => 'nullable|in:soft_copy,courier,hand_delivery',
            'remarks' => 'nullable|string',
        ]);

        $delivery = $lead->delivery()->create([
            'operation_id' => $lead->operation->id,
            'assigned_to_delivery_user_id' => $validated['assigned_to_delivery_user_id'],
            'delivery_status' => 'Pending',
            'delivery_method' => $validated['delivery_method'] ?? null,
            'remarks' => $validated['remarks'] ?? null,
        ]);

        // TODO: Send notification

        return redirect()->back()->with('success', 'Delivery created successfully!');
    }

    public function update(Request $request, Lead $lead, Delivery $delivery)
    {
        // Only Delivery Team and Admin can update
        if (!Auth::user()->hasAnyRole(['Admin', 'Delivery'])) {
            return redirect()->back()->with('error', 'Unauthorized');
        }

        $validated = $request->validate([
            'delivery_status' => 'required|in:Pending,In_Process,Delivered',
            'courier_id' => 'nullable|string|max:255',
            'delivery_method' => 'nullable|in:soft_copy,courier,hand_delivery',
            'remarks' => 'nullable|string',
        ]);

        if ($validated['delivery_status'] === 'Delivered' && !$delivery->delivered_at) {
            $validated['delivered_at'] = now();
        }

        $delivery->update($validated);

        // TODO: Send notification if delivered

        return redirect()->back()->with('success', 'Delivery updated successfully!');
    }
}
