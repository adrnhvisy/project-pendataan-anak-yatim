<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function store(array $data): User
    {
        return DB::transaction(function () use ($data) {

            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'provinsi_id' => $data['provinsi_id'] ?? null,
                'kabupaten_id' => $data['kabupaten_id'] ?? null,
                'kecamatan_id' => $data['kecamatan_id'] ?? null,
                'kelurahan_id' => $data['kelurahan_id'] ?? null,
                'is_active' => $data['is_active'] ?? true,
            ]);

            $user->syncRoles(
                $data['roles'] ?? []
            );

            return $user;
        });
    }

    public function update(
        User $user,
        array $data
    ): User {

        return DB::transaction(function () use ($user, $data) {

            if (!empty($data['password'])) {

                $data['password'] =
                    Hash::make($data['password']);
            } else {

                unset($data['password']);
            }

            $user->update($data);

            $user->syncRoles(
                $data['roles'] ?? []
            );

            return $user;
        });
    }

    public function delete(User $user): void
    {
        $user->delete();
    }
}