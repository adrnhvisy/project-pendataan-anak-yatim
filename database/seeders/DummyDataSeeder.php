<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{Anak, Alamat, OrangTua, StatusHistori, User};
use Faker\Factory as Faker;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        // Memanggil Faker dengan bahasa/format Indonesia
        $faker = Faker::create('id_ID'); 
        
        // Mengambil akun pendamping yang sudah kita buat sebelumnya
        $pendamping = User::where('email', 'pendamping@gmail.com')->first();

        // Kita perintahkan Laravel membuat 20 data secara otomatis
        for ($i = 1; $i <= 20; $i++) {
            
            // 1. Buat Alamat Acak
            $alamat = Alamat::create([
                'alamat_lengkap' => $faker->streetAddress(),
                'rt' => $faker->numerify('00#'),
                'rw' => $faker->numerify('00#'),
                'kelurahan_id' => $faker->numberBetween(1, 7), // Acak dari 7 kelurahan di Pelalawan
            ]);

            // 2. Buat Profil Anak Acak
            $anak = Anak::create([
                'no_registrasi' => 'REG-' . date('Y') . '-' . $faker->unique()->numerify('#####'),
                'nama_lengkap' => $faker->name(),
                'no_kk' => $faker->numerify('140502##########'),
                'nik' => $faker->numerify('140502##########'),
                'tempat_lahir' => $faker->city(),
                'tanggal_lahir' => $faker->dateTimeBetween('-15 years', '-5 years')->format('Y-m-d'),
                'jenis_kelamin' => $faker->randomElement(['Laki-laki', 'Perempuan']),
                'status_anak' => $faker->randomElement(['Yatim', 'Piatu', 'Yatim Piatu']),
                'no_rekening' => $faker->numerify('112-##-#####'),
                'status_data' => $faker->randomElement(['Draft', 'Pending', 'Disetujui', 'Ditolak']),
                'alamat_domisili_id' => $alamat->id,
                'kelurahan_id' => $alamat->kelurahan_id,
                'created_by' => $pendamping->id,
            ]);

            // 3. Buat Data Orang Tua (Contoh Ayah)
            OrangTua::create([
                'anak_id' => $anak->id,
                'jenis_orang_tua' => 'Ayah',
                'nama' => $faker->name('male'),
                'nik' => $faker->numerify('140502##########'),
                // Jika status anak Yatim, otomatis status ayah diset Meninggal
                'status_hidup' => ($anak->status_anak == 'Yatim' || $anak->status_anak == 'Yatim Piatu') ? 'Meninggal' : 'Hidup',
                'pekerjaan' => $faker->jobTitle(),
                'alamat_id' => $alamat->id,
            ]);

            // 4. Catat ke Histori Status
            StatusHistori::create([
                'anak_id' => $anak->id,
                'status_anak' => $anak->status_data,
                'tanggal' => now(),
                'keterangan' => 'Data awal ditambahkan oleh sistem otomatis (Seeder).',
                'created_by' => $pendamping->id,
            ]);
        }
    }
}