<?php

namespace App\Http\Controllers;

use App\Models\{Anak, Alamat, OrangTua, StatusHistori};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnakController extends Controller
{
    public function index()
    {
        // Menampilkan daftar anak yatim dengan fitur Paginasi (15 data per halaman)
        $anak = Anak::with(['alamat_domisili', 'kelurahan'])->latest()->paginate(15);
        return view('pages.anak.index', compact('anak'));
    }

    public function create()
    {
        // Menampilkan form pendaftaran
        return view('pages.anak.create');
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

    public function show(Anak $anak)
    {
        // Eager load semua relasi yang dibutuhkan untuk halaman Detail Buku Profil Anak
        $anak->load(['orang_tua', 'wali', 'alamat_domisili', 'dokumen_anak.kategori', 'histori_status.pembuat']);
        
        return view('pages.anak.show', compact('anak'));
    }
}