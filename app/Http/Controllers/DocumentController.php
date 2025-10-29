<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
{
    public function store(Request $request, Lead $lead)
    {
        $validated = $request->validate([
            'type' => 'required|string|max:255',
            'status' => 'nullable|in:not_received,received,verified,rejected',
            'notes' => 'nullable|string',
        ]);

        $lead->documents()->create([
            'uploaded_by' => Auth::id(),
            'type' => $validated['type'],
            'status' => $validated['status'] ?? 'not_received',
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->back()->with('success', 'Document checklist item created successfully!');
    }

    public function update(Request $request, Lead $lead, Document $document)
    {
        $validated = $request->validate([
            'type' => 'required|string|max:255',
            'status' => 'required|in:not_received,received,verified,rejected',
            'notes' => 'nullable|string',
        ]);

        $updateData = [
            'type' => $validated['type'],
            'status' => $validated['status'],
            'notes' => $validated['notes'] ?? null,
        ];

        // Update received_by and received_at when marking as received
        if ($validated['status'] == 'received' && $document->status != 'received') {
            $updateData['received_by'] = Auth::id();
            $updateData['received_at'] = now();
        }

        // Update verified_by and verified_at when marking as verified/rejected
        if (in_array($validated['status'], ['verified', 'rejected']) && !in_array($document->status, ['verified', 'rejected'])) {
            $updateData['verified_by'] = Auth::id();
            $updateData['verified_at'] = now();
        }

        $document->update($updateData);
        return redirect()->back()->with('success', 'Document status updated successfully!');
    }

    public function destroy(Lead $lead, Document $document)
    {
        $document->delete();
        return redirect()->back()->with('success', 'Document checklist item deleted successfully!');
    }
}
