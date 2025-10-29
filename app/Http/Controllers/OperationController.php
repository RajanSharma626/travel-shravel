<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Operation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OperationController extends Controller
{
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
                    'approval_requested_by' => Auth::id(),
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
                $validated['approval_requested_by'] = Auth::id();
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
            'approval_approved_by' => Auth::id(),
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
}
