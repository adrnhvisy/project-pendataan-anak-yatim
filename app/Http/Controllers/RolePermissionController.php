<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RolePermissionController extends Controller
{
    public function index() 
    {
        $roles = Role::with('permissions')->get();
        return view('pages.superadmin.roles.index', compact('roles')); 
    }

    // 1. Method untuk menampilkan halaman form tambah role
    public function create()
    {
        return view('pages.superadmin.roles.form');
    }

    // 2. Method untuk memproses data dari form dan menyimpannya ke database
    public function store(Request $request)
    {
        // Validasi input: Nama role wajib diisi, berupa teks, dan tidak boleh kembar
        $request->validate([
            'name' => 'required|string|unique:roles,name|max:255'
        ]);

        // Simpan ke database (Spatie Permission)
        // Kita gunakan strtolower agar nama role seragam huruf kecil semua
        Role::create(['name' => strtolower($request->name)]);

        // Arahkan kembali ke tabel daftar role dengan pesan sukses
        return redirect()->route('superadmin.roles.index')->with('success', 'Role baru berhasil ditambahkan!');
    }
}