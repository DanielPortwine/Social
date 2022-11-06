<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function view($type, $id)
    {
        $type = 'App\Models\\'.ucfirst($type);
        $reportable = $type::findOrFail($id);

        return response()->json($reportable->reports()->get());
    }

    public function store(Request $request)
    {
        $type = 'App\Models\\'.$request->post('reportable_type');
        $reportable = $type::findOrFail($request->post('reportable_id'));
        $report = $reportable->report($request->post('reason'));

        return response()->json($report, 201);
    }

    public function delete(Report $report)
    {
        $report->delete();

        return response()->json(null, 204);
    }
}
