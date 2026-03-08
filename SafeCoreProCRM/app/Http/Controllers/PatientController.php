<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        // 1. Captura os parâmetros de forma segura (ignora strings vazias)
        $search = $request->input('search');
        $sortBy = $request->filled('sort_by') ? $request->sort_by : 'created_at';
        $sortDir = $request->filled('sort_dir') ? $request->sort_dir : 'desc';

        // 2. Monta a Query Inteligente
        $patients = Patient::when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                             ->orWhere('document_id', 'like', "%{$search}%")
                             ->orWhere('phone', 'like', "%{$search}%")
                             ->orWhere('email', 'like', "%{$search}%");
            })
            ->orderBy($sortBy, $sortDir)
            ->paginate(10)
            ->appends($request->query());

        return view('patients.index', compact('patients'));
    }

    public function create()
    {
        return view('patients.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'document_id' => 'nullable|string|max:50|unique:patients,document_id',
            'birth_date' => 'nullable|date',
        ]);

        Patient::create($request->all());

        // Redireciona com a mensagem de sucesso usando a chave i18n
        return redirect()->route('patients.index')->with('success', __('messages.patient_created_successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Patient $patient)
    {
        // Carrega o paciente junto com o seu prontuário e histórico de consultas
        $patient->load(['medicalRecord', 'appointments.doctor']);
        return view('patients.show', compact('patient'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Patient $patient)
    {
        return view('patients.edit', compact('patient'));
    }

    public function update(Request $request, Patient $patient)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            // Validação única ignorando o próprio paciente
            'document_id' => 'nullable|string|max:50|unique:patients,document_id,' . $patient->id,
            'birth_date' => 'nullable|date',
        ]);

        $patient->update($request->all());

        return redirect()->route('patients.index')->with('success', __('messages.patient_updated_successfully'));
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();

        return redirect()->route('patients.index')->with('success', __('messages.patient_deleted_successfully'));
    }
}
