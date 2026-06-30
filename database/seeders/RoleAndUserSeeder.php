<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class RoleAndUserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Membuat Role
        $roles = ['superadmin', 'kesra', 'kecamatan', 'pendamping'];
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // 2. Akun Superadmin
        $superadmin = User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Super Administrator',
                'password' => Hash::make('password123'),
                'is_active' => true,
            ]
        );
        $superadmin->assignRole('superadmin');

        // 3. Akun Kesra
        // PERBAIKAN: Harus ada kabupaten_id agar filter di AnakController bekerja
        $kabupaten = Kabupaten::first(); // Ambil sample kabupaten
        $kesra = User::updateOrCreate(
            ['email' => 'kesra@gmail.com'],
            [
                'name' => 'Kesra Kabupaten',
                'password' => Hash::make('password123'),
                'is_active' => true,
                'kabupaten_id' => $kabupaten ? $kabupaten->id : null, 
            ]
        );
        $kesra->assignRole('kesra');

        // 4. Akun Admin Kecamatan
        $kecamatanData = Kecamatan::first();
        $kecamatan = User::updateOrCreate(
            ['email' => 'kecamatan@gmail.com'],
            [
                'name' => 'Admin Kecamatan',
                'password' => Hash::make('password123'),
                'is_active' => true,
                'kecamatan_id' => $kecamatanData ? $kecamatanData->id : null,
            ]
        );
        $kecamatan->assignRole('kecamatan');

        // 5. Akun Pendamping Kelurahan
        $kelurahanData = Kelurahan::first();
        $pendamping = User::updateOrCreate(
            ['email' => 'pendamping@gmail.com'],
            [
                'name' => 'Pendamping Kelurahan',
                'password' => Hash::make('password123'),
                'is_active' => true,
                'kelurahan_id' => $kelurahanData ? $kelurahanData->id : null,
            ]
        );
        $pendamping->assignRole('pendamping');
    }
}