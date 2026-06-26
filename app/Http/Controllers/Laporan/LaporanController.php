<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Models\Anak;
use Illuminate\View\View;

class LaporanController extends Controller
{
    public function anak(): View {
        // Logika report anak
        return view('pages.laporan.anak');
    }

    public function bantuan(): View {
        return view('pages.laporan.bantuan');
    }
    
    public function wilayah(): View {
        return view('pages.laporan.wilayah');
    }
}