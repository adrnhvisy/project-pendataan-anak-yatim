<?php

namespace App\Http\Controllers;

use App\Models\Anak;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $query = Anak::query();

        // Isolasi wilayah
        if ($user->hasRole('kecamatan')) {
            $query->whereHas('kelurahan', function ($q) use ($user) {
                $q->where('kecamatan_id', $user->kecamatan_id);
            });
        }

        $stats = [
            'total' => $query->count(),
            'pending' => (clone $query)->where('status_data', 'Pending')->count(),
            'disetujui' => (clone $query)->where('status_data', 'Disetujui')->count(),
            'draft' => (clone $query)->where('status_data', 'Draft')->count(),
        ];

        return view('pages.anak.laporan.index', compact('stats'));
    }

    public function exportExcel()
    {
        // Logika export excel nanti di sini
    }

    public function exportPdf()
    {
        // Logika export pdf nanti di sini
    }
}