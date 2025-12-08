<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Payment;
use App\Models\CostComponent;
use App\Models\ProfitLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $filters = [
            'search' => $request->input('search'),
            'payment_status' => $request->input('payment_status'),
        ];

        // Show all leads with payment and cost information for Accounts team
        $leadsQuery = Lead::with(['service', 'destination', 'assignedUser', 'payments', 'costComponents', 'operation', 'remarks' => function ($q) {
            $q->orderBy('created_at', 'desc')->limit(1);
        }])
            ->orderBy('created_at', 'desc');

        // Search filter
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

        // Filter by payment status if provided
        if (!empty($filters['payment_status'])) {
            $leadsQuery->whereHas('payments', function ($q) use ($filters) {
                $q->where('status', $filters['payment_status']);
            });
        }

        $leads = $leadsQuery->paginate(20);
        $leads->appends($request->query());

        // Add latest remark to each lead
        $leads->getCollection()->transform(function ($lead) {
            $lead->latest_remark = $lead->remarks->first();
            return $lead;
        });

        // Calculate totals - use new status 'received' instead of 'paid'
        $totalRevenue = Payment::where('status', 'received')->sum('amount');
        $totalCost = CostComponent::sum('amount');
        $netProfit = $totalRevenue - $totalCost;

        $services = \App\Models\Service::orderBy('name')->get();
        $destinations = \App\Models\Destination::orderBy('name')->get();
        $users = \App\Models\User::orderBy('name')->get();

        return view('accounts.index', compact('leads', 'filters', 'totalRevenue', 'totalCost', 'netProfit', 'services', 'destinations', 'users'));
    }

    public function show(Lead $lead)
    {
        // Redirect to lead show page - payments section
        return redirect()->route('leads.show', $lead)->with('active_tab', 'payments');
    }

    public function store(Request $request, Lead $lead)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0',
            'method' => 'required|in:cash,bank_transfer,cheque,card,online',
            'payment_date' => 'required|date',
            'reference' => 'nullable|string|max:255',
            'status' => 'required|in:pending,received,refunded',
        ]);

        $validated['created_by'] = Auth::id();
        $lead->payments()->create($validated);
        
        // Calculate and log profit
        $this->calculateAndLogProfit($lead);
        
        return redirect()->back()->with('success', 'Payment added successfully!');
    }
    
    /**
     * API: Dashboard metrics
     */
    public function dashboard(Request $request)
    {
        if (!$request->user()->hasAnyRole(['Admin', 'Accounts', 'Accounts Manager'])) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        $totalRevenue = Payment::where('status', 'received')->sum('amount');
        $totalCost = CostComponent::sum('amount');
        $netProfit = $totalRevenue - $totalCost;
        
        return response()->json([
            'total_revenue' => $totalRevenue,
            'total_cost' => $totalCost,
            'net_profit' => $netProfit,
        ]);
    }
    
    /**
     * API: Get leads with payment & cost data
     */
    public function leads(Request $request)
    {
        if (!$request->user()->hasAnyRole(['Admin', 'Accounts', 'Accounts Manager'])) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        $leadsQuery = Lead::with(['service', 'destination', 'assignedUser', 'payments', 'costComponents', 'remarks' => function ($q) {
            $q->orderBy('created_at', 'desc')->limit(1);
        }])
            ->orderBy('created_at', 'desc');
        
        // Search filter
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = '%' . trim($request->search) . '%';
            $leadsQuery->where(function ($query) use ($searchTerm) {
                $query->where('customer_name', 'like', $searchTerm)
                    ->orWhere('tsq', 'like', $searchTerm)
                    ->orWhere('phone', 'like', $searchTerm);
            });
        }
        
        $leads = $leadsQuery->paginate(20);
        
        // Transform leads with calculated values
        $leads->getCollection()->transform(function ($lead) {
            $totalPaid = $lead->payments->where('status', 'received')->sum('amount');
            $totalCost = $lead->costComponents->sum('amount');
            $profit = ($lead->selling_price ?? 0) - $totalCost;
            
            return [
                'id' => $lead->id,
                'tsq' => $lead->tsq,
                'customer_name' => $lead->customer_name,
                'phone' => $lead->primary_phone ?? $lead->phone,
                'total_paid' => $totalPaid,
                'total_cost' => $totalCost,
                'profit' => $profit,
                'last_remark' => $lead->remarks->first()?->remark,
                'created_at' => $lead->created_at->format('Y-m-d'),
            ];
        });
        
        return response()->json($leads);
    }
    
    /**
     * API: Add payment (with installment support)
     */
    public function addPayment(Request $request, Lead $lead)
    {
        if (!$request->user()->hasAnyRole(['Admin', 'Accounts', 'Accounts Manager'])) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0',
            'method' => 'required|in:cash,bank_transfer,cheque,card,online',
            'payment_date' => 'required|date',
            'reference' => 'nullable|string|max:255',
            'status' => 'required|in:pending,received,refunded',
        ]);
        
        $validated['created_by'] = Auth::id();
        $payment = $lead->payments()->create($validated);
        
        // Calculate and log profit
        $this->calculateAndLogProfit($lead);
        
        return response()->json([
            'success' => true,
            'message' => 'Payment added successfully',
            'payment' => $payment,
        ]);
    }
    
    /**
     * API: Export accounts data (Admin only)
     */
    public function export(Request $request)
    {
        if (!$request->user()->hasRole('Admin')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        $leads = Lead::with(['payments', 'costComponents'])->get();
        
        $data = $leads->map(function ($lead) {
            $totalPaid = $lead->payments->where('status', 'received')->sum('amount');
            $totalCost = $lead->costComponents->sum('amount');
            $profit = ($lead->selling_price ?? 0) - $totalCost;
            
            return [
                'TSQ' => $lead->tsq,
                'Customer Name' => $lead->customer_name,
                'Phone' => $lead->primary_phone ?? $lead->phone,
                'Total Paid' => $totalPaid,
                'Total Cost' => $totalCost,
                'Profit' => $profit,
                'Created On' => $lead->created_at->format('Y-m-d'),
            ];
        });
        
        $filename = 'accounts_export_' . date('Y-m-d_His') . '.csv';
        
        return Excel::download(new class($data) implements FromCollection, WithHeadings {
            private $data;
            
            public function __construct($data) {
                $this->data = $data;
            }
            
            public function collection() {
                return $this->data;
            }
            
            public function headings(): array {
                return ['TSQ', 'Customer Name', 'Phone', 'Total Paid', 'Total Cost', 'Profit', 'Created On'];
            }
        }, $filename);
    }
    
    /**
     * Calculate and log profit for a lead
     */
    private function calculateAndLogProfit(Lead $lead)
    {
        $totalSellingPrice = $lead->selling_price ?? 0;
        $totalCost = $lead->costComponents->sum('amount');
        $profit = $totalSellingPrice - $totalCost;
        
        ProfitLog::create([
            'lead_id' => $lead->id,
            'total_selling_price' => $totalSellingPrice,
            'total_cost' => $totalCost,
            'profit' => $profit,
            'computed_at' => now(),
        ]);
    }

    public function update(Request $request, Lead $lead, Payment $payment)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0',
            'method' => 'required|in:cash,bank_transfer,cheque,card,online',
            'payment_date' => 'required|date',
            'reference' => 'nullable|string|max:255',
            'status' => 'required|in:pending,received,refunded',
        ]);

        $payment->update($validated);
        
        // Calculate and log profit
        $this->calculateAndLogProfit($lead);
        
        if ($request->expectsJson() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Payment updated successfully!',
                'payment' => $payment
            ]);
        }
        
        return redirect()->back()->with('success', 'Payment updated successfully!');
    }

    public function destroy(Request $request, Lead $lead, Payment $payment)
    {
        $payment->delete();
        
        // Recalculate profit after deletion
        $this->calculateAndLogProfit($lead);
        
        if ($request->expectsJson() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Payment deleted successfully!'
            ]);
        }
        
        return redirect()->back()->with('success', 'Payment deleted successfully!');
    }
}
