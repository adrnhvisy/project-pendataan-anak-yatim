<?php

namespace App\Http\Controllers;

use App\Models\Anak;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $queryAnak = Anak::query();

        // Filter data berdasarkan hak akses wilayah
        if ($user->hasRole('pendamping')) {
            $queryAnak->where('kelurahan_id', $user->kelurahan_id);
        } elseif ($user->hasRole('kecamatan')) {
            // Relasi: Anak -> Kelurahan -> Kecamatan
            $queryAnak->whereHas('kelurahan', function($q) use ($user) {
                $q->where('kecamatan_id', $user->kecamatan_id);
            });
        }

        // Siapkan data untuk dikirim ke tampilan (View)
        $stats = [
            'total_anak' => (clone $queryAnak)->count(),
            'anak_disetujui' => (clone $queryAnak)->where('status_data', 'Disetujui')->count(),
            'anak_pending' => (clone $queryAnak)->where('status_data', 'Pending')->count(),
            'total_user' => $user->hasRole('superadmin') ? User::count() : 0,
        ];

        return view('pages.dashboard.index', compact('stats'));
    }
}