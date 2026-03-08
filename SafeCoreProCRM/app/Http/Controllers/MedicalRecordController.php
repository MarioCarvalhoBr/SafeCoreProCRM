<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class MedicalRecordController extends Controller
{
    public function update(Request $request, Patient $patient)
    {
        $data = $request->validate([
            'blood_type' => 'nullable|string|max:5',
            'allergies' => 'nullable|string|max:1000',
            'family_history' => 'nullable|string|max:1000',
            'past_surgeries' => 'nullable|string|max:1000',
            'current_medications' => 'nullable|string|max:1000',
        ]);

        // SÊNIOR: Cria automaticamente ou atualiza baseado no patient_id
        $patient->medicalRecord()->updateOrCreate(
            ['patient_id' => $patient->id],
            $data
        );

        return back()->with('success', __('messages.updated') ?? 'Prontuário atualizado!');
    }
}
