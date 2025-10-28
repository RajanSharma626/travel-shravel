<?php

namespace App\Observers;

use App\Models\Lead;
use Illuminate\Support\Facades\DB;

class LeadObserver
{
    /**
     * Handle the Lead "created" event.
     */
    public function creating(Lead $lead)
    {
        $max = DB::table('leads')->max('tsq_number');
        $next = $max ? $max + 1 : 1600;
        $lead->tsq_number = $next;
        $lead->tsq = 'TSQ' . $next;
    }
}
