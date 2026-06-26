<?php

namespace App\Services;

use App\Models\Provinsi;
use Illuminate\Support\Facades\DB;

class WilayahService
{
    public function scopeUser(
        $query,
        $user
    ) {

        if ($user->hasRole('pendamping')) {

            return $query->where(
                'kelurahan_id',
                $user->kelurahan_id
            );
        }

        if ($user->hasRole('kecamatan')) {

            return $query->whereHas(
                'kelurahan',
                fn ($q)
                    => $q->where(
                        'kecamatan_id',
                        $user->kecamatan_id
                    )
            );
        }

        return $query;
    }

    public function store(array $data)
    {
        return DB::transaction(function () use ($data) {

            $provinsi = Provinsi::create([
                'nama_provinsi' => $data['nama_provinsi']
            ]);

            $kabupaten =
                $provinsi->kabupaten()->create([
                    'nama_kabupaten'
                    => $data['nama_kabupaten']
                ]);

            $kecamatan =
                $kabupaten->kecamatan()->create([
                    'nama_kecamatan'
                    => $data['nama_kecamatan']
                ]);

            $kecamatan->kelurahan()->create([
                'nama_kelurahan'
                => $data['nama_kelurahan'],
                'kode_pos'
                => $data['kode_pos'],
            ]);

            return $provinsi;
        });
    }
}