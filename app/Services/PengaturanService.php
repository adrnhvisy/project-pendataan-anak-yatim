<?php

namespace App\Services;

use App\Models\PengaturanSistem;
use Illuminate\Support\Facades\DB;

class PengaturanService
{
    public function update(
        array $settings
    ): void {

        DB::transaction(function () use ($settings) {

            foreach ($settings as $key => $value) {

                PengaturanSistem::updateOrCreate(
                    [
                        'key' => $key,
                    ],
                    [
                        'value' => $value,
                    ]
                );
            }
        });
    }
}