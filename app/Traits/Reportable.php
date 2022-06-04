<?php

namespace App\Traits;

use App\Models\Report;
use Illuminate\Support\Facades\Auth;

trait Reportable
{
    public function reports()
    {
        return $this->morphMany(Report::class, 'reportable', null, null, 'id');
    }

    public function report($reason)
    {
        $report = new Report;
        $report->reportable_id = $this->id;
        $report->reportable_type = get_class($this);
        $report->user_id = Auth::id();
        $report->reason = $reason;
        $report->save();

        return $report;
    }
}
