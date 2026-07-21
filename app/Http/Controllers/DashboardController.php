<?php

namespace App\Http\Controllers;

use App\Models\Anak;
use App\Models\AuditLog;
use App\Models\Kelurahan; // Import model Kelurahan
use App\Models\Kecamatan; // Import model Kecamatan
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $query = Anak::query();

        // Inisialisasi variabel stats wilayah
        $totalKecamatan = 0;
        $totalKelurahan = 0;

        // Scope berdasarkan role
        if ($user->hasRole('pendamping')) {
            $query->whereHas('alamatDomisili', function ($q) use ($user) {
                $q->where('kelurahan_id', $user->kelurahan_id);
            });
            
        } elseif ($user->hasRole('kecamatan')) {
            $query->whereHas('alamatDomisili.kelurahan', function ($q) use ($user) {
                $q->where('kecamatan_id', $user->kecamatan_id);
            });
            // Hitung kelurahan yang ada di kecamatan user login
            $totalKelurahan = Kelurahan::where('kecamatan_id', $user->kecamatan_id)->count();

        } elseif ($user->hasRole('kesra')) {
            $query->whereHas('alamatDomisili.kelurahan.kecamatan', function ($q) use ($user) {
                $q->where('kabupaten_id', $user->kabupaten_id);
            });
            // Hitung total kecamatan di kabupaten user login
            $totalKecamatan = Kecamatan::where('kabupaten_id', $user->kabupaten_id)->count();
            // Hitung total kelurahan di kabupaten user login
            $totalKelurahan = Kelurahan::whereHas('kecamatan', function($q) use ($user) {
                $q->where('kabupaten_id', $user->kabupaten_id);
            })->count();
            
        } elseif ($user->hasRole('superadmin')) {
            $totalKecamatan = Kecamatan::count();
            $totalKelurahan = Kelurahan::count();
        }

        $stats = [
            'total' => (clone $query)->count(),
            'pending' => (clone $query)->where('status_data', 'Pending')->count(),
            'disetujui' => (clone $query)->where('status_data', 'Disetujui')->count(),
            'ditolak' => (clone $query)->where('status_data', 'Ditolak')->count(),
            'total_kecamatan' => $totalKecamatan,
            'total_kelurahan' => $totalKelurahan,
        ];

        $anakTerbaru = (clone $query)->with(['alamatDomisili.kelurahan'])->latest()->take(5)->get();
        
        $auditTerbaru = collect();
        if ($user->hasRole('superadmin')) {
            $auditTerbaru = AuditLog::with('user')->latest()->take(5)->get();
        }

        return view('pages.dashboard.index', compact('stats', 'anakTerbaru', 'auditTerbaru'));
    }
}