<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Provinsi;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WilayahController extends Controller
{
    public function index(Request $request)
    {
        $query = Kelurahan::with(['kecamatan.kabupaten.provinsi']);

        if ($request->filled('search')) {
            $query->where('nama_kelurahan', 'like', '%' . $request->search . '%');
        }

        $kelurahans = $query->latest()->paginate(15);
        return view('pages.wilayah.index', compact('kelurahans'));
    }

    public function create()
    {
        $kecamatans = Kecamatan::with('kabupaten.provinsi')->orderBy('nama_kecamatan')->get();
        return view('pages.wilayah.create', compact('kecamatans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kelurahan' => 'required|string|max:255',
            'kecamatan_id'   => 'required|exists:kecamatan,id',
            'kode_pos'       => 'nullable|string|max:10'
        ]);

        DB::transaction(function () use ($request) {
            $kelurahan = Kelurahan::create($request->all());

            AuditLog::create([
                'user_id' => auth()->id(),
                'module' => 'Wilayah',
                'action' => 'Create',
                'record_id' => $kelurahan->id,
                'description' => 'Menambahkan kelurahan: ' . $kelurahan->nama_kelurahan,
                'ip_address' => $request->ip()
            ]);
        });

        return redirect()->route('wilayah.index')->with('success', 'Kelurahan berhasil ditambahkan.');
    }

    public function edit(Kelurahan $wilayah)
    {
        $kecamatans = Kecamatan::with('kabupaten.provinsi')->orderBy('nama_kelurahan')->get();
        return view('pages.wilayah.edit', compact('wilayah', 'kecamatans'));
    }

    public function update(Request $request, Kelurahan $wilayah)
    {
        $request->validate([
            'nama_kelurahan' => 'required|string|max:255',
            'kecamatan_id'   => 'required|exists:kecamatan,id',
            'kode_pos'       => 'nullable|string|max:10'
        ]);

        DB::transaction(function () use ($request, $wilayah) {
            $wilayah->update($request->all());

            AuditLog::create([
                'user_id' => auth()->id(),
                'module' => 'Wilayah',
                'action' => 'Update',
                'record_id' => $wilayah->id,
                'description' => 'Memperbarui kelurahan: ' . $wilayah->nama_kelurahan,
                'ip_address' => $request->ip()
            ]);
        });

        return redirect()->route('wilayah.index')->with('success', 'Kelurahan berhasil diperbarui.');
    }

    public function destroy(Kelurahan $wilayah)
    {
        try {
            $nama = $wilayah->nama_kelurahan;
            $wilayah->delete();

            AuditLog::create([
                'user_id' => auth()->id(),
                'module' => 'Wilayah',
                'action' => 'Delete',
                'record_id' => $wilayah->id,
                'description' => 'Menghapus kelurahan: ' . $nama,
                'ip_address' => request()->ip()
            ]);

            return redirect()->route('wilayah.index')->with('success', 'Kelurahan berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Kelurahan tidak dapat dihapus karena masih digunakan.');
        }
    }
}