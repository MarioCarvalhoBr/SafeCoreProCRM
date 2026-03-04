<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Resumos Numéricos (Cards)
        $totalPatients = Patient::count();
        $appointmentsToday = Appointment::whereDate('appointment_date', Carbon::today())->count();
        $appointmentsMonth = Appointment::whereMonth('appointment_date', Carbon::now()->month)
                                        ->whereYear('appointment_date', Carbon::now()->year)
                                        ->count();

        // 2. Gráfico de Rosca: Status
        $statusCounts = Appointment::selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $chartData = [
            'scheduled' => $statusCounts['scheduled'] ?? 0,
            'completed' => $statusCounts['completed'] ?? 0,
            'canceled'  => $statusCounts['canceled'] ?? 0,
        ];

        // 3. NOVO: Agendamentos de HOJE agrupados por Médico (Join otimizado)
        $todayByDoctor = Appointment::selectRaw('users.name as doctor_name, count(appointments.id) as total')
            ->join('users', 'appointments.user_id', '=', 'users.id')
            ->whereDate('appointment_date', Carbon::today())
            ->groupBy('users.name')
            ->get();

        $labelsToday = $todayByDoctor->pluck('doctor_name')->toArray();
        $dataToday = $todayByDoctor->pluck('total')->toArray();

        // 4. NOVO: Agendamentos do MÊS agrupados por Médico
        $monthByDoctor = Appointment::selectRaw('users.name as doctor_name, count(appointments.id) as total')
            ->join('users', 'appointments.user_id', '=', 'users.id')
            ->whereMonth('appointment_date', Carbon::now()->month)
            ->whereYear('appointment_date', Carbon::now()->year)
            ->groupBy('users.name')
            ->get();

        $labelsMonth = $monthByDoctor->pluck('doctor_name')->toArray();
        $dataMonth = $monthByDoctor->pluck('total')->toArray();

        return view('dashboard', compact(
            'totalPatients',
            'appointmentsToday',
            'appointmentsMonth',
            'chartData',
            'labelsToday',
            'dataToday',
            'labelsMonth',
            'dataMonth'
        ));
    }
}
