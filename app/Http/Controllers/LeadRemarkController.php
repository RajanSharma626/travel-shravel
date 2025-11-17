<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\LeadRemark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeadRemarkController extends Controller
{
    public function store(Request $request, Lead $lead)
    {
        $validated = $request->validate([
            'remark' => 'required|string',
            'follow_up_date' => 'nullable|date',
            'visibility' => 'nullable|in:internal,public',
        ]);

        // Set default visibility to public if not provided
        $validated['visibility'] = $validated['visibility'] ?? 'public';

        $remark = $lead->remarks()->create($validated + ['user_id' => Auth::id()]);

        if ($request->expectsJson()) {
            $remark->load('user');
            return response()->json([
                'message' => 'Remark added successfully!',
                'remark' => [
                    'id' => $remark->id,
                    'remark' => $remark->remark,
                    'visibility' => $remark->visibility,
                    'follow_up_date' => $remark->follow_up_date ? $remark->follow_up_date->format('d M, Y') : null,
                    'created_at' => $remark->created_at?->format('d M, Y h:i A'),
                    'user' => [
                        'name' => $remark->user?->name ?? 'Unknown',
                    ],
                ],
            ]);
        }

        return redirect()->back()->with('success', 'Remark added successfully!');
    }

    public function update(Request $request, Lead $lead, LeadRemark $remark)
    {
        $validated = $request->validate([
            'remark' => 'required|string',
            'follow_up_date' => 'nullable|date',
            'visibility' => 'nullable|in:internal,public',
        ]);

        // Set default visibility to public if not provided
        $validated['visibility'] = $validated['visibility'] ?? 'public';

        $remark->update($validated);
        return redirect()->back()->with('success', 'Remark updated successfully!');
    }

    public function destroy(Lead $lead, LeadRemark $remark)
    {
        $remark->delete();
        return redirect()->back()->with('success', 'Remark deleted successfully!');
    }
}
