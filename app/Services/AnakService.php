<?php

namespace App\Services;

use App\Models\{
    Anak,
    Alamat,
    OrangTua,
    Wali,
    StatusHistori
};
use Illuminate\Support\Facades\DB;

class AnakService
{
    public function store(array $data): Anak
    {
        return DB::transaction(function () use ($data) {

            $alamat = Alamat::create([
                'alamat_lengkap' => $data['alamat_lengkap'],
                'rt'              => $data['rt'],
                'rw'              => $data['rw'],
                'kelurahan_id'    => $data['kelurahan_id'],
            ]);

            $anak = Anak::create([
                'no_registrasi'      => $this->generateNomorRegistrasi(),
                'nama_lengkap'       => $data['nama_lengkap'],
                'nik'                => $data['nik'],
                'no_kk'              => $data['no_kk'],
                'tempat_lahir'       => $data['tempat_lahir'],
                'tanggal_lahir'      => $data['tanggal_lahir'],
                'jenis_kelamin'      => $data['jenis_kelamin'],
                'status_anak'        => $data['status_anak'],
                'no_rekening'        => $data['no_rekening'] ?? null,
                'status_data'        => 'Draft',
                'alamat_domisili_id' => $alamat->id,
                'created_by'         => auth()->id(),
            ]);

            $this->storeOrangTua(
                $anak,
                $alamat,
                $data
            );

            $this->storeWali(
                $anak,
                $alamat,
                $data
            );

            $this->createHistory(
                $anak,
                null,
                'Draft',
                'Pendaftaran awal'
            );

            return $anak;
        });
    }

    public function update(
        Anak $anak,
        array $data
    ): Anak {

        return DB::transaction(function () use (
            $anak,
            $data
        ) {

            $anak->alamatDomisili->update([
                'alamat_lengkap' => $data['alamat_lengkap'],
                'rt'             => $data['rt'],
                'rw'             => $data['rw'],
                'kelurahan_id'   => $data['kelurahan_id'],
            ]);

            $anak->update([
                'nama_lengkap'  => $data['nama_lengkap'],
                'nik'           => $data['nik'],
                'no_kk'         => $data['no_kk'],
                'tempat_lahir'  => $data['tempat_lahir'],
                'tanggal_lahir' => $data['tanggal_lahir'],
                'jenis_kelamin' => $data['jenis_kelamin'],
                'status_anak'   => $data['status_anak'],
                'no_rekening'   => $data['no_rekening'] ?? null,
            ]);

            return $anak->fresh();
        });
    }

    private function generateNomorRegistrasi(): string
    {
        $lastId = Anak::max('id') + 1;

        return sprintf(
            'REG-%s-%05d',
            now()->year,
            $lastId
        );
    }

    private function storeOrangTua(
        Anak $anak,
        Alamat $alamat,
        array $data
    ): void {

        OrangTua::create([
            'anak_id'          => $anak->id,
            'jenis_orang_tua'  => 'Ayah',
            'nama'             => $data['nama_ayah'],
            'nik'              => $data['nik_ayah'],
            'status_hidup'     => $data['status_hidup_ayah'],
            'alamat_id'        => $alamat->id,
        ]);

        OrangTua::create([
            'anak_id'          => $anak->id,
            'jenis_orang_tua'  => 'Ibu',
            'nama'             => $data['nama_ibu'],
            'nik'              => $data['nik_ibu'],
            'status_hidup'     => $data['status_hidup_ibu'],
            'alamat_id'        => $alamat->id,
        ]);
    }

    private function storeWali(
        Anak $anak,
        Alamat $alamat,
        array $data
    ): void {

        if (empty($data['nama_wali'])) {
            return;
        }

        Wali::create([
            'anak_id'              => $anak->id,
            'nama'                 => $data['nama_wali'],
            'nik'                  => $data['nik_wali'],
            'hubungan_dengan_anak' => $data['hubungan_wali'],
            'alamat_id'            => $alamat->id,
        ]);
    }

    public function createHistory(
        Anak $anak,
        ?string $statusLama,
        string $statusBaru,
        ?string $keterangan = null
    ): void {

        StatusHistori::create([
            'anak_id'      => $anak->id,
            'status_lama'  => $statusLama,
            'status_baru'  => $statusBaru,
            'keterangan'   => $keterangan,
            'created_by'   => auth()->id(),
        ]);
    }
}