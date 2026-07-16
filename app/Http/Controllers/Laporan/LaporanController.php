<?php

namespace App\Http\Controllers\Laporan;

use App\Exports\AnakExport;
use App\Http\Controllers\Controller;
use App\Models\Anak;
use App\Models\AuditLog;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    public function index()
    {
        return view('pages.laporan.index');
    }

    public function anak(Request $request)
    {
        $query = $this->buildLaporanQuery($request);
        $data = $query->paginate(10);
        return view('pages.laporan.anak', compact('data'));
    }


    public function wilayah(Request $request)
    {
        // Melakukan join ke tabel alamat untuk mendapatkan kelurahan_id
        $data = Anak::join('alamat', 'anak.alamat_domisili_id', '=', 'alamat.id')
            ->select('alamat.kelurahan_id')
            ->selectRaw('count(anak.id) as total')
            ->selectRaw('sum(case when status_data = "Disetujui" then 1 else 0 end) as total_disetujui')
            ->groupBy('alamat.kelurahan_id')
            ->paginate(10);

        // Load relasi Kelurahan dan Kecamatan agar bisa diakses di view
        $kelurahanIds = $data->pluck('kelurahan_id');
        $kelurahans = \App\Models\Kelurahan::with('kecamatan')
            ->whereIn('id', $kelurahanIds)
            ->get()
            ->keyBy('id');

        // Menambahkan objek kelurahan ke dalam setiap item data
        foreach ($data as $item) {
            $item->kelurahan_data = $kelurahans->get($item->kelurahan_id);
        }

        return view('pages.laporan.wilayah', compact('data'));
    }

    public function export(Request $request)
    {
        $request->validate([
            'filter' => 'required|in:all,under18',
            'type' => 'required|in:excel,pdf',
            'only_verified' => 'nullable',
            'tahun' => 'nullable',
        ]);

        $query = Anak::with([
            'alamatDomisili.kelurahan.kecamatan',
            'pembuatData'
        ]);

        // 1. Filter Hanya Data Disetujui
        if ($request->filled('only_verified')) {
            $query->where('status_data', 'Disetujui');
        }

        // 2. Filter Tahun (asumsi berdasarkan created_at)
        if ($request->filled('tahun') && $request->tahun !== 'all') {
            $query->whereYear('created_at', $request->tahun);
        }

        // 3. Filter umur
        if ($request->filter === 'under18') {
            $query->whereDate('tanggal_lahir', '>', now()->subYears(18));
        }

        $data = $query->get();

        if ($data->isEmpty()) {
            return back()->with('error', 'Tidak ada data ditemukan untuk kriteria yang dipilih.');
        }

        if ($request->type === 'excel') {
            return Excel::download(
                new AnakExport($request->filter, $request->only_verified, $request->tahun),
                'Laporan_Data_Anak_' . now()->format('Ymd_His') . '.xlsx'
            );
        }

        if ($request->type === 'pdf') {
            $pdf = Pdf::loadView('pages.laporan.pdf', [
                'anak' => $data,
                'filter' => $request->filter,
                'total' => $data->count(),
                'tanggal' => now()->format('d/m/Y H:i'),
            ])->setPaper('a4', 'landscape');

            return $pdf->download('Laporan_Data_Anak_' . now()->format('Ymd_His') . '.pdf');
        }

        abort(400, 'Tipe export tidak valid.');
    }

    // public function print(Request $request)
    // {
    //     $data = $this->buildLaporanQuery($request)->get();
    //     return view('pages.laporan.print', compact('data'));
    // }

    private function buildLaporanQuery(Request $request)
    {
        $user = $request->user();
        $query = Anak::with(['alamatDomisili.kelurahan.kecamatan', 'orangTua']);

        if ($user->hasRole('pendamping')) {
            $query->whereHas('alamatDomisili', function ($q) use ($user) {
                $q->where('kelurahan_id', $user->kelurahan_id);
            });
        } elseif ($user->hasRole('kesra')) {
            $query->whereHas('alamatDomisili.kelurahan.kecamatan', function ($q) use ($user) {
                $q->where('kabupaten_id', $user->kabupaten_id);
            });
        }

        if ($request->filled('status_data')) {
            $query->where('status_data', $request->status_data);
        }

        return $query;
    }
}