<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WilayahSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Masukkan Provinsi
        $provinsiId = DB::table('provinsi')->insertGetId([
            'nama_provinsi' => 'Riau'
        ]);

        // 2. Masukkan Kabupaten
        $kabupatenId = DB::table('kabupaten')->insertGetId([
            'provinsi_id' => $provinsiId,
            'nama_kabupaten' => 'Pelalawan'
        ]);

        // 3. Masukkan Kecamatan
        $kecamatanId = DB::table('kecamatan')->insertGetId([
            'kabupaten_id' => $kabupatenId,
            'nama_kecamatan' => 'Pangkalan Kerinci'
        ]);

        // 4. Masukkan Kelurahan
        $kelurahan = [
            ['kecamatan_id' => $kecamatanId, 'nama_kelurahan' => 'Bukit Agung', 'kode_pos' => '28381'],
            ['kecamatan_id' => $kecamatanId, 'nama_kelurahan' => 'Kuala Terusan', 'kode_pos' => '28381'],
            ['kecamatan_id' => $kecamatanId, 'nama_kelurahan' => 'Makmur', 'kode_pos' => '28381'],
            ['kecamatan_id' => $kecamatanId, 'nama_kelurahan' => 'Pangkalan Kerinci Barat', 'kode_pos' => '28381'],
            ['kecamatan_id' => $kecamatanId, 'nama_kelurahan' => 'Pangkalan Kerinci Kota', 'kode_pos' => '28381'],
            ['kecamatan_id' => $kecamatanId, 'nama_kelurahan' => 'Pangkalan Kerinci Timur', 'kode_pos' => '28381'],
            ['kecamatan_id' => $kecamatanId, 'nama_kelurahan' => 'Rantau Baru', 'kode_pos' => '28381'],
        ];

        DB::table('kelurahan')->insert($kelurahan);
    }
}