<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PatientPortalController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\MedicalFileController;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\BackupController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('lang/{lang}', [LanguageController::class, 'switchLang'])->name('lang.switch');

// ==========================================
// TODAS AS ROTAS PROTEGIDAS POR LOGIN (AUTH)
// ==========================================
Route::middleware('auth')->group(function () {

    // 1. PERFIL DO USUÁRIO (Comum a Todos: Equipe e Pacientes)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ==========================================
    // 2. PORTAL DO PACIENTE (Self-Service)
    // Acesso: Apenas Role 'Patient'
    // ==========================================
    Route::middleware(['role:Patient'])->prefix('portal')->name('portal.')->group(function () {
        Route::get('/dashboard', [PatientPortalController::class, 'index'])->name('dashboard');
        Route::get('/book', [PatientPortalController::class, 'createAppointment'])->name('book');
        Route::post('/book', [PatientPortalController::class, 'storeAppointment'])->name('store_appointment');
    });

    // ==========================================
    // 3. ÁREA DA CLÍNICA (Operação Diária)
    // Acesso: Admin, Médicos e Recepcionistas
    // ==========================================
    Route::middleware(['verified', 'role:Admin|Doctor|Receptionist'])->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Configurações da Clínica (Tenant)
        Route::get('/settings', [TenantController::class, 'edit'])->name('tenant.edit');
        Route::put('/settings', [TenantController::class, 'update'])->name('tenant.update');

        // Pacientes, Prontuário e Arquivos
        Route::resource('patients', PatientController::class);
        Route::post('patients/{patient}/generate-access', [PatientController::class, 'generateAccess'])->name('patients.generate_access');
        Route::get('patients/{patient}/profile', [PatientController::class, 'show'])->name('patients.show');
        Route::put('patients/{patient}/medical-record', [MedicalRecordController::class, 'update'])->name('medical_records.update');

        Route::post('patients/{patient}/files', [MedicalFileController::class, 'store'])->name('medical_files.store');
        Route::get('medical-files/{medicalFile}/download', [MedicalFileController::class, 'download'])->name('medical_files.download');
        Route::delete('medical-files/{medicalFile}', [MedicalFileController::class, 'destroy'])->name('medical_files.destroy');

        // Agendamentos e Faturamento
        Route::resource('appointments', AppointmentController::class);
        Route::get('appointments/{appointment}/prescription', [AppointmentController::class, 'prescription'])->name('appointments.prescription');
        Route::get('appointments/{appointment}/certificate', [AppointmentController::class, 'certificate'])->name('appointments.certificate');

        Route::put('appointments/{appointment}/payment', [PaymentController::class, 'update'])->name('payments.update');
        Route::get('appointments/{appointment}/receipt', [PaymentController::class, 'receipt'])->name('payments.receipt');

        // ==========================================
        // 4. ÁREA DE ADMINISTRAÇÃO AVANÇADA
        // Acesso: Apenas Role 'Admin'
        // ==========================================
        Route::middleware(['role:Admin'])->group(function () {

            Route::resource('users', UserController::class);

            // Auditoria
            Route::get('audit-logs', [AuditLogController::class, 'index'])->name('audit.index');

            // Backups
            Route::get('backups', [BackupController::class, 'index'])->name('backups.index');
            Route::post('backups/create', [BackupController::class, 'create'])->name('backups.create');
            Route::get('backups/download/{fileName}', [BackupController::class, 'download'])->name('backups.download');
            Route::delete('backups/delete/{fileName}', [BackupController::class, 'destroy'])->name('backups.destroy');
            Route::post('backups/restore/{fileName}', [BackupController::class, 'restore'])->name('backups.restore');
        });
    });
});

require __DIR__.'/auth.php';
