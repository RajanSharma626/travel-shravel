<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Delivery;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DeliveryController extends Controller
{
    public function store(Request $request, Lead $lead)
    {
        $validated = $request->validate([
            'assigned_to' => 'required|exists:users,id',
            'expected_delivery_date' => 'nullable|date',
            'delivery_notes' => 'nullable|string',
        ]);

        $lead->delivery()->create($validated + ['status' => 'pending']);
        return redirect()->back()->with('success', 'Delivery assigned successfully!');
    }

    public function update(Request $request, Lead $lead, Delivery $delivery)
    {
        $validated = $request->validate([
            'assigned_to' => 'required|exists:users,id',
            'status' => 'required|in:pending,in_process,delivered,failed',
            'courier_id' => 'nullable|string|max:255',
            'tracking_info' => 'nullable|string',
            'expected_delivery_date' => 'nullable|date',
            'actual_delivery_date' => 'nullable|date',
            'delivery_notes' => 'nullable|string',
        ]);

        $delivery->update($validated);
        return redirect()->back()->with('success', 'Delivery updated successfully!');
    }

    public function upload(Request $request, Lead $lead, Delivery $delivery)
    {
        $validated = $request->validate([
            'attachments' => 'required|array',
            'attachments.*' => 'file|max:10240', // 10MB max
        ]);

        $paths = [];
        foreach ($request->file('attachments') as $file) {
            $path = $file->store('deliveries/' . $lead->id, 'public');
            $paths[] = $path;
        }

        $existingAttachments = $delivery->attachments ?? [];
        $delivery->update(['attachments' => array_merge($existingAttachments, $paths)]);

        return redirect()->back()->with('success', 'Attachments uploaded successfully!');
    }
}
