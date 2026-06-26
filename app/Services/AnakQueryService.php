<?php

namespace App\Services;

use App\Models\Anak;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class AnakQueryService
{
    public function visible(User $user): Builder
    {
        $query = Anak::query()
            ->with([
                'alamatDomisili.kelurahan',
                'orangTua',
                'wali',
            ]);

        if ($user->hasRole('pendamping')) {
            $query->whereHas(
                'alamatDomisili',
                fn ($q) =>
                $q->where(
                    'kelurahan_id',
                    $user->kelurahan_id
                )
            );
        }

        if ($user->hasRole('kecamatan')) {
            $query->whereHas(
                'alamatDomisili.kelurahan',
                fn ($q) =>
                $q->where(
                    'kecamatan_id',
                    $user->kecamatan_id
                )
            );
        }

        return $query;
    }

    public function pending(User $user): Builder
    {
        return $this->visible($user)
            ->where(
                'status_data',
                'Pending'
            );
    }
}