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

        // 3. Definisi Data Kecamatan & Kelurahan
        $wilayahData = [
            ['nama' => 'Bandar Petalangan', 'kode_pos' => '28384', 'kelurahan' => ['Rawang Empat']],
            ['nama' => 'Bandar Sei Kijang', 'kode_pos' => '28383', 'kelurahan' => ['Sei Kijang']],
            ['nama' => 'Bunut', 'kode_pos' => '28386', 'kelurahan' => ['Pangkalan Bunut']],
            ['nama' => 'Kerumutan', 'kode_pos' => '28352', 'kelurahan' => ['Kerumutan']],
            ['nama' => 'Kuala Kampar', 'kode_pos' => '28385', 'kelurahan' => ['Teluk Dalam']],
            ['nama' => 'Langgam', 'kode_pos' => '28380', 'kelurahan' => ['Langgam']],
            ['nama' => 'Pangkalan Kerinci', 'kode_pos' => '28381', 'kelurahan' => ['Bukit Agung', 'Kuala Terusan', 'Makmur', 'Pangkalan Kerinci Barat', 'Pangkalan Kerinci Kota', 'Pangkalan Kerinci Timur', 'Rantau Baru']],
            ['nama' => 'Pangkalan Kuras', 'kode_pos' => '28382', 'kelurahan' => ['Sorek I']],
            ['nama' => 'Pangkalan Lesung', 'kode_pos' => '28387', 'kelurahan' => ['Pangkalan Lesung']],
            ['nama' => 'Pelalawan', 'kode_pos' => '28353', 'kelurahan' => ['Pelalawan']],
            ['nama' => 'Teluk Meranti', 'kode_pos' => '28354', 'kelurahan' => ['Teluk Meranti']],
            ['nama' => 'Ukui', 'kode_pos' => '28388', 'kelurahan' => ['Ukui I']],
        ];

        // 4. Proses Insert ke Database
        foreach ($wilayahData as $kec) {
            $kecamatanId = DB::table('kecamatan')->insertGetId([
                'kabupaten_id' => $kabupatenId,
                'nama_kecamatan' => $kec['nama']
            ]);

            foreach ($kec['kelurahan'] as $namaKelurahan) {
                DB::table('kelurahan')->insert([
                    'kecamatan_id' => $kecamatanId,
                    'nama_kelurahan' => $namaKelurahan,
                    'kode_pos' => $kec['kode_pos']
                ]);
            }
        }
    }
}