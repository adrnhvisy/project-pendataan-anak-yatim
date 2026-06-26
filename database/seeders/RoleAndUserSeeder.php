<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class RoleAndUserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Membuat Role Spatie (Perbaikan role yang duplikat)
        Role::firstOrCreate(['name' => 'superadmin']);
        Role::firstOrCreate(['name' => 'kesra']);
        Role::firstOrCreate(['name' => 'kecamatan']);
        Role::firstOrCreate(['name' => 'pendamping']);

        // 2. Akun Superadmin
        $superadmin = User::create([
            'name' => 'Super Administrator',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password123'),
            'is_active' => true,
        ]);
        $superadmin->assignRole('superadmin');

        // 3. Akun Kesra (Akses penuh se-Kabupaten, tidak butuh ID wilayah)
        $kesra = User::create([
            'name' => 'Kesra Kabupaten',
            'email' => 'kesra@gmail.com',
            'password' => Hash::make('password123'),
            'is_active' => true,
        ]);
        $kesra->assignRole('kesra');

        // 4. Akun Admin Kecamatan (Wajib punya kecamatan_id)
        $kecamatan = User::create([
            'name' => 'Admin Kecamatan Pangkalan Kerinci',
            'email' => 'kecamatan@gmail.com',
            'password' => Hash::make('password123'),
            'is_active' => true,
            'kecamatan_id' => 1, // Sesuai data WilayahSeeder kita
        ]);
        $kecamatan->assignRole('kecamatan');

        // 5. Akun Pendamping Kelurahan (Wajib punya kelurahan_id)
        $pendamping = User::create([
            'name' => 'Pendamping Bukit Agung',
            'email' => 'pendamping@gmail.com', // Perbaikan agar tidak duplikat
            'password' => Hash::make('password123'),
            'is_active' => true,
            'kelurahan_id' => 1, // Sesuai data WilayahSeeder kita
        ]);
        $pendamping->assignRole('pendamping'); // Perbaikan pemberian role
    }
}