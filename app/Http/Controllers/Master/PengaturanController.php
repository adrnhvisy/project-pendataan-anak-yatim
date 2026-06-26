<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pengaturan\UpdatePengaturanRequest;
use App\Models\PengaturanSistem;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PengaturanController extends Controller
{
    public function index(): View
    {
        $pengaturan = PengaturanSistem::all();

        return view(
            'pages.pengaturan.index',
            compact('pengaturan')
        );
    }

    public function update(
        UpdatePengaturanRequest $request
    ): RedirectResponse {

        foreach ($request->pengaturan as $key => $value) {

            PengaturanSistem::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return redirect()
            ->back()
            ->with(
                'success',
                'Pengaturan berhasil diperbarui'
            );
    }
}