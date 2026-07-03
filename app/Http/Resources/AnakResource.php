<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AnakResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            // 1. Data Utama Anak
            'id' => $this->id,
            'no_registrasi' => $this->no_registrasi,
            'nama_lengkap' => $this->nama_lengkap,
            'no_kk' => $this->no_kk,
            'nik' => $this->nik,
            'tempat_lahir' => $this->tempat_lahir,
            'tanggal_lahir' => $this->tanggal_lahir,
            'jenis_kelamin' => $this->jenis_kelamin,
            'status_anak' => $this->status_anak,
            'no_rekening' => $this->no_rekening,
            'catatan' => $this->catatan,
            'status_data' => $this->status_data,
            'alamat_domisili_id' => $this->alamat_domisili_id,
            'created_by' => $this->created_by,

            // 2. Relasi ke Alamat Domisili (Model Alamat -> Kelurahan)
            'alamat_domisili' => $this->alamatDomisili ? [
                'id' => $this->alamatDomisili->id,
                'alamat_lengkap' => $this->alamatDomisili->alamat_lengkap,
                'rt' => $this->alamatDomisili->rt,
                'rw' => $this->alamatDomisili->rw,
                'kelurahan_id' => $this->alamatDomisili->kelurahan_id,
            ] : null,

            // 3. Relasi ke Orang Tua (Model OrangTua - Karena hasMany, kita gunakan map)
            'orang_tua' => $this->orangTua->map(function ($ortu) {
                return [
                    'id' => $ortu->id,
                    'anak_id' => $ortu->anak_id,
                    'jenis_orang_tua' => $ortu->jenis_orang_tua,
                    'nama' => $ortu->nama,
                    'nik' => $ortu->nik,
                    'status_hidup' => $ortu->status_hidup,
                    'pekerjaan' => $ortu->pekerjaan,
                    'alamat_id' => $ortu->alamat_id,
                ];
            }),

            // 4. Relasi ke Wali (Model Wali - Karena hasOne, bisa langsung diambil)
            'wali' => $this->wali ? [
                'id' => $this->wali->id,
                'anak_id' => $this->wali->anak_id,
                'nama' => $this->wali->nama,
                'nik' => $this->wali->nik,
                'hubungan_dengan_anak' => $this->wali->hubungan_dengan_anak,
                'pekerjaan' => $this->wali->pekerjaan,
                'alamat_id' => $this->wali->alamat_id,
            ] : null,

            // 5. Relasi ke Dokumen Anak (Model DokumenAnak - Karena hasMany, kita gunakan map)
            'dokumen_anak' => $this->dokumen->map(function ($dok) {
                return [
                    'id' => $dok->id,
                    'anak_id' => $dok->anak_id,
                    'kategori_dok_id' => $dok->kategori_dok_id,
                    'file_path' => $dok->file_path,
                    'status_verifikasi' => $dok->status_verifikasi,
                    'verified_by' => $dok->verified_by,
                    'verified_at' => $dok->verified_at,
                    'catatan' => $dok->catatan,
                ];
            }),

            // 6. Relasi ke Pembuat Data (Model User)
            'pembuat_data' => $this->pembuatData ? [
                'id' => $this->pembuatData->id,
                'name' => $this->pembuatData->name,
                'email' => $this->pembuatData->email,
            ] : null,
        ];
    }
}
