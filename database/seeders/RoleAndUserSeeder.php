<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RoleAndUserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Membuat Role
        $roles = ['superadmin', 'kesra', 'kecamatan', 'pendamping'];
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // 2. Akun Superadmin (Hanya 1)
        $superadmin = User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Super Administrator',
                'password' => Hash::make('password123'),
                'is_active' => true,
            ]
        );
        $superadmin->assignRole('superadmin');

        // 3. Akun Kesra (1 untuk Kabupaten Pelalawan)
        $kabupaten = Kabupaten::where('nama_kabupaten', 'Pelalawan')->first();
        if ($kabupaten) {
            $kesra = User::updateOrCreate(
                ['email' => 'kesra@gmail.com'],
                [
                    'name' => 'Kesra Kabupaten Pelalawan',
                    'password' => Hash::make('password123'),
                    'is_active' => true,
                    'kabupaten_id' => $kabupaten->id,
                ]
            );
            $kesra->assignRole('kesra');
        }

        // 4. Akun Admin Kecamatan (Satu akun untuk setiap kecamatan)
        $kecamatans = Kecamatan::all();
        foreach ($kecamatans as $kec) {
            $slug = Str::slug($kec->nama_kecamatan);
            $email = "kecamatan.{$slug}@gmail.com";

            $user = User::updateOrCreate(
                ['email' => $email],
                [
                    'name' => 'Admin ' . $kec->nama_kecamatan,
                    'password' => Hash::make('password123'),
                    'is_active' => true,
                    'kecamatan_id' => $kec->id,
                ]
            );
            $user->assignRole('kecamatan');
        }

        // 5. Akun Pendamping Kelurahan (Satu akun untuk setiap kelurahan)
        $kelurahans = Kelurahan::all();
        foreach ($kelurahans as $kel) {
            $slug = Str::slug($kel->nama_kelurahan);
            // Menggunakan email unik berdasarkan nama kelurahan
            $email = "pendamping.{$slug}@gmail.com";

            $user = User::updateOrCreate(
                ['email' => $email],
                [
                    'name' => 'Pendamping ' . $kel->nama_kelurahan,
                    'password' => Hash::make('password123'),
                    'is_active' => true,
                    'kelurahan_id' => $kel->id,
                ]
            );
            $user->assignRole('pendamping');
        }
    }
}