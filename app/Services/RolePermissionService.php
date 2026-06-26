<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class RolePermissionService
{
    public function store(array $data): Role
    {
        return DB::transaction(function () use ($data) {

            $role = Role::create([
                'name' => $data['name'],
            ]);

            $role->syncPermissions(
                $data['permissions'] ?? []
            );

            return $role;
        });
    }

    public function update(
        Role $role,
        array $data
    ): Role {

        return DB::transaction(function () use ($role, $data) {

            $role->update([
                'name' => $data['name'],
            ]);

            $role->syncPermissions(
                $data['permissions'] ?? []
            );

            return $role;
        });
    }

    public function delete(Role $role): void
    {
        $role->delete();
    }
}