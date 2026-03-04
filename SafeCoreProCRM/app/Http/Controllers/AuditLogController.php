<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class AuditLogController extends Controller
{
    public function index()
    {
        // Traz os logs mais recentes primeiro, carregando quem fez a ação (causer)
        $logs = Activity::with('causer')->latest()->paginate(15);
        return view('audit.index', compact('logs'));
    }
}
