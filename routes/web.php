<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Sistem\AuditLogController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Anak\AnakController;
use App\Http\Controllers\Anak\AnakDokumenController;
use App\Http\Controllers\Verifikasi\VerifikasiController;
use App\Http\Controllers\Master\UserController;
use App\Http\Controllers\Master\RolePermissionController;
use App\Http\Controllers\Master\PengaturanController;
use App\Http\Controllers\Laporan\LaporanController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profil User
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ==========================================
    // DATA ANAK YATIM & DOKUMEN (Pendamping & Kesra)
    // ==========================================
    Route::prefix('anak')->name('anak.')->group(function () {
        // Dokumen
        Route::get('/{anak}/dokumen', [AnakDokumenController::class, 'index'])->name('dokumen.index');
        Route::post('/{anak}/dokumen', [AnakDokumenController::class, 'store'])->name('dokumen.store');
        Route::delete('/{anak}/dokumen/{dokumen}', [AnakDokumenController::class, 'destroy'])->name('dokumen.destroy');

        // Submit Verifikasi (Ubah status Draft -> Pending)
        Route::post('/{anak}/submit', [AnakController::class, 'submit'])->name('submit')->middleware('role:pendamping');
    });
    // Resource Anak
    Route::resource('anak', AnakController::class)->except(['destroy']); // Zero Deletion policy

    // ==========================================
    // VERIFIKASI (Khusus Kesra)
    // ==========================================
    Route::middleware(['role:kesra'])->prefix('verifikasi')->name('verifikasi.')->group(function () {
        Route::get('/', [VerifikasiController::class, 'index'])->name('index');
        Route::post('/{anak}/reject', [VerifikasiController::class, 'reject'])->name('processReject');
        Route::post('/{anak}/approve', [VerifikasiController::class, 'approve'])->name('approve');
        Route::patch('/dokumen/{dokumen}/verify', [VerifikasiController::class, 'verifyDokumen'])->name('dokumen.verify');
    });

    // ==========================================
    // LAPORAN (Kesra & Pendamping)
    // ==========================================
    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::post('/export', [LaporanController::class, 'export'])->name('export');
        Route::get('/', [LaporanController::class, 'index'])->name('index');
        Route::get('/anak', [LaporanController::class, 'anak'])->name('anak');
        Route::get('/wilayah', [LaporanController::class, 'wilayah'])->name('wilayah');
        // Route::get('/print', [LaporanController::class, 'print'])->name('print');
    });

    // ==========================================
    // MASTER DATA & PENGATURAN (Khusus Superadmin)
    // ==========================================
    Route::middleware(['role:superadmin'])->group(function () {

        // Manajemen Pengguna
        Route::resource('users', UserController::class)->names([
            'index'     => 'users.index',
            'create'    => 'users.create',
            'store'     => 'users.store',
            'edit'      => 'users.edit',
            'update'    => 'users.update',
            'destroy'   => 'users.destroy',
        ]);


        // Manajemen Roles & Permissions
        Route::resource('roles', RolePermissionController::class)->except(['show']);
        Route::get('roles/{role}/permissions', [RolePermissionController::class, 'permissions'])->name('roles.permissions');
        Route::put('roles/{role}/permissions', [RolePermissionController::class, 'updatePermissions'])->name('roles.permissions.update');

        // Tambahkan di dalam route group superadmin
        Route::resource('wilayah', \App\Http\Controllers\Master\WilayahController::class);

        // Pengaturan Sistem
        Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan.index');
        Route::put('/pengaturan/{pengaturan}', [PengaturanController::class, 'update'])->name('pengaturan.update');

        Route::delete('/kategori-dokumen/{kategoriDokumen}', [\App\Http\Controllers\Master\KategoriDokumenController::class, 'destroy'])->name('kategori-dokumen.destroy');
        // Route::resource('kategori-dokumen', \App\Http\Controllers\Master\KategoriDokumenController::class)->except(['destroy']);
        Route::resource('kategori-dokumen', \App\Http\Controllers\Master\KategoriDokumenController::class)->parameters(['kategori-dokumen' => 'kategoriDokumen']);

        // Audit Logs
        Route::get('/audit', [AuditLogController::class, 'index'])->name('audit.index');
    });
});

require __DIR__ . '/auth.php';