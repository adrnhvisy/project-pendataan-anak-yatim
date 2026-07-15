<?php

namespace App\Http\Controllers\Anak;

use App\Http\Controllers\Controller;
use App\Models\Anak;
use App\Models\Alamat;
use App\Models\OrangTua;
use App\Models\Wali;
use App\Models\Kelurahan;
use App\Models\StatusHistori;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AnakController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $query = Anak::with(['alamatDomisili.kelurahan', 'orangTua', 'pembuatData'])->latest();
        $kelurahans = Kelurahan::orderBy('nama_kelurahan', 'asc')->get();

        // --- PERBAIKAN FILTER KELURAHAN ---
        // Menggunakan whereHas untuk mencari kelurahan_id melalui tabel relasi alamatDomisili
        if ($request->filled('kelurahan')) {
            $query->whereHas('alamatDomisili', function ($q) use ($request) {
                $q->where('kelurahan_id', $request->kelurahan);
            });
        }
        // ----------------------------------

        // Pastikan admin bisa melihat semuanya
        if ($user->hasRole('admin')) {
            // Admin tidak perlu filter
        }
        // Filter untuk Pendamping
        elseif ($user->hasRole('pendamping')) {
            if ($user->kelurahan_id) {
                $query->whereHas('alamatDomisili', function ($q) use ($user) {
                    $q->where('kelurahan_id', $user->kelurahan_id);
                });
            } else {
                $query->whereRaw('1 = 0'); // Menampilkan hasil kosong jika kelurahan tidak di set
            }
        }
        // Filter untuk Kesra
        elseif ($user->hasRole('kesra')) {
            if ($user->kabupaten_id) {
                $query->whereHas('alamatDomisili.kelurahan.kecamatan', function ($q) use ($user) {
                    $q->where('kabupaten_id', $user->kabupaten_id);
                });
            } else {
                $query->whereRaw('1 = 0');
            }
        } elseif ($user->hasRole('kecamatan')) {
            if ($user->kecamatan_id) {
                $query->whereHas('alamatDomisili.kelurahan.kecamatan', function ($q) use ($user) {
                    $q->where('kecamatan_id', $user->kecamatan_id);
                });
            } else {
                $query->whereRaw('1 = 0');
            }
        }

        // Pencarian
        $query->when($request->filled('search'), function ($q) use ($request) {
            $searchTerm = $request->search;
            $q->where(function ($query) use ($searchTerm) {
                $query->where('nik', 'like', '%' . $searchTerm . '%')
                    ->orWhere('nama_lengkap', 'like', '%' . $searchTerm . '%');
            });
        });

        $anak = $query->paginate(10)->withQueryString();
        return view('pages.anak.index', compact('anak', 'kelurahans'));
    }

    public function create()
    {
        $kelurahans = Kelurahan::orderBy('nama_kelurahan')->get();
        return view('pages.anak.create', compact('kelurahans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nik' => 'required|digits:16|unique:anak,nik',
            'no_kk' => 'required|digits:16',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'status_anak' => 'required|in:Yatim,Piatu,Yatim Piatu',
            'no_rekening' => 'nullable|string|max:30',
            'catatan' => 'nullable|string',
            'alamat_lengkap' => 'required|string',
            'rt' => 'required|string|max:3',
            'rw' => 'required|string|max:3',
            'nama_ayah' => 'required|string|max:255',
            'nik_ayah' => 'nullable|digits:16',
            'status_hidup_ayah' => 'required|in:Hidup,Meninggal',
            'pekerjaan_ayah' => 'nullable|string|max:255',
            'nama_ibu' => 'required|string|max:255',
            'nik_ibu' => 'nullable|digits:16',
            'status_hidup_ibu' => 'required|in:Hidup,Meninggal',
            'pekerjaan_ibu' => 'nullable|string|max:255',
            'nama_wali' => 'nullable|string|max:255',
            'nik_wali' => 'nullable|digits:16',
            'hubungan_wali' => 'nullable|string|max:255',
            'pekerjaan_wali' => 'nullable|string|max:255',
            'dokumen' => 'nullable|array',
            'dokumen.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:3072',
        ]);

        if (!auth()->user()->kelurahan_id) {
            return back()->with('error', 'Akun Anda tidak terikat dengan Kelurahan manapun.');
        }

        $statusData = $request->hasFile('dokumen') ? 'Pending' : 'Draft';
        $anak = null;

        DB::transaction(function () use ($request, &$anak, $statusData) {
            $alamat = Alamat::create([
                'alamat_lengkap' => $request->alamat_lengkap,
                'rt' => $request->rt,
                'rw' => $request->rw,
                'kelurahan_id' => auth()->user()->kelurahan_id,
            ]);

            $anak = Anak::create([
                'no_registrasi' => 'REG-' . date('YmdHis') . rand(100, 999),
                'nama_lengkap' => $request->nama_lengkap,
                'nik' => $request->nik,
                'no_kk' => $request->no_kk,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'status_anak' => $request->status_anak,
                'no_rekening' => $request->no_rekening,
                'catatan' => $request->catatan,
                'status_data' => $statusData,
                'alamat_domisili_id' => $alamat->id,
                'created_by' => auth()->id(),
            ]);

            if ($request->hasFile('dokumen')) {
                foreach ($request->file('dokumen') as $kategoriId => $file) {
                    $dokumenPath = $file->store('dokumen_anak', 'public');
                    \App\Models\DokumenAnak::create([
                        'anak_id' => $anak->id,
                        'kategori_dok_id' => $kategoriId,
                        'file_path' => $dokumenPath,
                        'status_verifikasi' => 'Pending',
                        'created_by' => auth()->id(),
                    ]);
                }
            }

            OrangTua::insert([
                [
                    'anak_id' => $anak->id,
                    'jenis_orang_tua' => 'Ayah',
                    'nama' => $request->nama_ayah,
                    'nik' => $request->nik_ayah,
                    'status_hidup' => $request->status_hidup_ayah,
                    'pekerjaan' => $request->pekerjaan_ayah,
                    'alamat_id' => $alamat->id,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'anak_id' => $anak->id,
                    'jenis_orang_tua' => 'Ibu',
                    'nama' => $request->nama_ibu,
                    'nik' => $request->nik_ibu,
                    'status_hidup' => $request->status_hidup_ibu,
                    'pekerjaan' => $request->pekerjaan_ibu,
                    'alamat_id' => $alamat->id,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);

            if ($request->filled('nama_wali')) {
                Wali::create([
                    'anak_id' => $anak->id,
                    'nama' => $request->nama_wali,
                    'nik' => $request->nik_wali,
                    'hubungan_dengan_anak' => $request->hubungan_wali,
                    'pekerjaan' => $request->pekerjaan_wali,
                    'alamat_id' => $alamat->id,
                ]);
            }

            StatusHistori::create([
                'anak_id' => $anak->id,
                'status_lama' => '-',
                'status_baru' => $statusData,
                'keterangan' => $statusData === 'Pending' ? 'Data langsung diajukan verifikasi.' : 'Data disimpan sebagai Draft.',
                'created_by' => auth()->id(),
            ]);

            AuditLog::create([
                'user_id' => auth()->id(),
                'module' => 'Anak',
                'action' => 'Create',
                'record_id' => $anak->id,
                'description' => 'Mendaftarkan anak yatim baru (Status: ' . $statusData . ') NIK: ' . $anak->nik,
                'ip_address' => $request->ip()
            ]);
        });

        if ($anak->status_data === 'Pending') {
            return redirect()->route('anak.index')->with('success', 'Data berhasil diajukan untuk verifikasi.');
        }

        return redirect()->route('anak.show', $anak->id)
            ->with('success', 'Data berhasil disimpan sebagai Draft. Silakan lengkapi dokumen.');
    }

    public function show(Anak $anak)
    {
        $anak->load([
            'alamatDomisili.kelurahan.kecamatan.kabupaten.provinsi',
            'orangTua',
            'wali',
            'dokumen.kategoriDokumen',
            'dokumen.verifier',
            'historiStatus.pembuatHistori',
            'pembuatData'
        ]);
        return view('pages.anak.show', compact('anak'));
    }

    public function edit(Anak $anak)
    {
        if (!in_array($anak->status_data, ['Draft', 'Ditolak'])) {
            abort(403, 'Data tidak dapat diubah pada status ini.');
        }
        $anak->load(['alamatDomisili', 'orangTua', 'wali']);
        $kelurahans = Kelurahan::orderBy('nama_kelurahan')->get();
        return view('pages.anak.edit', compact('anak', 'kelurahans'));
    }

    public function update(Request $request, Anak $anak)
    {
        if ($anak->status_data === 'Disetujui') {
            abort(403, 'Data yang sudah disetujui tidak dapat diubah.');
        }

        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nik' => 'required|digits:16|unique:anak,nik,' . $anak->id,
            'no_kk' => 'required|digits:16',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'status_anak' => 'required|in:Yatim,Piatu,Yatim Piatu',
            'no_rekening' => 'nullable|string|max:30',
            'dokumen.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:3072',
            'nama_ayah' => 'required|string|max:255',
            'nama_ibu' => 'required|string|max:255',
            'alamat_lengkap' => 'required|string',
            'rt' => 'required|string|max:3',
            'rw' => 'required|string|max:3',
        ]);

        DB::transaction(function () use ($request, $anak) {
            if ($anak->alamatDomisili) {
                $anak->alamatDomisili->update([
                    'alamat_lengkap' => $request->alamat_lengkap,
                    'rt' => $request->rt,
                    'rw' => $request->rw,
                    'kelurahan_id' => auth()->user()->kelurahan_id,
                ]);
            }

            $statusLama = $anak->status_data;
            $anak->update([
                'nama_lengkap' => $request->nama_lengkap,
                'nik' => $request->nik,
                'no_kk' => $request->no_kk,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'status_anak' => $request->status_anak,
                'no_rekening' => $request->no_rekening,
                'catatan' => $request->catatan,
                'status_data' => 'Pending',
            ]);

            $anak->orangTua()->updateOrCreate(['jenis_orang_tua' => 'Ayah'], [
                'nama' => $request->nama_ayah,
                'nik' => $request->nik_ayah,
                'status_hidup' => $request->status_hidup_ayah,
                'pekerjaan' => $request->pekerjaan_ayah,
                'alamat_id' => $anak->alamat_domisili_id,
            ]);

            $anak->orangTua()->updateOrCreate(['jenis_orang_tua' => 'Ibu'], [
                'nama' => $request->nama_ibu,
                'nik' => $request->nik_ibu,
                'status_hidup' => $request->status_hidup_ibu,
                'pekerjaan' => $request->pekerjaan_ibu,
                'alamat_id' => $anak->alamat_domisili_id,
            ]);

            if ($request->filled('nama_wali')) {
                $anak->wali()->updateOrCreate(['anak_id' => $anak->id], [
                    'nama' => $request->nama_wali,
                    'nik' => $request->nik_wali,
                    'hubungan_dengan_anak' => $request->hubungan_wali,
                    'pekerjaan' => $request->pekerjaan_wali,
                    'alamat_id' => $anak->alamat_domisili_id,
                ]);
            } elseif ($anak->wali) {
                $anak->wali->delete();
            }

            if ($request->hasFile('dokumen')) {
                foreach ($request->file('dokumen') as $kategoriId => $file) {
                    $oldDoc = \App\Models\DokumenAnak::where('anak_id', $anak->id)
                        ->where('kategori_dok_id', $kategoriId)
                        ->first();

                    if ($oldDoc && $oldDoc->file_path) {
                        Storage::disk('public')->delete($oldDoc->file_path);
                    }

                    $path = $file->store('dokumen_anak', 'public');
                    \App\Models\DokumenAnak::updateOrCreate(
                        ['anak_id' => $anak->id, 'kategori_dok_id' => $kategoriId],
                        ['file_path' => $path, 'status_verifikasi' => 'Pending']
                    );
                }
            }

            StatusHistori::create([
                'anak_id' => $anak->id,
                'status_lama' => $statusLama,
                'status_baru' => 'Pending',
                'keterangan' => 'Data diperbarui dan diajukan kembali ke verifikasi.',
                'created_by' => auth()->id(),
            ]);

            AuditLog::create([
                'user_id' => auth()->id(),
                'module' => 'Anak',
                'action' => 'Update',
                'record_id' => $anak->id,
                'description' => 'Memperbarui dan mengajukan data anak NIK: ' . $anak->nik,
                'ip_address' => $request->ip()
            ]);
        });

        return redirect()->route('anak.show', $anak->id)->with('success', 'Data berhasil diperbarui dan diajukan untuk verifikasi.');
    }

    public function submit(Anak $anak)
    {
        if ($anak->status_data !== 'Draft' && $anak->status_data !== 'Ditolak') {
            abort(403, 'Hanya data Draft atau Ditolak yang bisa diajukan kembali.');
        }

        $kategoriWajibIds = \App\Models\KategoriDokumen::where('is_wajib', true)->pluck('id');
        $dokumenAnakIds = $anak->dokumen()->pluck('kategori_dok_id');
        $dokumenKurang = $kategoriWajibIds->diff($dokumenAnakIds)->count();

        if ($dokumenKurang > 0) {
            return back()->with('error', 'Gagal mengajukan! Silakan lengkapi semua dokumen WAJIB terlebih dahulu.');
        }

        DB::transaction(function () use ($anak) {
            $statusLama = $anak->status_data;
            $anak->update(['status_data' => 'Pending']);

            StatusHistori::create([
                'anak_id' => $anak->id,
                'status_lama' => $statusLama,
                'status_baru' => 'Pending',
                'keterangan' => 'Data diajukan untuk verifikasi Kesra',
                'created_by' => auth()->id(),
            ]);
        });

        return redirect()->route('anak.index')->with('success', 'Data berhasil diajukan untuk verifikasi.');
    }

    public function destroy($id, Request $request)
    {
        try {
            // Memulai transaksi database agar penghapusan aman
            DB::beginTransaction();

            // Cari data anak berdasarkan ID
            $anak = Anak::findOrFail($id);

            // 1. Hapus file fisik dokumen (PDF/JPG) dari server (Opsional, sesuaikan nama field-mu)
            // Asumsi: relasi dokumen() mereturn banyak data, dan nama field untuk path file adalah 'file_path'
            foreach ($anak->dokumen as $dok) {
                if (Storage::disk('public')->exists($dok->file_path)) {
                    Storage::disk('public')->delete($dok->file_path);
                }
            }

            // 2. Hapus data pada tabel relasi yang bergantung pada id anak
            $anak->orangTua()->delete();
            $anak->wali()->delete();
            $anak->dokumen()->delete();
            $anak->historiStatus()->delete();

            // 3. Simpan ID alamat sebelum data anak dihapus (karena restrictOnDelete)
            $alamatId = $anak->alamat_domisili_id;

            // 4. Hapus data utama anak
            $anak->delete();

            // 5. Setelah anak dihapus, hapus data alamat domisili
            if ($alamatId) {
                Alamat::where('id', $alamatId)->delete();
            }

            AuditLog::create([
                'user_id' => auth()->id(), // Menyimpan ID admin yang sedang login
                'action' => 'Delete',   // Jenis aktivitas
                'module' => 'Data Anak', // Modul yang sedang diakses
                'description' => 'Menghapus data anak atas nama ' . $anak->nama_lengkap . ' (ID: ' . $id . ') beserta seluruh relasinya.',
                'ip_address' => $request->ip()
            ]);

            // Jika semua langkah di atas berhasil, simpan permanen perubahan ke database
            DB::commit();

            // Kembalikan pengguna ke halaman daftar anak dengan pesan sukses
            return redirect()->route('anak.index')->with('success', 'Data anak beserta seluruh data terkait (alamat, orang tua, wali, dokumen) berhasil dihapus secara permanen.');

        } catch (\Exception $e) {
            // Jika ada error di tengah jalan, batalkan semua proses hapus
            DB::rollBack();

            // Kembalikan pengguna dengan pesan error
            return redirect()->route('anak.index')->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }

}