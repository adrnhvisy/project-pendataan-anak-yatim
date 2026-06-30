<?php

namespace App\Http\Controllers;

use App\Models\Anak;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $query = Anak::query();

        // Scope berdasarkan role
        if ($user->hasRole('pendamping')) {
            $query->whereHas('alamatDomisili', function ($q) use ($user) {
                $q->where('kelurahan_id', $user->kelurahan_id);
            });
        } elseif ($user->hasRole('kesra')) {
            $query->whereHas('alamatDomisili.kelurahan.kecamatan', function ($q) use ($user) {
                $q->where('kabupaten_id', $user->kabupaten_id);
            });
        }

        $stats = [
            'total' => (clone $query)->count(),
            'draft' => (clone $query)->where('status_data', 'Draft')->count(),
            'pending' => (clone $query)->where('status_data', 'Pending')->count(),
            'disetujui' => (clone $query)->where('status_data', 'Disetujui')->count(),
            'ditolak' => (clone $query)->where('status_data', 'Ditolak')->count(),
        ];

        $anakTerbaru = (clone $query)->with(['alamatDomisili.kelurahan'])->latest()->take(5)->get();
        
        $auditTerbaru = collect();
        if ($user->hasRole('superadmin')) {
            $auditTerbaru = AuditLog::with('user')->latest()->take(5)->get();
        }

        return view('pages.dashboard.index', compact('stats', 'anakTerbaru', 'auditTerbaru'));
    }
}