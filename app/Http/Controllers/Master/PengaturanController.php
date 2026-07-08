<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Pengaturan;
use App\Models\AuditLog;
use App\Models\PengaturanSistem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengaturanController extends Controller
{
    public function index()
    {
        $pengaturan = PengaturanSistem::all();
        return view('pages.pengaturan.index', compact('pengaturan'));
    }

    public function update(Request $request, PengaturanSistem $pengaturan)
    {
        // 1. Tentukan aturan validasi dan folder tujuan secara dinamis
        $rules = ['value' => 'nullable'];
        $folderPath = 'lainnya';

        if ($pengaturan->tipe === 'image') {
            $rules['value'] = 'nullable|file|image|mimes:jpeg,png,jpg|max:2048'; // Max 2MB
            $folderPath = 'logos';
        } elseif ($pengaturan->tipe === 'file') {
            $rules['value'] = 'nullable|file|mimes:pdf,doc,docx|max:5120'; // Max 5MB
            $folderPath = 'panduan';
        }

        // Jalankan validasi
        $request->validate($rules);

        DB::transaction(function () use ($request, $pengaturan, $folderPath) {
            $oldValue = $pengaturan->value;
            $newValue = $request->value;

            // 2. Proses upload jika ada file baru (berlaku untuk gambar maupun dokumen)
            if ($request->hasFile('value')) {

                // Hapus file lama dari storage jika ada
                if ($oldValue && \Storage::disk('public')->exists($oldValue)) {
                    \Storage::disk('public')->delete($oldValue);
                }

                // Simpan file baru ke folder yang sesuai (logos atau panduan)
                $newValue = $request->file('value')->store($folderPath, 'public');
            }

            $pengaturan->update(['value' => $newValue]);

            AuditLog::create([
                'user_id' => auth()->id(),
                'module' => 'Pengaturan',
                'action' => 'Update',
                'record_id' => $pengaturan->id,
                'description' => 'Mengubah pengaturan [' . $pengaturan->key . ']',
                'ip_address' => $request->ip()
            ]);
        });

        return redirect()->route('pengaturan.index')->with('success', 'Konfigurasi ' . $pengaturan->key . ' berhasil diperbarui.');
    }
}