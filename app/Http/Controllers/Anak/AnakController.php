<?php

namespace App\Http\Controllers\Anak;

use App\Http\Controllers\Controller;

use App\Http\Requests\Anak\StoreAnakRequest;
use App\Http\Requests\Anak\UpdateAnakRequest;

use App\Models\Anak;
use App\Models\Kelurahan;

use App\Services\AnakService;
use App\Services\AnakQueryService;
use App\Services\AuditLogService;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AnakController extends Controller
{
    public function __construct(
        protected AnakService $anakService,
        protected AnakQueryService $anakQueryService,
        protected AuditLogService $auditLogService
    ) {
    }

    public function index(Request $request): View
    {
        $user = auth()->user();
        $query = $this->anakQueryService->visible($user);

        // 1. Hitung Statistik (Clone query agar tidak terpengaruh filter paginate nanti)
        $stats = [
            'total' => (clone $query)->count(),
            'pending' => (clone $query)->where('status_data', 'Pending')->count(),
            'disetujui' => (clone $query)->where('status_data', 'Disetujui')->count(),
            'ditolak' => (clone $query)->where('status_data', 'Ditolak')->count(),
        ];

        // 2. Filter Pencarian Teks (Nama, NIK, No Registrasi)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                    ->orWhere('nik', 'like', "%{$search}%")
                    ->orWhere('no_registrasi', 'like', "%{$search}%");
            });
        }

        // 3. Filter Status Data & Status Anak
        if ($request->filled('status_data')) {
            $query->where('status_data', $request->status_data);
        }
        if ($request->filled('status_anak')) {
            $query->where('status_anak', $request->status_anak);
        }

        // 4. Filter Kelurahan (Abaikan jika role pendamping, karena sudah terfilter di QueryService)
        if ($request->filled('kelurahan_id') && !$user->hasRole('pendamping')) {
            $query->whereHas('alamatDomisili', function ($q) use ($request) {
                $q->where('kelurahan_id', $request->kelurahan_id);
            });
        }

        // 5. Eksekusi Query utama dengan relasi
        $anak = $query->with(['alamatDomisili.kelurahan', 'dokumen'])
            ->latest()
            ->paginate(15)
            ->withQueryString(); // Mempertahankan parameter filter di URL saat pindah halaman

        // Ambil daftar kelurahan untuk dropdown filter (kecuali untuk pendamping)
        $kelurahanList = [];
        if (!$user->hasRole('pendamping')) {
            $kelurahanList = Kelurahan::orderBy('nama_kelurahan')->get();
        }

        return view('pages.anak.index', compact('anak', 'stats', 'kelurahanList'));
    }

    public function create(): View
    {
        $kelurahan = Kelurahan::orderBy(
            'nama_kelurahan'
        )->get();

        return view(
            'pages.anak.create',
            compact('kelurahan')
        );
    }

    public function store(
        StoreAnakRequest $request
    ): RedirectResponse {

        $anak = $this->anakService->store(
            $request->validated()
        );

        $this->auditLogService->log(
            'CREATE',
            'Menambahkan data anak',
            'ANAK',
            $anak->id
        );

        return redirect()
            ->route(
                'anak.show',
                $anak->id
            )
            ->with(
                'success',
                'Data anak berhasil ditambahkan.'
            );
    }

    public function show(
        Anak $anak
    ): View {

        $anak->load([
            'alamatDomisili.kelurahan.kecamatan.kabupaten.provinsi',
            'orangTua',
            'wali',
            'dokumen.kategoriDokumen',
            'historiStatus'
        ]);

        return view(
            'pages.anak.show',
            compact('anak')
        );
    }

    public function edit(
        Anak $anak
    ): View {

        $kelurahan = Kelurahan::orderBy(
            'nama_kelurahan'
        )->get();

        return view(
            'pages.anak.edit',
            compact(
                'anak',
                'kelurahan'
            )
        );
    }

    public function update(
        UpdateAnakRequest $request,
        Anak $anak
    ): RedirectResponse {

        $this->anakService->update(
            $anak,
            $request->validated()
        );

        $this->auditLogService->log(
            'UPDATE',
            'Mengubah data anak',
            'ANAK',
            $anak->id
        );

        return redirect()
            ->route(
                'anak.show',
                $anak->id
            )
            ->with(
                'success',
                'Data anak berhasil diperbarui.'
            );
    }

    public function destroy(
        Anak $anak
    ): RedirectResponse {

        $nama = $anak->nama_lengkap;

        $anak->delete();

        $this->auditLogService->log(
            'DELETE',
            "Menghapus data anak {$nama}",
            'ANAK',
            $anak->id
        );

        return redirect()
            ->route('anak.index')
            ->with(
                'success',
                'Data anak berhasil dihapus.'
            );
    }
}