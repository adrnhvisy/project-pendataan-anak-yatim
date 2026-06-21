<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

// Kustom Controller yang sudah kita buat
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AnakController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\AuditLogController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. Halaman Awal (Bawaan Laravel, kita ubah agar otomatis ke halaman login)
Route::get('/', function () {
    return redirect()->route('login');
});

// 2. RUTE YANG WAJIB LOGIN (Middleware 'auth')
Route::middleware(['auth'])->group(function () {
    
    // Rute Dashboard Utama (Bisa diakses semua role yang sudah login)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ==========================================
    // 3. ZONA SUPERADMIN (Hanya boleh diakses role 'superadmin')
    // ==========================================
    Route::middleware(['role:superadmin'])->prefix('superadmin')->name('superadmin.')->group(function () {
        
        // CRUD Manajemen User (URL: /superadmin/users)
        Route::resource('users', UserController::class);

        // Pengaturan Sistem (URL: /superadmin/pengaturan)
        Route::get('pengaturan', [PengaturanController::class, 'index'])->name('pengaturan.index');
        Route::post('pengaturan', [PengaturanController::class, 'update'])->name('pengaturan.update');

        // Audit Log CCTV (URL: /superadmin/audit)
        Route::get('audit', [AuditLogController::class, 'index'])->name('audit.index');
    });

    // ==========================================
    // 4. ZONA MANAJEMEN ANAK YATIM 
    // (Bisa diakses Pendamping, Kecamatan, Kesra, Superadmin)
    // ==========================================
    Route::middleware(['role:superadmin|kesra|kecamatan|pendamping'])->group(function () {
        
        // Rute Ajaib Resource untuk Anak (Membuat 7 rute CRUD sekaligus)
        Route::resource('anak', AnakController::class);

        // Rute khusus untuk halaman upload dokumen anak
        Route::get('anak/{anak}/dokumen', [AnakController::class, 'dokumen'])->name('anak.dokumen');
    });

    // ==========================================
    // 5. ZONA PROFILE (Bawaan Breeze)
    // ==========================================
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Memanggil rute login/register bawaan Breeze
require __DIR__.'/auth.php';