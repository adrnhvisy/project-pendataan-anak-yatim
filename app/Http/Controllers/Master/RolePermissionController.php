<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionController extends Controller
{
    public function index(): View
    {
        $roles = Role::with('permissions')
            ->paginate(20);

        return view(
            'pages.roles.index',
            compact('roles')
        );
    }

    public function permissions(Role $role)
    {
        $permissions = \Spatie\Permission\Models\Permission::all();
        return view('pages.roles.permissions', compact('role', 'permissions'));
    }

    public function create(): View
    {
        return view('pages.roles.create', [
            'permissions' => Permission::all()
        ]);
    }

    public function store(
        Request $request
    ): RedirectResponse {

        $role = Role::create([
            'name' => $request->name
        ]);

        $role->syncPermissions(
            $request->permissions ?? []
        );

        return redirect()
            ->route('roles.index')
            ->with('success', 'Role berhasil dibuat');
    }

    public function edit(
        Role $role
    ): View {

        return view('pages.roles.edit', [
            'role' => $role->load('permissions'),
            'permissions' => Permission::all(),
        ]);
    }

    public function update(
        Request $request,
        Role $role
    ): RedirectResponse {

        $role->update([
            'name' => $request->name
        ]);

        $role->syncPermissions(
            $request->permissions ?? []
        );

        return redirect()
            ->route('roles.index')
            ->with('success', 'Role berhasil diperbarui');
    }

    public function destroy(
        Role $role
    ): RedirectResponse {

        $role->delete();

        return redirect()
            ->route('roles.index')
            ->with('success', 'Role berhasil dihapus');
    }
}