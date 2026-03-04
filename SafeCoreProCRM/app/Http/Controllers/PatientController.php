<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index()
    {
        // Ordena por nome e pagina de 10 em 10
        $patients = Patient::orderBy('name')->paginate(10);
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
    public function show(string $id)
    {
        //
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
