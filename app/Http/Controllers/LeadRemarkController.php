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
            'visibility' => 'required|in:internal,public',
        ]);

        $lead->remarks()->create($validated + ['user_id' => Auth::id()]);
        return redirect()->back()->with('success', 'Remark added successfully!');
    }

    public function update(Request $request, Lead $lead, LeadRemark $remark)
    {
        $validated = $request->validate([
            'remark' => 'required|string',
            'follow_up_date' => 'nullable|date',
            'visibility' => 'required|in:internal,public',
        ]);

        $remark->update($validated);
        return redirect()->back()->with('success', 'Remark updated successfully!');
    }

    public function destroy(Lead $lead, LeadRemark $remark)
    {
        $remark->delete();
        return redirect()->back()->with('success', 'Remark deleted successfully!');
    }
}
