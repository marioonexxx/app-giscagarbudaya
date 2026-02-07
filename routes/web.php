<?php

use App\Http\Controllers\InputCagarBudayaController;
use App\Http\Controllers\PetaSebaranController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicDataController;
use App\Http\Controllers\UserEvaluatorController;
use App\Http\Controllers\UserKabupatenController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\UserManagementEvaluatorController;
use App\Http\Controllers\UserSuperAdminController;
use App\Http\Controllers\VerifikasiCagarBudayaController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicDataController::class, 'index'])->name('welcome');
Route::get('/statistik', [PublicDataController::class, 'statistik'])->name('publik.statistik');
Route::get('/api/statistik-data', [PublicDataController::class, 'getStatistik'])->name('api.statistik');
Route::get('/api/cagar-detail/{id}', [PublicDataController::class, 'getDetail']);
Route::get('/peta-sebaran', [PublicDataController::class, 'peta'])->name('publik.peta');
Route::get('/api/statistik', [PublicDataController::class, 'apiStatistik'])->name('api.statistik');

// Semua Route di bawah ini WAJIB Login
Route::middleware(['auth', 'verified'])->group(function () {

    // 1. Redirect Dashboard Utama (Opsional: Jika user ketik /dashboard, lempar ke dashboard role-nya)
    Route::get('/dashboard', function () {
        $peran = auth()->user()->peran;
        return redirect()->route($peran . '.dashboard');
    });

    // --- Kelompok Admin Kabupaten ---
    Route::middleware(['auth', 'peran:admin_kabupaten'])
        ->prefix('admin_kabupaten')
        ->name('admin_kabupaten.')
        ->group(function () {
            Route::get('/dashboard', [UserKabupatenController::class, 'index'])->name('dashboard');
            Route::resource('cagar-budaya', InputCagarBudayaController::class);
            Route::resource('peta-sebaran', PetaSebaranController::class);
        });

    // --- Kelompok Evaluator ---
    Route::middleware(['auth', 'peran:evaluator'])
        ->prefix('evaluator')
        ->name('evaluator.')
        ->group(function () {
            Route::get('/dashboard', [UserEvaluatorController::class, 'index'])->name('dashboard');
            Route::get('/verifikasi/{id}', [VerifikasiCagarBudayaController::class, 'show'])->name('verifikasi.show');
            Route::post('/verifikasi/{id}/setujui', [VerifikasiCagarBudayaController::class, 'setujui'])->name('verifikasi.setujui');
            Route::post('/verifikasi/{id}/tolak', [VerifikasiCagarBudayaController::class, 'tolak'])->name('verifikasi.tolak');
            Route::get('/verifikasi-riwayat', [VerifikasiCagarBudayaController::class, 'riwayatEvaluasi'])->name('verifikasi.riwayat');
        });

    // --- Kelompok Super Admin ---
    Route::middleware(['auth', 'peran:super_admin'])
        ->prefix('super_admin')
        ->name('super_admin.')
        ->group(function () {
            Route::get('/dashboard', [UserSuperAdminController::class, 'index'])->name('dashboard');
            Route::resource('user-management', UserManagementController::class);
            Route::resource('management-userevaluator', UserManagementEvaluatorController::class);
        });

    // 5. Profile (Umum untuk semua role)
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });
});

require __DIR__ . '/auth.php';
