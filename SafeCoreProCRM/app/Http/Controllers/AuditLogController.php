<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class AuditLogController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $search = $request->input('search');
        $sortBy = $request->filled('sort_by') ? $request->sort_by : 'created_at';
        $sortDir = $request->filled('sort_dir') ? $request->sort_dir : 'desc';

        $logs = \Spatie\Activitylog\Models\Activity::with('causer')
            ->when($search, function($query) use ($search) {
                $query->where('event', 'like', "%{$search}%")
                      ->orWhere('subject_type', 'like', "%{$search}%")
                      ->orWhereHas('causer', function($q) use ($search) {
                          $q->where('name', 'like', "%{$search}%");
                      });
            })
            ->orderBy($sortBy, $sortDir)
            ->paginate(15)
            ->appends($request->query());

        return view('audit.index', compact('logs'));
    }
}
