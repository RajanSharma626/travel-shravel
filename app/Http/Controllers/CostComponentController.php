<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\CostComponent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CostComponentController extends Controller
{
    public function store(Request $request, Lead $lead)
    {
        $validated = $request->validate([
            'type' => 'required|in:hotel,transport,visa,insurance,meal,guide,other',
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
        ]);

        $lead->costComponents()->create($validated + ['entered_by' => Auth::id()]);
        return redirect()->back()->with('success', 'Cost component added successfully!');
    }

    public function update(Request $request, Lead $lead, CostComponent $costComponent)
    {
        $validated = $request->validate([
            'type' => 'required|in:hotel,transport,visa,insurance,meal,guide,other',
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
        ]);

        $costComponent->update($validated);
        return redirect()->back()->with('success', 'Cost component updated successfully!');
    }

    public function destroy(Lead $lead, CostComponent $costComponent)
    {
        $costComponent->delete();
        return redirect()->back()->with('success', 'Cost component deleted successfully!');
    }
}
