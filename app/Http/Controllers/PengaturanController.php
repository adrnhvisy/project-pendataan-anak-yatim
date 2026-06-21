<?php

namespace App\Http\Controllers;

use App\Models\PengaturanSistem;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class PengaturanController extends Controller
{
    public function index()
    {
        // Mengambil semua pengaturan
        $pengaturan = PengaturanSistem::all();
        return view('pages.superadmin.pengaturan.index', compact('pengaturan'));
    }

    public function update(Request $request)
    {
        // Mengecualikan token CSRF bawaan form
        $data = $request->except(['_token', '_method']);

        foreach ($data as $key => $value) {
            PengaturanSistem::where('key', $key)->update(['value' => $value]);
        }

        // Mencatat aktivitas Superadmin ke CCTV (Audit Log)
        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'Update Pengaturan Sistem',
            'description' => 'Superadmin memperbarui konfigurasi sistem.',
            'ip_address' => $request->ip()
        ]);

        return redirect()->route('superadmin.pengaturan.index')
                         ->with('success', 'Pengaturan berhasil diperbarui!');
    }
}