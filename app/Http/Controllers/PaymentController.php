<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function store(Request $request, Lead $lead)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0',
            'method' => 'required|in:cash,bank_transfer,cheque,card,online',
            'paid_on' => 'required|date',
            'due_date' => 'nullable|date',
            'status' => 'required|in:pending,partial,paid,overdue',
            'notes' => 'nullable|string',
        ]);

        $lead->payments()->create($validated);
        return redirect()->back()->with('success', 'Payment added successfully!');
    }

    public function update(Request $request, Lead $lead, Payment $payment)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0',
            'method' => 'required|in:cash,bank_transfer,cheque,card,online',
            'paid_on' => 'required|date',
            'due_date' => 'nullable|date',
            'status' => 'required|in:pending,partial,paid,overdue',
            'notes' => 'nullable|string',
        ]);

        $payment->update($validated);
        return redirect()->back()->with('success', 'Payment updated successfully!');
    }

    public function destroy(Lead $lead, Payment $payment)
    {
        $payment->delete();
        return redirect()->back()->with('success', 'Payment deleted successfully!');
    }
}
