<?php

namespace App\Http\Controllers;

use App\Models\{Anak, Alamat, OrangTua, StatusHistori, Wali};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnakController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Mulai query dengan memanggil relasi agar performa cepat
        $query = Anak::with(['kelurahan', 'alamat_domisili'])->latest();

        // 1. Jika yang login adalah Pendamping Kelurahan
        if ($user->hasRole('pendamping')) {
            $query->where('kelurahan_id', $user->kelurahan_id);
        }
        // 2. Jika yang login adalah Admin Kecamatan
        elseif ($user->hasRole('kecamatan')) {
            $query->whereHas('kelurahan', function ($q) use ($user) {
                $q->where('kecamatan_id', $user->kecamatan_id);
            });
        }
        // Catatan: Kesra & Superadmin tidak difilter, jadi bisa melihat semua.

        // Eksekusi query dengan paginasi
        $anak = $query->paginate(15);

        return view('pages.anak.index', compact('anak'));
    }

    public function create()
    {
        $this->restrictKecamatan();
        $kelurahans = \App\Models\Kelurahan::all();
        return view('pages.anak.create', compact('kelurahans'));
    }

    public function store(Request $request)
    {
        // 1. Validasi Ketat
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nik' => 'required|unique:anak,nik|digits:16',
            'kelurahan_id' => 'required|exists:kelurahan,id',
            'file_kk' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_ktp' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        DB::transaction(function () use ($request) {
            // A. Simpan Alamat
            $alamat = Alamat::create([
                'alamat_lengkap' => $request->alamat_lengkap,
                'rt' => $request->rt,
                'rw' => $request->rw,
                'kelurahan_id' => $request->kelurahan_id,
            ]);

            // B. Simpan Anak
            $anak = Anak::create([
                'no_registrasi' => 'REG-' . date('Y') . '-' . rand(10000, 99999),
                'nama_lengkap' => $request->nama_lengkap,
                'nik' => $request->nik,
                'no_kk' => $request->no_kk,
                'no_rekening' => $request->no_rekening,
                'status_anak' => $request->status_anak,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'status_data' => 'Draft',
                'alamat_domisili_id' => $alamat->id,
                'kelurahan_id' => $request->kelurahan_id,
                'created_by' => auth()->id(),
            ]);

            // C. Simpan Orang Tua
            OrangTua::create(['anak_id' => $anak->id, 'jenis_orang_tua' => 'Ayah', 'nama' => $request->nama_ayah, 'nik' => $request->nik_ayah, 'status_hidup' => $request->status_hidup_ayah]);
            OrangTua::create(['anak_id' => $anak->id, 'jenis_orang_tua' => 'Ibu', 'nama' => $request->nama_ibu, 'nik' => $request->nik_ibu, 'status_hidup' => $request->status_hidup_ibu]);

            // D. Simpan Wali (Opsional)
            if ($request->filled('nama_wali')) {
                Wali::create([
                    'anak_id' => $anak->id,
                    'nama' => $request->nama_wali,
                    'nik' => $request->nik_wali,
                    'hubungan_dengan_anak' => $request->hubungan_wali
                ]);
            }

            // E. Simpan Dokumen (Jika ada)
            $files = ['file_kk' => 1, 'file_ktp' => 2]; // Asumsi ID Kategori
            foreach ($files as $inputName => $kategoriId) {
                if ($request->hasFile($inputName)) {
                    $path = $request->file($inputName)->store('dokumen_anak', 'public');
                    DokumenAnak::create([
                        'anak_id' => $anak->id,
                        'kategori_dok_id' => $kategoriId,
                        'file_path' => $path,
                    ]);
                }
            }

            // F. Histori
            StatusHistori::create([
                'anak_id' => $anak->id,
                'status_anak' => 'Draft',
                'tanggal' => now(),
                'keterangan' => 'Pendaftaran lengkap oleh ' . auth()->user()->name,
                'created_by' => auth()->id(),
            ]);
        });

        return redirect()->route('anak.index')->with('success', 'Data anak berhasil disimpan!');
    }

    public function edit(Anak $anak)
    {
        $this->restrictKecamatan();
        // Eager load agar data alamat dan orang tua langsung siap
        $anak->load(['alamat_domisili', 'orang_tua']);
        return view('pages.anak.edit', compact('anak'));
    }

    public function update(Request $request, Anak $anak)
    {
        DB::transaction(function () use ($request, $anak) {
            // 1. Update Alamat
            $anak->alamat_domisili->update([
                'alamat_lengkap' => $request->alamat_lengkap,
                'rt' => $request->rt,
                'rw' => $request->rw,
                'kelurahan_id' => $request->kelurahan_id,
            ]);

            // 2. Update Data Anak
            $anak->update([
                'nama_lengkap' => $request->nama_lengkap,
                'nik' => $request->nik,
                'no_kk' => $request->no_kk,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'status_anak' => $request->status_anak,
                'kelurahan_id' => $request->kelurahan_id,
            ]);

            // 3. Update Orang Tua (Update data ayah yang ada)
            $ayah = $anak->orang_tua()->where('jenis_orang_tua', 'Ayah')->first();
            if ($ayah) {
                $ayah->update([
                    'nama' => $request->nama_ayah,
                    'nik' => $request->nik_ayah,
                    'status_hidup' => $request->status_hidup_ayah,
                ]);
            }
        });

        return redirect()->route('anak.index')->with('success', 'Data anak berhasil diperbarui!');
    }

    public function show(Anak $anak)
    {
        // Perhatikan perubahan dari 'kategori' menjadi 'kategori_dokumen'
        $anak->load([
            'orang_tua',
            'wali',
            'alamat_domisili',
            'dokumen.kategori_dokumen', // <--- INI YANG DIPERBAIKI
            'histori_status.pembuat_histori'
        ]);

        return view('pages.anak.show', compact('anak'));
    }

    public function verifikasiIndex()
    {
        $user = auth()->user();
        $query = Anak::with(['kelurahan', 'alamat_domisili'])
            ->where('status_data', 'Pending')
            ->latest();

        if ($user->hasRole('kecamatan')) {
            $query->whereHas('kelurahan', function ($q) use ($user) {
                $q->where('kecamatan_id', $user->kecamatan_id);
            });
        }

        $anak = $query->paginate(15);
        return view('pages.anak.verifikasi', compact('anak')); // Arahkan ke file baru
    }

    public function approve(Request $request, Anak $anak)
    {
        $anak->update(['status_data' => 'Disetujui']);

        StatusHistori::create([
            'anak_id' => $anak->id,
            'status_anak' => 'Disetujui',
            'tanggal' => now(),
            'keterangan' => 'Diverifikasi oleh: ' . auth()->user()->name,
            'created_by' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Data anak berhasil diverifikasi!');
    }

    public function verifikasiAction(Request $request, Anak $anak)
    {
        // Cuma Kecamatan atau Kesra yang boleh verifikasi
        if (!auth()->user()->hasAnyRole(['kecamatan', 'kesra', 'superadmin'])) {
            abort(403);
        }

        $anak->update(['status_data' => 'Disetujui']);

        \App\Models\StatusHistori::create([
            'anak_id' => $anak->id,
            'status_anak' => 'Disetujui',
            'tanggal' => now(),
            'keterangan' => 'Data disetujui oleh ' . auth()->user()->name,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('anak.verifikasi')->with('success', 'Data anak berhasil diverifikasi!');
    }

    public function kategoriDokumen()
    {
        // Kita panggil model KategoriDokumen untuk mengambil semua daftar kategori
        // Kita gunakan 'all()' karena datanya tidak terlalu banyak
        $kategori = \App\Models\KategoriDokumen::all();

        // Mengirim data ke view yang akan kita buat nanti
        return view('pages.superadmin.dokumen.index', compact('kategori'));
    }

    public function laporan()
    {
        $user = auth()->user();

        // Base query agar tetap terisolasi per wilayah
        $query = Anak::query();
        if ($user->hasRole('kecamatan')) {
            $query->whereHas('kelurahan', function ($q) use ($user) {
                $q->where('kecamatan_id', $user->kecamatan_id);
            });
        }

        // Mengambil statistik
        $stats = [
            'total' => $query->count(),
            'pending' => (clone $query)->where('status_data', 'Pending')->count(),
            'disetujui' => (clone $query)->where('status_data', 'Disetujui')->count(),
            'draft' => (clone $query)->where('status_data', 'Draft')->count(),
        ];

        return view('pages.anak.laporan', compact('stats'));
    }

    public function destroy(Anak $anak)
    {
        // Hentikan proses jika siapa pun mencoba menghapus
        // Kecuali jika kamu ingin Superadmin boleh menghapus, silakan hapus if ini
        abort(403, 'Kebijakan Sistem: Data anak tidak dapat dihapus.');
    }

    public function updateStatus(Request $request, Anak $anak)
    {
        $request->validate([
            'status' => 'required|in:Disetujui,Ditolak,Revisi',
            'catatan' => 'nullable|string'
        ]);

        DB::transaction(function () use ($request, $anak) {
            // Update status anak
            $anak->update(['status_data' => $request->status]);

            // Simpan alasan di histori
            StatusHistori::create([
                'anak_id' => $anak->id,
                'status_anak' => $request->status,
                'tanggal' => now(),
                'keterangan' => ($request->catatan) ?: 'Status diubah menjadi ' . $request->status,
                'created_by' => auth()->id(),
            ]);
        });

        return redirect()->back()->with('success', 'Status data berhasil diperbarui.');
    }

    private function restrictKecamatan()
    {
        if (auth()->user()->hasRole('kecamatan')) {
            abort(403, 'Akses ditolak: Kecamatan hanya bisa melihat data.');
        }
    }

    private function restricPenamping()
    {
        if (auth()->user()->hasRole('pendamping')) {
            abort(403, 'Anda tidak memiliki hak akses verifikasi.');
        }
    }

}