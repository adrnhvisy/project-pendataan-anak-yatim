<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\AuditLog; // Menggunakan model langsung
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Tampilkan halaman login
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Proses login
     */
    public function store(LoginRequest $request): RedirectResponse 
    {
        $request->authenticate();

        $user = $request->user();

        /*
        |--------------------------------------------------------------------------
        | Cek Status Aktif
        |--------------------------------------------------------------------------
        */

        if (!$user->is_active) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()->withErrors([
                'email' => 'Akun Anda tidak aktif. Hubungi administrator.',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Regenerate Session
        |--------------------------------------------------------------------------
        */

        $request->session()->regenerate();

        /*
        |--------------------------------------------------------------------------
        | Audit Log (Langsung via Model)
        |--------------------------------------------------------------------------
        */

        AuditLog::create([
            'user_id'     => $user->id,
            'module'      => 'AUTH',
            'action'      => 'LOGIN',
            'record_id'   => $user->id,
            'description' => 'User berhasil login',
            'ip_address'  => $request->ip()
        ]);

        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */

        return redirect()->intended(route('dashboard'));
    }

    /**
     * Logout
     */
    public function destroy(Request $request): RedirectResponse 
    {
        $userId = auth()->id();

        if ($userId) {
            AuditLog::create([
                'user_id'     => $userId,
                'module'      => 'AUTH',
                'action'      => 'LOGOUT',
                'record_id'   => $userId,
                'description' => 'User logout',
                'ip_address'  => $request->ip()
            ]);
        }

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}