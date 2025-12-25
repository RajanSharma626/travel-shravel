<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;

class CustomerCareController extends LeadController
{
    /**
     * Override store to redirect back to customer care index
     */
    public function store(Request $request)
    {
        $response = parent::store($request);
        
        // If it's a redirect, change the target to customer care index
        if ($response instanceof \Illuminate\Http\RedirectResponse) {
            return redirect()->route('customer-care.leads.index')->with('success', 'Lead created successfully in Customer Care!');
        }
        
        return $response;
    }

    /**
     * Override update to redirect back to customer care index
     */
    public function update(Request $request, Lead $lead)
    {
        $response = parent::update($request, $lead);
        
        // If it's a redirect, change the target to customer care index
        if ($response instanceof \Illuminate\Http\RedirectResponse) {
            return redirect()->route('customer-care.leads.index')->with('success', 'Lead updated successfully in Customer Care!');
        }
        
        return $response;
    }

    /**
     * Override destroy to redirect back to customer care index
     */
    public function destroy(Lead $lead)
    {
        parent::destroy($lead);
        return redirect()->route('customer-care.leads.index')->with('success', 'Lead deleted successfully!');
    }
}
