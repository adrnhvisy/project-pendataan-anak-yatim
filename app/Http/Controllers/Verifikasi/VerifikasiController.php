<?php

namespace App\Http\Controllers\Verifikasi;

use App\Http\Controllers\Controller;
use App\Http\Requests\Verifikasi\ApproveAnakRequest;
use App\Http\Requests\Verifikasi\RejectAnakRequest;
use App\Models\Anak;
use App\Services\VerifikasiService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class VerifikasiController extends Controller
{
    public function __construct(protected VerifikasiService $verifikasiService) {}

    public function index(): View {
        $pendingAnak = Anak::where('status_data', 'Pending')->paginate(15);
        return view('pages.verifikasi.index', compact('pendingAnak'));
    }

    public function show(Anak $anak): View {
        $anak->load(['alamatDomisili.kelurahan', 'orangTua', 'wali', 'dokumen']);
        return view('pages.verifikasi.show', compact('anak'));
    }

    public function approve(ApproveAnakRequest $request, Anak $anak): RedirectResponse {
        $this->verifikasiService->approve($anak, $request->catatan);
        return redirect()->route('verifikasi.index')->with('success', 'Data disetujui.');
    }

    public function reject(RejectAnakRequest $request, Anak $anak): RedirectResponse {
        $this->verifikasiService->reject($anak, $request->catatan);
        return redirect()->route('verifikasi.index')->with('success', 'Data ditolak.');
    }
}