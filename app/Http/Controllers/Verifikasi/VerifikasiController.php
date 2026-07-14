<?php

namespace App\Http\Controllers\Verifikasi;

use App\Http\Controllers\Controller;
use App\Models\Anak;
use App\Models\DokumenAnak;
use App\Models\StatusHistori;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VerifikasiController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $query = Anak::with(['alamatDomisili.kelurahan.kecamatan'])->whereIn('status_data', ['Pending', 'Ditolak'])->latest();

        if ($user->hasRole('kesra')) {
            $query->whereHas('alamatDomisili.kelurahan.kecamatan', function ($q) use ($user) {
                $q->where('kabupaten_id', $user->kabupaten_id);
            });
        }

        // PERBAIKAN: Tambahkan withQueryString()
        $anak = $query->paginate(10)->withQueryString();
        return view('pages.verifikasi.index', compact('anak'));
    }

    public function reject(Request $request, Anak $anak)
    {
        // State Protection: Mencegah bypass status via API/Postman
        if ($anak->status_data !== 'Pending') {
            abort(403, 'Hanya data dengan status Pending yang dapat ditolak/dikembalikan.');
        }

        $request->validate([
            'keterangan' => 'required|string|min:10'
        ]);

        DB::transaction(function () use ($request, $anak) {
            $statusLama = $anak->status_data;

            // PERBAIKAN: Update status_data DAN catatan di table anak
            $anak->update([
                'status_data' => 'Ditolak',
                'catatan' => $request->keterangan // Mengisi catatan anak agar terlihat di form edit pendamping
            ]);

            // Tetap simpan di histori untuk rekam jejak
            StatusHistori::create([
                'anak_id' => $anak->id,
                'status_lama' => $statusLama,
                'status_baru' => 'Ditolak',
                'keterangan' => $request->keterangan,
                'created_by' => auth()->id(),
            ]);

            AuditLog::create([
                'user_id' => auth()->id(),
                'module' => 'Verifikasi',
                'action' => 'Reject',
                'record_id' => $anak->id,
                'description' => 'Menolak data anak NIK: ' . $anak->nik,
                'ip_address' => $request->ip()
            ]);
        });

        return redirect()->route('verifikasi.index')->with('success', 'Data anak telah ditolak/dikembalikan untuk revisi.');
    }

    public function approve(Anak $anak)
    {
        if ($anak->status_data !== 'Pending') {
            abort(403, 'Data ini tidak sedang dalam antrian verifikasi.');
        }

        $allDokumenAnak = $anak->dokumen()->get();

        // Status verifikasi yang dianggap belum selesai
        $dokumenBermasalah = $allDokumenAnak->whereIn('status_verifikasi', ['Pending', 'Tidak Valid'])->count();

        if ($dokumenBermasalah > 0) {
            return back()->with('error', 'Pastikan semua dokumen yang diunggah telah diverifikasi dan berstatus Valid.');
        }

        $kategoriWajibIds = \App\Models\KategoriDokumen::where('is_wajib', true)->pluck('id');
        $dokumenValidAnakIds = $allDokumenAnak->where('status_verifikasi', 'Valid')->pluck('kategori_dok_id');
        $dokumenKurang = $kategoriWajibIds->diff($dokumenValidAnakIds)->count();

        if ($dokumenKurang > 0) {
            return back()->with('error', 'Ada Dokumen Wajib yang belum diunggah atau belum berstatus Valid. Pendaftaran tidak dapat disetujui.');
        }

        DB::transaction(function () use ($anak) {
            $statusLama = $anak->status_data;

            $anak->update(['status_data' => 'Disetujui']);

            StatusHistori::create([
                'anak_id' => $anak->id,
                'status_lama' => $statusLama,
                'status_baru' => 'Disetujui',
                'keterangan' => 'Data telah diverifikasi dan disetujui secara resmi.',
                'created_by' => auth()->id(),
            ]);

            AuditLog::create([
                'user_id' => auth()->id(),
                'module' => 'Verifikasi',
                'action' => 'Approve',
                'record_id' => $anak->id,
                'description' => 'Menyetujui data anak NIK: ' . $anak->nik,
                'ip_address' => request()->ip()
            ]);
        });

        return redirect()->route('verifikasi.index')->with('success', 'Data anak resmi disetujui.');
    }

    public function verifyDokumen(Request $request, DokumenAnak $dokumen)
    {
        $request->validate([
            'status_verifikasi' => 'required|in:Valid,Tidak Valid',
            'catatan' => 'nullable|string'
        ]);

        $dokumen->update([
            'status_verifikasi' => $request->status_verifikasi,
            'catatan' => $request->catatan,
            'verified_by' => auth()->id(),
            'verified_at' => now(),
        ]);

        AuditLog::create([
            'user_id' => auth()->id(),
            'module' => 'Dokumen',
            'action' => 'Verify',
            'record_id' => $dokumen->id,
            'description' => 'Verifikasi dokumen ID: ' . $dokumen->id . ' menjadi ' . $request->status_verifikasi,
            'ip_address' => $request->ip()
        ]);

        return back()->with('success', 'Status dokumen telah diperbarui.');
    }
}