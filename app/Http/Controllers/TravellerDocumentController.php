<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\TravellerDocument;
use Illuminate\Http\Request;

class TravellerDocumentController extends Controller
{
    public function store(Request $request, Lead $lead)
    {
        $validated = $request->validate([
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'document_type' => 'required|in:passport,visa,aadhar_card,pan_card,voter_id,driving_license,govt_id,school_id,birth_certificate,marriage_certificate,photos,insurance,other_document',
            'status' => 'nullable|string|max:50',
            'document_details' => 'nullable|string|max:255',
            'nationality' => 'nullable|string|max:255',
            'dob' => 'nullable|date',
            'place_of_issue' => 'nullable|string|max:255',
            'date_of_expiry' => 'nullable|date',
            'remark' => 'nullable|string|max:1000',
        ]);

        $docType = $validated['document_type'];

        TravellerDocument::updateOrCreate(
            [
                'lead_id' => $lead->id,
                'doc_type' => $docType,
            ],
            [
                'first_name' => $validated['first_name'] ?? null,
                'last_name' => $validated['last_name'] ?? null,
                'doc_type' => $docType,
                'status' => $validated['status'] ?? null,
                'doc_no' => $validated['document_details'] ?? null,
                'nationality' => $validated['nationality'] ?? null,
                'dob' => $validated['dob'] ?? null,
                'place_of_issue' => $validated['place_of_issue'] ?? null,
                'date_of_expiry' => $validated['date_of_expiry'] ?? null,
                'remark' => $validated['remark'] ?? null,
            ]
        );

        return redirect()->back()->with('success', 'Traveller document details updated successfully!');
    }

    public function destroy(Request $request, Lead $lead, TravellerDocument $travellerDocument)
    {
        if ($travellerDocument->lead_id !== $lead->id) {
            abort(404);
        }

        $travellerDocument->delete();

        return redirect()->back()->with('success', 'Traveller document deleted successfully!');
    }
}


