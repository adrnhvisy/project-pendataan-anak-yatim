<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Provinsi;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\AuditLog;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with(['roles', 'provinsi', 'kabupaten', 'kecamatan', 'kelurahan'])->latest()->paginate(10);
        return view('pages.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        $provinsi = Provinsi::all();
        $kabupaten = Kabupaten::all();
        $kecamatan = Kecamatan::all();
        $kelurahan = Kelurahan::all();

        return view('pages.users.create', compact('roles', 'provinsi', 'kabupaten', 'kecamatan', 'kelurahan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:' . User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'roles' => 'required|exists:roles,name',
            'is_active' => 'required|boolean',
            'provinsi_id' => 'nullable|exists:provinsi,id',
            'kabupaten_id' => 'nullable|exists:kabupaten,id',
            'kecamatan_id' => 'nullable|exists:kecamatan,id',
            'kelurahan_id' => 'nullable|exists:kelurahan,id',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_active' => $request->is_active,
            'provinsi_id' => $request->provinsi_id,
            'kabupaten_id' => $request->kabupaten_id,
            'kecamatan_id' => $request->kecamatan_id,
            'kelurahan_id' => $request->kelurahan_id,
        ]);

        $user->assignRole($request->roles);

        AuditLog::create([
            'user_id' => auth()->id(),
            'module' => 'User',
            'action' => 'Create',
            'record_id' => $user->id,
            'description' => 'Membuat user baru: ' . $user->email,
            'ip_address' => $request->ip()
        ]);

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function show(User $user)
    {
        $user->load(['roles', 'provinsi', 'kabupaten', 'kecamatan', 'kelurahan', 'auditLogs']);
        return view('pages.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        $provinsi = Provinsi::all();
        $kabupaten = Kabupaten::all();
        $kecamatan = Kecamatan::all();
        $kelurahan = Kelurahan::all();

        return view('pages.users.edit', compact('user', 'roles', 'provinsi', 'kabupaten', 'kecamatan', 'kelurahan'));
    }

    public function update(Request $request, User $user)
    {
        // 1. Validasi
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:users,email,' . $user->id,
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'roles' => 'required|exists:roles,name',
            'roles.*' => 'exists:roles,name',
            'is_active' => 'required|boolean',
            'provinsi_id' => 'nullable|exists:provinsi,id',
            'kabupaten_id' => 'nullable|exists:kabupaten,id',
            'kecamatan_id' => 'nullable|exists:kecamatan,id',
            'kelurahan_id' => 'nullable|exists:kelurahan,id',
        ]);

        // 2. Update data
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'is_active' => $request->is_active,
            'provinsi_id' => $request->provinsi_id,
            'kabupaten_id' => $request->kabupaten_id,
            'kecamatan_id' => $request->kecamatan_id,
            'kelurahan_id' => $request->kelurahan_id,
        ]);

        // 3. Update password jika ada
        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        // 4. Sync Roles (Gunakan array langsung)
        $user->syncRoles($request->roles);

        AuditLog::create([
            'user_id' => auth()->id(),
            'module' => 'User',
            'action' => 'Update',
            'record_id' => $user->id,
            'description' => 'Memperbarui data user: ' . $user->email,
            'ip_address' => $request->ip()
        ]);

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak dapat menghapus akun sendiri.');
        }

        $user->delete(); // Soft delete as per migration

        AuditLog::create([
            'user_id' => auth()->id(),
            'module' => 'User',
            'action' => 'Delete',
            'record_id' => $user->id,
            'description' => 'Menghapus (soft delete) user: ' . $user->email,
            'ip_address' => request()->ip()
        ]);

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil dinonaktifkan / dihapus.');
    }
}