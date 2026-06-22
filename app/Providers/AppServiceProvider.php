<?php

namespace App\Providers;

use App\Models\Anak;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use App\Models\PengaturanSistem;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Mencegah error saat kita menjalankan "php artisan migrate" di komputer baru
        // (Karena saat migrate awal, tabel pengaturan_sistem belum ada)
        if (Schema::hasTable('pengaturan_sistem')) {

            // Ambil semua data dan ubah menjadi format Array yang mudah dibaca
            // Hasilnya: ['nama_aplikasi' => 'Sistem...', 'nomor_kontak' => '0812...']
            $settings = PengaturanSistem::pluck('value', 'key')->toArray();

            // 1. Trik Sakti: Timpa config('app.name') bawaan Laravel!
            if (isset($settings['nama_aplikasi'])) {
                config(['app.name' => $settings['nama_aplikasi']]);
            }

            // 2. Bagikan variabel $pengaturan_web ke SELURUH file .blade.php
            View::share('pengaturan_web', $settings);
        }

        View::composer('layouts.sidebar', function ($view) {
            $count = Anak::where('status_data', 'Pending')->count();
            $view->with('pending_count', $count);
        });
    }
}