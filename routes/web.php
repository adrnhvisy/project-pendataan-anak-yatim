<?php

use Illuminate\Support\Facades\Route;

// Import Controllers
use App\Http\Controllers\{DashboardController, ProfileController};
use App\Http\Controllers\Anak\{AnakController, AnakDokumenController};
use App\Http\Controllers\Verifikasi\VerifikasiController;
use App\Http\Controllers\Laporan\LaporanController;
use App\Http\Controllers\Sistem\AuditLogController;
use App\Http\Controllers\Master\{UserController, WilayahController, RolePermissionController, PengaturanController};

Route::get('/', function () { return view('welcome'); });

require __DIR__.'/auth.php';

Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Anak & Dokumen
    Route::prefix('anak')->name('anak.')->group(function () {
        Route::get('/', [AnakController::class, 'index'])->name('index');
        Route::get('/create', [AnakController::class, 'create'])->name('create');
        Route::post('/', [AnakController::class, 'store'])->name('store');
        Route::get('/{anak}', [AnakController::class, 'show'])->name('show');
        Route::get('/{anak}/edit', [AnakController::class, 'edit'])->name('edit');
        Route::put('/{anak}', [AnakController::class, 'update'])->name('update');
        Route::delete('/{anak}', [AnakController::class, 'destroy'])->name('destroy');
        
        // Dokumen (Nested)
        Route::get('/{anak}/dokumen', [AnakDokumenController::class, 'index'])->name('dokumen.index');
        Route::get('/{anak}/dokumen/upload', [AnakDokumenController::class, 'create'])->name('dokumen.create');
        Route::post('/{anak}/dokumen', [AnakDokumenController::class, 'store'])->name('dokumen.store');
        Route::delete('/dokumen/{dokumen}', [AnakDokumenController::class, 'destroy'])->name('dokumen.destroy');
    });

    // Verifikasi (Role: Admin, Kesra, Kecamatan)
    Route::middleware('role:superadmin|kesra|kecamatan')->prefix('verifikasi')->name('verifikasi.')->group(function () {
        Route::get('/', [VerifikasiController::class, 'index'])->name('index');
        Route::get('/{anak}', [VerifikasiController::class, 'show'])->name('show');
        Route::post('/{anak}/approve', [VerifikasiController::class, 'approve'])->name('approve');
        Route::post('/{anak}/reject', [VerifikasiController::class, 'reject'])->name('reject');
    });

    // Laporan
    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/anak', [LaporanController::class, 'anak'])->name('anak');
        Route::get('/wilayah', [LaporanController::class, 'wilayah'])->name('wilayah');
        Route::get('/bantuan', [LaporanController::class, 'bantuan'])->name('bantuan');
    });

    // Master Data (Role: Superadmin)
    Route::middleware('role:superadmin')->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('wilayah', WilayahController::class);
        
        // Roles & Permissions
        Route::get('/roles', [RolePermissionController::class, 'index'])->name('roles.index');
        Route::get('/roles/create', [RolePermissionController::class, 'create'])->name('roles.create');
        Route::post('/roles', [RolePermissionController::class, 'store'])->name('roles.store');
        Route::get('/roles/{role}/edit', [RolePermissionController::class, 'edit'])->name('roles.edit');
        Route::put('/roles/{role}', [RolePermissionController::class, 'update'])->name('roles.update');
        Route::delete('/roles/{role}', [RolePermissionController::class, 'destroy'])->name('roles.destroy');
        
        // Pengaturan
        Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan.index');
        Route::put('/pengaturan', [PengaturanController::class, 'update'])->name('pengaturan.update');
    });

    // Sistem (Role: Superadmin)
    Route::middleware('role:superadmin')->prefix('sistem')->name('sistem.')->group(function () {
        Route::get('/audit-log', [AuditLogController::class, 'index'])->name('audit.index');
    });
});
