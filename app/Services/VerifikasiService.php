<?php

namespace App\Services;

use App\Models\Anak;
use App\Models\StatusHistori;

class VerifikasiService
{
    public function approve(
        Anak $anak,
        ?string $catatan = null
    ): void {

        $statusLama = $anak->status_data;

        $anak->update([
            'status_data' => 'Disetujui'
        ]);

        $this->history(
            $anak,
            $statusLama,
            'Disetujui',
            $catatan
        );
    }

    public function reject(
        Anak $anak,
        string $catatan
    ): void {

        $statusLama = $anak->status_data;

        $anak->update([
            'status_data' => 'Ditolak'
        ]);

        $this->history(
            $anak,
            $statusLama,
            'Ditolak',
            $catatan
        );
    }

    private function history(
        Anak $anak,
        ?string $statusLama,
        string $statusBaru,
        ?string $catatan = null
    ): void {

        StatusHistori::create([
            'anak_id' => $anak->id,
            'status_lama' => $statusLama,
            'status_baru' => $statusBaru,
            'keterangan' => $catatan,
            'created_by' => auth()->id(),
        ]);
    }
}