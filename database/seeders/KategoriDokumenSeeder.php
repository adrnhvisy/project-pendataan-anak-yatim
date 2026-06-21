<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KategoriDokumen;

class KategoriDokumenSeeder extends Seeder
{
    public function run(): void
    {
        $dokumen = [
            ['nama_dokumen' => 'Kartu Keluarga', 'is_wajib' => true],
            ['nama_dokumen' => 'Akta Kelahiran Anak', 'is_wajib' => true],
            ['nama_dokumen' => 'Surat Keterangan Kematian (Ayah/Ibu)', 'is_wajib' => true],
            ['nama_dokumen' => 'KTP Orang Tua / Wali', 'is_wajib' => true],
            ['nama_dokumen' => 'Surat Keterangan Tidak Mampu (SKTM)', 'is_wajib' => false],
            ['nama_dokumen' => 'Foto Rumah', 'is_wajib' => false],
        ];

        foreach ($dokumen as $dok) {
            KategoriDokumen::create($dok);
        }
    }
}