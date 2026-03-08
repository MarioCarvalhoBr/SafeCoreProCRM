<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientPortalController extends Controller
{
    // Dashboard do Paciente
    public function index()
    {
        $user = Auth::user();

        // Garante que o usuário tem um perfil de paciente
        $patient = $user->patientProfile;

        if (!$patient) {
            abort(403, 'Acesso Negado: Perfil de paciente não encontrado.');
        }

        // Carrega apenas as consultas DESTE paciente
        $appointments = Appointment::with(['doctor', 'payment'])
            ->where('patient_id', $patient->id)
            ->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc')
            ->get();

        return view('portal.dashboard', compact('patient', 'appointments'));
    }

    // Tela para Marcar Nova Consulta (Self-Service)
    public function createAppointment()
    {
        // Aqui buscaremos apenas os usuários que têm a Role "Doctor"
        $doctors = User::role('Doctor')->get();

        return view('portal.book', compact('doctors'));
    }

    public function storeAppointment(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:users,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required',
            'notes' => 'nullable|string|max:1000',
        ]);

        $patient = Auth::user()->patientProfile;

        Appointment::create([
            'patient_id' => $patient->id,
            'doctor_id' => $request->doctor_id,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'status' => 'scheduled',
            'notes' => $request->notes,
        ]);

        return redirect()->route('portal.dashboard')->with('success', __('messages.appointment_requested'));
    }
}
