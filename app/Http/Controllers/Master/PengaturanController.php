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
        // Validasi fleksibel: bisa file gambar atau teks biasa
        $request->validate([
            'value' => 'nullable',
            'value.*' => 'image|mimes:jpeg,png,jpg|max:2048', // Jika upload gambar
        ]);

        DB::transaction(function () use ($request, $pengaturan) {
            $oldValue = $pengaturan->value;
            $newValue = $request->value;

            // Cek jika yang diupload adalah file gambar
            if ($request->hasFile('value')) {
                // Hapus file lama jika ada (opsional)
                if ($oldValue && \Storage::disk('public')->exists($oldValue)) {
                    \Storage::disk('public')->delete($oldValue);
                }
                // Simpan file baru ke folder 'logos' di storage
                $newValue = $request->file('value')->store('logos', 'public');
            }

            $pengaturan->update(['value' => $newValue]);

            AuditLog::create([
                'user_id' => auth()->id(),
                'module' => 'Pengaturan',
                'action' => 'Update',
                'record_id' => $pengaturan->id,
                'description' => 'Mengubah pengaturan [' . $pengaturan->key . '] dari "' . $oldValue . '" menjadi "' . $request->value . '"',
                'ip_address' => $request->ip()
            ]);
        });

        return redirect()->route('pengaturan.index')->with('success', 'Konfigurasi ' . $pengaturan->key . ' berhasil diperbarui.');
    }
}