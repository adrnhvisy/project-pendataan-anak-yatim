<?php

namespace App\Http\Controllers;

use App\Models\Provinsi; // Pastikan Model-model ini sudah ada
use Illuminate\Http\Request;

class WilayahController extends Controller
{
    public function index()
    {
        $provinsi = \App\Models\Provinsi::with('kabupaten.kecamatan.kelurahan')->get();
        
        return view('pages.superadmin.wilayah.index', compact('provinsi'));
    }
}