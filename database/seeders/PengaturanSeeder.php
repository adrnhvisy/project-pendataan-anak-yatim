<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PengaturanSistem;

class PengaturanSeeder extends Seeder
{
    public function run(): void
    {
        $pengaturan = [
            [
                'key' => 'nama_aplikasi',
                'value' => 'Sistem Pendataan Anak Yatim Pelalawan',
                'tipe' => 'text',
                'keterangan' => 'Nama website yang akan muncul di halaman atas.'
            ],
            [
                'key' => 'nama_panjang_aplikasi',
                'value' => 'Sistem Administrasi Hibah Bantuan Anak Yatim',
                'tipe' => 'text',
                'keterangan' => 'Nama panjang aplikasi untuk header atau footer'
            ],
            [
                'key' => 'alamat_kantor',
                'value' => 'Jl. Komplek Perkantoran Bhakti Praja, Pangkalan Kerinci',
                'tipe' => 'text',
                'keterangan' => 'Alamat dinas/instansi pengelola.'
            ],
            [
                'key' => 'nomor_kontak',
                'value' => '0812-3456-7890',
                'tipe' => 'text',
                'keterangan' => 'Nomor WhatsApp atau Telepon yang bisa dihubungi.'
            ],
            [
                'key' => 'logo_web',
                'value' => 'logo.png',
                'tipe' => 'image',
                'keterangan' => 'Logo untuk tampil di halaman atas.'
            ],

        ];

        foreach ($pengaturan as $item) {
            // Gunakan updateOrCreate agar tidak duplikat jika dijalankan 2x
            PengaturanSistem::updateOrCreate(['key' => $item['key']], $item);
        }
    }
}