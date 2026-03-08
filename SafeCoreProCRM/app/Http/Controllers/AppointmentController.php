<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Tenant;

class AppointmentController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $search = $request->input('search');
        $sortBy = $request->filled('sort_by') ? $request->sort_by : 'appointment_date';
        $sortDir = $request->filled('sort_dir') ? $request->sort_dir : 'desc';

        $appointments = Appointment::with(['patient', 'doctor', 'payment'])
            ->when($search, function($query) use ($search) {
                $query->whereHas('patient', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })->orWhereHas('doctor', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })->orWhere('status', 'like', "%{$search}%");
            })
            ->orderBy($sortBy, $sortDir)
            ->paginate(10)
            ->appends($request->query());

        return view('appointments.index', compact('appointments'));
    }

    public function create()
    {
        // Precisamos enviar a lista de pacientes e médicos para preencher os <select> na View
        $patients = Patient::orderBy('name')->get();

        // Puxamos apenas os utilizadores que têm a Role de 'Doctor'
        $doctors = User::role('Doctor')->orderBy('name')->get();

        return view('appointments.create', compact('patients', 'doctors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'user_id' => 'required|exists:users,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'notes' => 'nullable|string',
        ]);

        // Lógica Anti-Overbooking (Verifica se o médico já tem algo para este dia e hora exata)
        $conflict = Appointment::where('user_id', $request->user_id)
            ->where('appointment_date', $request->appointment_date)
            ->where('appointment_time', $request->appointment_time)
            ->exists();

        if ($conflict) {
            // Volta para trás com o erro i18n e não apaga o que o utilizador já tinha preenchido
            return back()->withInput()->withErrors(['appointment_time' => __('messages.time_slot_taken')]);
        }

        Appointment::create($request->all());

        return redirect()->route('appointments.index')->with('success', __('messages.appointment_created_successfully'));
    }

    public function edit(Appointment $appointment)
    {
        $patients = Patient::orderBy('name')->get();
        $doctors = User::role('Doctor')->orderBy('name')->get();

        return view('appointments.edit', compact('appointment', 'patients', 'doctors'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'user_id' => 'required|exists:users,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'status' => 'required|in:scheduled,completed,canceled', // Validação estrita de Status
            'notes' => 'nullable|string',
            'certificate_days' => 'nullable|integer|min:0|max:90',
        ]);

        // Anti-Overbooking SÊNIOR: Verifica conflitos, MAS ignora o ID do agendamento atual
        $conflict = Appointment::where('user_id', $request->user_id)
            ->where('appointment_date', $request->appointment_date)
            ->where('appointment_time', $request->appointment_time)
            ->where('id', '!=', $appointment->id) // <-- A MÁGICA ESTÁ AQUI
            ->exists();

        if ($conflict) {
            return back()->withInput()->withErrors(['appointment_time' => __('messages.time_slot_taken')]);
        }

        $appointment->update($request->all());

        return redirect()->route('appointments.index')->with('success', __('messages.appointment_updated_successfully'));
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return redirect()->route('appointments.index')->with('success', __('messages.appointment_deleted_successfully'));
    }

    public function prescription(Appointment $appointment)
    {
        // 1. Busca as configurações da clínica para montar o cabeçalho (Logo, Nome, etc)
        $tenant = Tenant::first() ?? new Tenant();

        // 2. Opcional de Segurança: Garantir que as relações estão carregadas
        $appointment->load(['patient', 'doctor']);

        // 3. Monta o PDF a partir de uma View Blade
        $pdf = Pdf::loadView('appointments.pdf', compact('appointment', 'tenant'));

        // 4. Retorna em modo 'stream' (Abre no navegador). Se quisesse forçar download, seria ->download(...)
        return $pdf->stream('receita_' . $appointment->patient->name . '.pdf');
    }
    public function certificate(Appointment $appointment)
    {
        $tenant = Tenant::first() ?? new Tenant();
        $appointment->load(['patient', 'doctor']);

        $pdf = Pdf::loadView('appointments.certificate_pdf', compact('appointment', 'tenant'));
        return $pdf->stream('atestado_' . $appointment->patient->name . '.pdf');
    }
}
