<?php

namespace App\Http\Controllers\Anak;

use App\Http\Controllers\Controller;

use App\Http\Requests\Dokumen\UploadDokumenRequest;

use App\Models\Anak;
use App\Models\DokumenAnak;
use App\Models\KategoriDokumen;

use App\Services\DokumenService;
use App\Services\AuditLogService;
use App\Services\AnakQueryService;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AnakDokumenController extends Controller
{
    public function __construct(
        protected DokumenService $dokumenService,
        protected AuditLogService $auditLogService,
        protected AnakQueryService $anakQueryService
    ) {}

    public function index(
        Anak $anak
    ): View {

        $this->authorizeAnak($anak);

        $dokumen = $anak->dokumen()
            ->with([
                'kategoriDokumen'
            ])
            ->latest()
            ->get();

        return view(
            'pages.anak.dokumen.index',
            compact(
                'anak',
                'dokumen'
            )
        );
    }

    public function create(
        Anak $anak
    ): View {

        $this->authorizeAnak($anak);

        $kategoriDokumen = KategoriDokumen::orderBy(
            'nama_dokumen'
        )->get();

        return view(
            'pages.anak.dokumen.upload',
            compact(
                'anak',
                'kategoriDokumen'
            )
        );
    }

    public function store(
        UploadDokumenRequest $request,
        Anak $anak
    ): RedirectResponse {

        $this->authorizeAnak($anak);

        $dokumen = $this->dokumenService->upload(
            $anak->id,
            $request->kategori_dok_id,
            $request->file('dokumen')
        );

        $this->auditLogService->log(
            'UPLOAD',
            'Upload dokumen anak',
            'DOKUMEN',
            $dokumen->id
        );

        return redirect()
            ->route(
                'anak.dokumen.index',
                $anak->id
            )
            ->with(
                'success',
                'Dokumen berhasil diupload.'
            );
    }

    public function destroy(
        DokumenAnak $dokumen
    ): RedirectResponse {

        $anak = $dokumen->anak;

        $this->authorizeAnak($anak);

        $this->dokumenService->delete(
            $dokumen
        );

        $this->auditLogService->log(
            'DELETE',
            'Menghapus dokumen anak',
            'DOKUMEN',
            $dokumen->id
        );

        return redirect()
            ->route(
                'anak.dokumen.index',
                $anak->id
            )
            ->with(
                'success',
                'Dokumen berhasil dihapus.'
            );
    }

    private function authorizeAnak(
        Anak $anak
    ): void {

        abort_unless(
            $this->anakQueryService
                ->visible(auth()->user())
                ->where('id', $anak->id)
                ->exists(),
            403
        );
    }
}