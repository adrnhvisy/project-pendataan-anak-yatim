<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\StoreWilayahRequest;
use App\Models\{Provinsi, Kabupaten, Kecamatan};
use App\Services\WilayahService;
use Illuminate\Http\{JsonResponse, RedirectResponse};
use Illuminate\View\View;

class WilayahController extends Controller
{
    public function __construct(protected WilayahService $wilayahService) {}

    public function index(): View {
        $provinsi = Provinsi::with('kabupaten.kecamatan.kelurahan')->paginate(15);
        return view('pages.wilayah.index', compact('provinsi'));
    }

    public function store(StoreWilayahRequest $request): RedirectResponse {
        $this->wilayahService->store($request->validated());
        return redirect()->route('master.wilayah.index')->with('success', 'Wilayah ditambahkan.');
    }

    // Metode AJAX untuk dropdown dinamis
    public function getKabupaten(Provinsi $provinsi): JsonResponse {
        return response()->json($provinsi->kabupaten);
    }

    public function getKecamatan(Kabupaten $kabupaten): JsonResponse {
        return response()->json($kabupaten->kecamatan);
    }

    public function getKelurahan(Kecamatan $kecamatan): JsonResponse {
        return response()->json($kecamatan->kelurahan);
    }
}