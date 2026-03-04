<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LanguageController;

use App\Http\Controllers\TenantController;

use App\Http\Controllers\PatientController;

use App\Http\Controllers\AppointmentController;

use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('lang/{lang}', [LanguageController::class, 'switchLang'])->name('lang.switch');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

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

    // ÁREA RESTRITA: Apenas usuários com a Role 'Admin' entram aqui
    Route::middleware(['role:Admin'])->group(function () {
        Route::resource('users', UserController::class);
    });
});

require __DIR__.'/auth.php';
