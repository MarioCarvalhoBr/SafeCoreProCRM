<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LanguageController;

use App\Http\Controllers\TenantController;

use App\Http\Controllers\PatientController;

use App\Http\Controllers\AppointmentController;

use App\Http\Controllers\UserController;

use App\Http\Controllers\DashboardController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('lang/{lang}', [LanguageController::class, 'switchLang'])->name('lang.switch');



Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

     // Rotas da Clínica (Tenant)
    Route::get('/settings', [TenantController::class, 'edit'])->name('tenant.edit');
    Route::put('/settings', [TenantController::class, 'update'])->name('tenant.update');

    // Rota de Pacientes
    Route::resource('patients', PatientController::class);

    // Rota de Agendamentos
    Route::resource('appointments', AppointmentController::class);

    // Rota para Gerar o PDF da Receita
    Route::get('appointments/{appointment}/prescription', [AppointmentController::class, 'prescription'])->name('appointments.prescription');
    Route::get('appointments/{appointment}/certificate', [AppointmentController::class, 'certificate'])->name('appointments.certificate');

    // Rotas do Prontuário / Perfil do Paciente
    Route::get('patients/{patient}/profile', [\App\Http\Controllers\PatientController::class, 'show'])->name('patients.show');
    Route::put('patients/{patient}/medical-record', [\App\Http\Controllers\MedicalRecordController::class, 'update'])->name('medical_records.update');

    // Rotas de Arquivos Médicos
    Route::post('patients/{patient}/files', [\App\Http\Controllers\MedicalFileController::class, 'store'])->name('medical_files.store');
    Route::get('medical-files/{medicalFile}/download', [\App\Http\Controllers\MedicalFileController::class, 'download'])->name('medical_files.download');
    Route::delete('medical-files/{medicalFile}', [\App\Http\Controllers\MedicalFileController::class, 'destroy'])->name('medical_files.destroy');

    // ÁREA RESTRITA: Apenas usuários com a Role 'Admin' entram aqui
    Route::middleware(['role:Admin'])->group(function () {
        Route::resource('users', UserController::class);

        // Nova rota de Auditoria:
        Route::get('audit-logs', [\App\Http\Controllers\AuditLogController::class, 'index'])->name('audit.index');

        // Módulo de Backups
        Route::get('backups', [\App\Http\Controllers\BackupController::class, 'index'])->name('backups.index');
        Route::post('backups/create', [\App\Http\Controllers\BackupController::class, 'create'])->name('backups.create');
        Route::get('backups/download/{fileName}', [\App\Http\Controllers\BackupController::class, 'download'])->name('backups.download');
        Route::delete('backups/delete/{fileName}', [\App\Http\Controllers\BackupController::class, 'destroy'])->name('backups.destroy');
        Route::post('backups/restore/{fileName}', [\App\Http\Controllers\BackupController::class, 'restore'])->name('backups.restore');
    });
});

require __DIR__.'/auth.php';
