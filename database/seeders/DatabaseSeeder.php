<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            WilayahSeeder::class,
            RoleAndUserSeeder::class,
            KategoriDokumenSeeder::class, // Tambahan Baru
            DummyDataSeeder::class,       // Tambahan Baru
        ]);
    }
}