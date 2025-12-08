<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActivityLog; 

class ActivityLogController extends Controller
{
    public function index()
    {
        $logs = ActivityLog::latest()->paginate(10);
        
        return view('activity.index', compact('logs'));
    }

    public function destroy($id)
    {
        $log = ActivityLog::findOrFail($id);
        $log->delete();

        return redirect()->route('activity-logs.index')->with('success', 'Activity log deleted successfully.');
    }
}
