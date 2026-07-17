<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{
    Anak,
    Alamat,
    OrangTua,
    Wali,
    StatusHistori,
    User,
    Kelurahan
};
use Faker\Factory as Faker;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        $pendamping = User::where('email', 'pendamping@gmail.com')->first();
        $kelurahans = Kelurahan::all(); // Mengambil semua kelurahan yang ada

        if ($kelurahans->isEmpty()) {
            $this->command->error('Tidak ada kelurahan ditemukan. Pastikan kamu sudah menjalankan WilayahSeeder!');
            return;
        }

        // 1. Loop setiap kelurahan
        foreach ($kelurahans as $kelurahan) {
            
            // 2. Loop untuk membuat 5 data anak per kelurahan
            for ($i = 0; $i < 5; $i++) {

                $alamat = Alamat::create([
                    'alamat_lengkap' => $faker->streetAddress(),
                    'rt' => $faker->numerify('00#'),
                    'rw' => $faker->numerify('00#'),
                    'kelurahan_id' => $kelurahan->id, // Menggunakan ID dari kelurahan yang sedang diproses
                ]);

                $statusAnak = $faker->randomElement(['Yatim', 'Piatu', 'Yatim Piatu']);
                $statusData = $faker->randomElement(['Pending', 'Disetujui', 'Ditolak']);

                $anak = Anak::create([
                    'no_registrasi' => 'REG-' . date('Y') . '-' . $faker->unique()->numerify('#####'),
                    'nama_lengkap' => $faker->name(),
                    'no_kk' => $faker->numerify('################'),
                    'nik' => $faker->unique()->numerify('################'),
                    'tempat_lahir' => $faker->city(),
                    'tanggal_lahir' => $faker->dateTimeBetween('-15 years', '-5 years')->format('Y-m-d'),
                    'jenis_kelamin' => $faker->randomElement(['Laki-laki', 'Perempuan']),
                    'status_anak' => $statusAnak,
                    'no_rekening' => $faker->optional()->numerify('112#########'),
                    'status_data' => $statusData,
                    'alamat_domisili_id' => $alamat->id,
                    'created_by' => $pendamping?->id,
                ]);

                // AYAH
                OrangTua::create([
                    'anak_id' => $anak->id,
                    'jenis_orang_tua' => 'Ayah',
                    'nama' => $faker->name('male'),
                    'nik' => $faker->unique()->numerify('################'),
                    'status_hidup' => in_array($statusAnak, ['Yatim', 'Yatim Piatu']) ? 'Meninggal' : 'Hidup',
                    'pekerjaan' => $faker->jobTitle(),
                    'alamat_id' => $alamat->id,
                ]);

                // IBU
                OrangTua::create([
                    'anak_id' => $anak->id,
                    'jenis_orang_tua' => 'Ibu',
                    'nama' => $faker->name('female'),
                    'nik' => $faker->unique()->numerify('################'),
                    'status_hidup' => in_array($statusAnak, ['Piatu', 'Yatim Piatu']) ? 'Meninggal' : 'Hidup',
                    'pekerjaan' => $faker->jobTitle(),
                    'alamat_id' => $alamat->id,
                ]);

                // WALI
                if ($faker->boolean(40)) {
                    Wali::create([
                        'anak_id' => $anak->id,
                        'nama' => $faker->name(),
                        'nik' => $faker->unique()->numerify('################'),
                        'hubungan_dengan_anak' => $faker->randomElement(['Paman', 'Bibi', 'Kakek', 'Nenek']),
                        'pekerjaan' => $faker->jobTitle(),
                        'alamat_id' => $alamat->id,
                    ]);
                }

                // HISTORI
                StatusHistori::create([
                    'anak_id' => $anak->id,
                    'status_lama' => 'Draft',
                    'status_baru' => $statusData,
                    'keterangan' => 'Data dummy otomatis',
                    'created_by' => $pendamping?->id,
                ]);
            }
        }
    }
}