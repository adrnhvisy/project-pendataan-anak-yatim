<?php

namespace App\Services;

use App\Models\DokumenAnak;
use Illuminate\Support\Facades\Storage;

class DokumenService
{
    public function upload(
        int $anakId,
        int $kategoriId,
        $file
    ): DokumenAnak {

        $path = $file->store(
            'dokumen_anak',
            'public'
        );

        return DokumenAnak::create([
            'anak_id' => $anakId,
            'kategori_dok_id' => $kategoriId,
            'file_path' => $path,
            'status_verifikasi' => 'Menunggu',
        ]);
    }

    public function delete(
        DokumenAnak $dokumen
    ): void {

        Storage::disk('public')
            ->delete($dokumen->file_path);

        $dokumen->delete();
    }
}