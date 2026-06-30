<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KategoriDokumen;

class KategoriDokumenSeeder extends Seeder
{
    public function run(): void
    {
        $dokumen = [
            ['nama_dokumen' => 'Surat Permohonan Pengajuan', 'is_wajib' => true],
            ['nama_dokumen' => 'Surat Permohonan Pencairan', 'is_wajib' => true],
            ['nama_dokumen' => 'Fotocopy KTP Orang Tua/Wali', 'is_wajib' => true],
            ['nama_dokumen' => 'Fotocopy Kartu Keluarga', 'is_wajib' => true],
            ['nama_dokumen' => 'Fotocopy Akte Kelahiran / Surat Keterangan Lahir dari Lurah', 'is_wajib' => true],
            ['nama_dokumen' => 'Fotocopy Akte Kematian Orangtua / Surat Keterangan Kematian dari Lurah', 'is_wajib' => true],
            ['nama_dokumen' => 'Surat Pernyataan Benar Permohonan Anak Yatim', 'is_wajib' => true],
            ['nama_dokumen' => 'Surat Pernyataan Kebenaran Dokumen', 'is_wajib' => true],
            ['nama_dokumen' => 'Surat Pernyataan Tanggungjawab Penggunaan Belanja Bantuan Sosial Permohonan', 'is_wajib' => true],
            ['nama_dokumen' => 'Fotocopy Rekening Bank Riau Kepri Syariah', 'is_wajib' => true],
            ['nama_dokumen' => 'Pas Foto Ukuran 3x4 (Warna)', 'is_wajib' => true],
        ];


        foreach ($dokumen as $dok) {
            KategoriDokumen::create($dok);
        }
    }
}