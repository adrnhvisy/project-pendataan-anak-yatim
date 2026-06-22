<?php

namespace App\Http\Controllers;

use App\Models\{Anak, Alamat, OrangTua, StatusHistori};
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
        // DB::transaction memastikan semua tabel tersimpan, atau dibatalkan jika ada yang error
        DB::transaction(function () use ($request) {

            // 1. Simpan Alamat Terlebih Dahulu
            $alamat = Alamat::create([
                'alamat_lengkap' => $request->alamat_lengkap,
                'rt' => $request->rt,
                'rw' => $request->rw,
                'kelurahan_id' => $request->kelurahan_id,
            ]);

            // 2. Simpan Data Anak (Gunakan ID alamat yang baru saja dibuat)
            $anak = Anak::create([
                'no_registrasi' => 'REG-' . date('Y') . '-' . rand(10000, 99999),
                'nama_lengkap' => $request->nama_lengkap,
                'nik' => $request->nik,
                'no_kk' => $request->no_kk,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'status_anak' => $request->status_anak,
                'status_data' => 'Draft', // Status awal selalu Draft
                'alamat_domisili_id' => $alamat->id,
                'kelurahan_id' => $request->kelurahan_id,
                'created_by' => auth()->id(),
            ]);

            // 3. Simpan Data Orang Tua (Ayah / Ibu)
            OrangTua::create([
                'anak_id' => $anak->id,
                'jenis_orang_tua' => 'Ayah',
                'nama' => $request->nama_ayah,
                'nik' => $request->nik_ayah,
                'status_hidup' => $request->status_hidup_ayah,
            ]);

            // 4. Catat Histori Awal
            StatusHistori::create([
                'anak_id' => $anak->id,
                'status_anak' => 'Draft',
                'tanggal' => now(),
                'keterangan' => 'Pendaftaran data baru',
                'created_by' => auth()->id(),
            ]);
        });

        return redirect()->route('anak.index')->with('success', 'Data anak berhasil ditambahkan!');
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

    private function restrictKecamatan()
    {
        if (auth()->user()->hasRole('kecamatan')) {
            abort(403, 'Akses ditolak: Kecamatan hanya bisa melihat data.');
        }
    }

}