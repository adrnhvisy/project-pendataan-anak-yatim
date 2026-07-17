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
        $type = $request->query('type', 'kelurahan'); // Default ke kelurahan jika tidak ada pilihan
        $data = [];

        switch ($type) {
            case 'provinsi':
                $data = Provinsi::latest()->paginate(15);
                break;
            case 'kabupaten':
                $data = Kabupaten::with('provinsi')->latest()->paginate(15);
                break;
            case 'kecamatan':
                $data = Kecamatan::with('kabupaten.provinsi')->latest()->paginate(15);
                break;
            case 'kelurahan':
            default:
                $data = Kelurahan::with('kecamatan.kabupaten.provinsi')->latest()->paginate(15);
                break;
        }

        return view('pages.wilayah.index', compact('data', 'type'));
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
            'kecamatan_id' => 'required|exists:kecamatan,id',
            'kode_pos' => 'nullable|string|max:10'
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
    // ==========================================
    // BAGIAN PROVINSI
    // ==========================================
    public function createProvinsi()
    {
        return view('pages.wilayah.create_provinsi');
    }

    public function storeProvinsi(Request $request)
    {
        $request->validate([
            'nama_provinsi' => 'required|string|max:255|unique:provinsi,nama_provinsi',
        ]);

        DB::transaction(function () use ($request) {
            $provinsi = Provinsi::create($request->only('nama_provinsi'));

            AuditLog::create([
                'user_id' => auth()->id(),
                'module' => 'Wilayah',
                'action' => 'Create',
                'record_id' => $provinsi->id,
                'description' => 'Menambahkan provinsi: ' . $provinsi->nama_provinsi,
                'ip_address' => $request->ip()
            ]);
        });

        return redirect()->route('wilayah.index')->with('success', 'Provinsi berhasil ditambahkan.');
    }

    // ==========================================
    // BAGIAN KECAMATAN
    // ==========================================
    public function createKecamatan()
    {
        // Asumsi: Kecamatan terhubung ke Kabupaten, jadi kita perlu daftar Kabupaten untuk form-nya
        $kabupatens = Kabupaten::with('provinsi')->orderBy('nama_kabupaten')->get();
        return view('pages.wilayah.create_kecamatan', compact('kabupatens'));
    }

    public function storeKecamatan(Request $request)
    {
        $request->validate([
            'nama_kecamatan' => 'required|string|max:255',
            'kabupaten_id' => 'required|exists:kabupaten,id',
        ]);

        DB::transaction(function () use ($request) {
            $kecamatan = Kecamatan::create($request->only('nama_kecamatan', 'kabupaten_id'));

            AuditLog::create([
                'user_id' => auth()->id(),
                'module' => 'Wilayah',
                'action' => 'Create',
                'record_id' => $kecamatan->id,
                'description' => 'Menambahkan kecamatan: ' . $kecamatan->nama_kecamatan,
                'ip_address' => $request->ip()
            ]);
        });

        return redirect()->route('wilayah.index')->with('success', 'Kecamatan berhasil ditambahkan.');
    }

    // ==========================================
    // BAGIAN KABUPATEN
    // ==========================================
    public function createKabupaten()
    {
        $provinsis = Provinsi::orderBy('nama_provinsi')->get();
        return view('pages.wilayah.create_kabupaten', compact('provinsis'));
    }

    public function storeKabupaten(Request $request)
    {
        $request->validate([
            'nama_kabupaten' => 'required|string|max:255',
            'provinsi_id' => 'required|exists:provinsi,id',
        ]);

        DB::transaction(function () use ($request) {
            $kabupaten = Kabupaten::create($request->only('nama_kabupaten', 'provinsi_id'));

            AuditLog::create([
                'user_id' => auth()->id(),
                'module' => 'Wilayah',
                'action' => 'Create',
                'record_id' => $kabupaten->id,
                'description' => 'Menambahkan kabupaten: ' . $kabupaten->nama_kabupaten,
                'ip_address' => $request->ip()
            ]);
        });

        return redirect()->route('wilayah.index')->with('success', 'Kabupaten berhasil ditambahkan.');
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
            'kecamatan_id' => 'required|exists:kecamatan,id',
            'kode_pos' => 'nullable|string|max:10'
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

    // ==========================================
    // PROVINSI: EDIT, UPDATE, DESTROY
    // ==========================================
    public function editProvinsi($id)
    {
        $wilayah = Provinsi::findOrFail($id);
        return view('pages.wilayah.edit_provinsi', compact('wilayah'));
    }

    public function updateProvinsi(Request $request, $id)
    {
        $request->validate(['nama_provinsi' => 'required|string|max:255']);
        $provinsi = Provinsi::findOrFail($id);

        DB::transaction(function () use ($request, $provinsi) {
            $provinsi->update($request->only('nama_provinsi'));
            AuditLog::create([
                'user_id' => auth()->id(),
                'module' => 'Wilayah',
                'action' => 'Update',
                'record_id' => $provinsi->id,
                'description' => 'Memperbarui provinsi: ' . $provinsi->nama_provinsi,
                'ip_address' => $request->ip()
            ]);
        });

        return redirect()->route('wilayah.index', ['type' => 'provinsi'])->with('success', 'Provinsi berhasil diperbarui.');
    }

    public function destroyProvinsi($id)
    {
        $provinsi = Provinsi::findOrFail($id);
        $provinsi->delete();
        return redirect()->route('wilayah.index', ['type' => 'provinsi'])->with('success', 'Provinsi berhasil dihapus.');
    }

    // ==========================================
    // KABUPATEN: EDIT, UPDATE, DESTROY
    // ==========================================
    public function editKabupaten($id)
    {
        $wilayah = Kabupaten::findOrFail($id);
        $provinsis = Provinsi::orderBy('nama_provinsi')->get();
        return view('pages.wilayah.edit_kabupaten', compact('wilayah', 'provinsis'));
    }

    public function updateKabupaten(Request $request, $id)
    {
        $request->validate([
            'nama_kabupaten' => 'required|string|max:255',
            'provinsi_id' => 'required|exists:provinsi,id'
        ]);
        $kabupaten = Kabupaten::findOrFail($id);

        DB::transaction(function () use ($request, $kabupaten) {
            $kabupaten->update($request->only('nama_kabupaten', 'provinsi_id'));
            AuditLog::create([
                'user_id' => auth()->id(),
                'module' => 'Wilayah',
                'action' => 'Update',
                'record_id' => $kabupaten->id,
                'description' => 'Memperbarui kabupaten: ' . $kabupaten->nama_kabupaten,
                'ip_address' => $request->ip()
            ]);
        });

        return redirect()->route('wilayah.index', ['type' => 'kabupaten'])->with('success', 'Kabupaten berhasil diperbarui.');
    }

    public function destroyKabupaten($id)
    {
        Kabupaten::findOrFail($id)->delete();
        return redirect()->route('wilayah.index', ['type' => 'kabupaten'])->with('success', 'Kabupaten berhasil dihapus.');
    }

    // ==========================================
    // KECAMATAN: EDIT, UPDATE, DESTROY
    // ==========================================
    public function editKecamatan($id)
    {
        $wilayah = Kecamatan::findOrFail($id);
        $kabupatens = Kabupaten::orderBy('nama_kabupaten')->get();
        return view('pages.wilayah.edit_kecamatan', compact('wilayah', 'kabupatens'));
    }

    public function updateKecamatan(Request $request, $id)
    {
        $request->validate([
            'nama_kecamatan' => 'required|string|max:255',
            'kabupaten_id' => 'required|exists:kabupaten,id'
        ]);
        $kecamatan = Kecamatan::findOrFail($id);

        DB::transaction(function () use ($request, $kecamatan) {
            $kecamatan->update($request->only('nama_kecamatan', 'kabupaten_id'));
            AuditLog::create([
                'user_id' => auth()->id(),
                'module' => 'Wilayah',
                'action' => 'Update',
                'record_id' => $kecamatan->id,
                'description' => 'Memperbarui kecamatan: ' . $kecamatan->nama_kecamatan,
                'ip_address' => $request->ip()
            ]);
        });

        return redirect()->route('wilayah.index', ['type' => 'kecamatan'])->with('success', 'Kecamatan berhasil diperbarui.');
    }

    public function destroyKecamatan($id)
    {
        Kecamatan::findOrFail($id)->delete();
        return redirect()->route('wilayah.index', ['type' => 'kecamatan'])->with('success', 'Kecamatan berhasil dihapus.');
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