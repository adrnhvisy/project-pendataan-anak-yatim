<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\StoreUserRequest;
use App\Http\Requests\Master\UpdateUserRequest;
use App\Models\User;
use App\Models\Provinsi;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(): View
    {
        $users = User::with([
            'roles',
            'provinsi',
            'kabupaten',
            'kecamatan',
            'kelurahan'
        ])
        ->latest()
        ->paginate(15);

        return view('pages.users.index', compact('users'));
    }

    public function create(): View
    {
        return view('pages.users.create', [
            'roles' => Role::all(),
            'provinsi' => Provinsi::all(),
            'kabupaten' => Kabupaten::all(),
            'kecamatan' => Kecamatan::all(),
            'kelurahan' => Kelurahan::all(),
        ]);
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'provinsi_id' => $request->provinsi_id,
            'kabupaten_id' => $request->kabupaten_id,
            'kecamatan_id' => $request->kecamatan_id,
            'kelurahan_id' => $request->kelurahan_id,
            'is_active' => true,
        ]);

        $user->syncRoles($request->roles);

        return redirect()
            ->route('users.index')
            ->with('success', 'User berhasil dibuat');
    }

    public function show(User $user): View
    {
        $user->load([
            'roles',
            'provinsi',
            'kabupaten',
            'kecamatan',
            'kelurahan'
        ]);

        return view('pages.users.show', compact('user'));
    }

    public function edit(User $user): View
    {
        return view('pages.users.edit', [
            'user' => $user,
            'roles' => Role::all(),
            'provinsi' => Provinsi::all(),
            'kabupaten' => Kabupaten::all(),
            'kecamatan' => Kecamatan::all(),
            'kelurahan' => Kelurahan::all(),
        ]);
    }

    public function update(
        UpdateUserRequest $request,
        User $user
    ): RedirectResponse {

        $user->update($request->validated());

        $user->syncRoles($request->roles);

        return redirect()
            ->route('users.index')
            ->with('success', 'User berhasil diperbarui');
    }

    public function destroy(
        User $user
    ): RedirectResponse {

        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('success', 'User berhasil dihapus');
    }
}