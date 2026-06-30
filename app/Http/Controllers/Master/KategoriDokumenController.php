<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\KategoriDokumen;
use App\Models\AuditLog;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KategoriDokumenController extends Controller
{
    public function index()
    {
        $kategori = KategoriDokumen::withCount('dokumenAnak')->latest()->paginate(15);
        return view('pages.kategori-dokumen.index', compact('kategori'));
    }

    public function create()
    {
        return view('pages.kategori-dokumen.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_dokumen' => 'required|string|max:255|unique:kategori_dokumen,nama_dokumen',
            'is_wajib' => 'boolean',
        ]);

        DB::transaction(function () use ($request) {
            $data = KategoriDokumen::create([
                'nama_dokumen' => $request->nama_dokumen,
                'is_wajib' => $request->has('is_wajib'),
            ]);

            AuditLog::create([
                'user_id' => auth()->id(),
                'module' => 'Kategori Dokumen',
                'action' => 'Create',
                'record_id' => $data->id,
                'description' => 'Menambah kategori dokumen: ' . $data->nama_dokumen,
                'ip_address' => $request->ip()
            ]);
        });

        return redirect()->route('kategori-dokumen.index')->with('success', 'Kategori dokumen berhasil ditambahkan.');
    }

    public function edit(KategoriDokumen $kategoriDokumen)
    {
        return view('pages.kategori-dokumen.edit', compact('kategoriDokumen'));
    }

    public function update(Request $request, KategoriDokumen $kategoriDokumen)
    {
        $request->validate([
            'nama_dokumen' => 'required|string|max:255|unique:kategori_dokumen,nama_dokumen,' . $kategoriDokumen->id,
            'is_wajib' => 'boolean',
        ]);

        DB::transaction(function () use ($request, $kategoriDokumen) {
            $kategoriDokumen->update([
                'nama_dokumen' => $request->nama_dokumen,
                'is_wajib' => $request->has('is_wajib'),
            ]);

            AuditLog::create([
                'user_id' => auth()->id(),
                'module' => 'Kategori Dokumen',
                'action' => 'Update',
                'record_id' => $kategoriDokumen->id,
                'description' => 'Mengubah kategori dokumen: ' . $kategoriDokumen->nama_dokumen,
                'ip_address' => $request->ip()
            ]);
        });

        return redirect()->route('kategori-dokumen.index')->with('success', 'Kategori dokumen berhasil diperbarui.');
    }

    public function destroy(KategoriDokumen $kategoriDokumen)
    {
        // 1. Cek Constraint (Business Logic)
        if ($kategoriDokumen->dokumenAnak()->exists()) {
            return back()->with('error', 'Kategori tidak dapat dihapus karena masih digunakan oleh dokumen anak.');
        }

        // 2. Transaksi Database
        DB::transaction(function () use ($kategoriDokumen) {
            // Karena binding sudah benar, $kategoriDokumen->nama_dokumen sekarang ada isinya (bukan null)
            $nama = $kategoriDokumen->nama_dokumen;

            // 3. Hard Delete
            $isDeleted = $kategoriDokumen->delete();

            if (!$isDeleted) {
                throw new Exception("Gagal menghapus model.");
            }

            // 4. Audit Log
            AuditLog::create([
                'user_id' => auth()->id(),
                'module' => 'Kategori Dokumen',
                'action' => 'Delete',
                'record_id' => null,
                'description' => 'Menghapus kategori dokumen: ' . $nama,
                'ip_address' => request()->ip()
            ]);
        });

        return redirect()->route('kategori-dokumen.index')->with('success', 'Kategori dokumen berhasil dihapus secara permanen.');
    }
}