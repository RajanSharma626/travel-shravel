<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\Lead;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeadController extends Controller
{
    public function index()
    {
        $leads = Lead::with(['service', 'destination', 'assignedUser'])->latest()->paginate(20);
        return view('leads.index', compact('leads'));
    }


    public function create()
    {
        $services = Service::all();
        $destinations = Destination::all();
        $users = User::all();
        return view('leads.create', compact('services', 'destinations', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'phone' => 'required',
            'email' => 'nullable|email',
            'service_id' => 'nullable|exists:services,id',
            'destination_id' => 'nullable|exists:destinations,id',
        ]);
        Lead::create($validated + ['assigned_user_id' => Auth::id()]);
        return redirect()->route('leads.index')->with('success', 'Lead created successfully!');
    }

    public function show(Lead $lead)
    {
        return view('leads.show', compact('lead'));
    }
}
