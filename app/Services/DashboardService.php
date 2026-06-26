<?php

namespace App\Services;

use App\Models\Anak;

class DashboardService
{
    public function statistics(): array
    {
        return [
            'total' => Anak::count(),
            'draft' => Anak::where(
                'status_data',
                'Draft'
            )->count(),

            'pending' => Anak::where(
                'status_data',
                'Pending'
            )->count(),

            'disetujui' => Anak::where(
                'status_data',
                'Disetujui'
            )->count(),

            'ditolak' => Anak::where(
                'status_data',
                'Ditolak'
            )->count(),
        ];
    }
}