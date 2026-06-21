<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->latest()->paginate(15);
        return view('pages.superadmin.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        // Nanti kamu bisa menambahkan pemanggilan Model Kelurahan/Kecamatan di sini
        return view('pages.superadmin.users.form', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'role' => 'required|exists:roles,name'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_active' => true,
        ]);

        $user->assignRole($request->role);

        return redirect()->route('superadmin.users.index')->with('success', 'Akun berhasil dibuat.');
    }

    // (Metode edit, update, destroy sengaja aku ringkas untuk menghemat ruang, logikanya mirip dengan store namun menggunakan $user->update)
}