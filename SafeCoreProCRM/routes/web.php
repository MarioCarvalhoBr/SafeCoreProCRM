<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LanguageController;

use App\Http\Controllers\TenantController;

use App\Http\Controllers\PatientController;


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
});

require __DIR__.'/auth.php';
