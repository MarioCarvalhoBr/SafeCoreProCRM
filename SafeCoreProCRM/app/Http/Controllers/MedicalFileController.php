<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\MedicalFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MedicalFileController extends Controller
{
    public function store(Request $request, Patient $patient)
    {
        $request->validate([
            // Limite de 5MB (5120 KB), apenas PDF ou Imagens
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');

            // Salva na pasta private: storage/app/private/patients/{id}/
            $path = $file->store("patients/{$patient->id}", 'local');

            $patient->medicalFiles()->create([
                'original_name' => $file->getClientOriginalName(),
                'file_path' => $path,
                'mime_type' => $file->getMimeType(),
            ]);

            return back()->with('success', __('messages.file_uploaded'));
        }

        return back()->withErrors(['error' => 'Nenhum arquivo recebido.']);
    }

    public function download(MedicalFile $medicalFile)
    {
        if (Storage::disk('local')->exists($medicalFile->file_path)) {
            return Storage::disk('local')->download($medicalFile->file_path, $medicalFile->original_name);
        }
        return abort(404, "Arquivo não encontrado no servidor.");
    }

    public function destroy(MedicalFile $medicalFile)
    {
        if (Storage::disk('local')->exists($medicalFile->file_path)) {
            Storage::disk('local')->delete($medicalFile->file_path);
        }

        $medicalFile->delete();

        return back()->with('success', __('messages.file_deleted'));
    }
}
