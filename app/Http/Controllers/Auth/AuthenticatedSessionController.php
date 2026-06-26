<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\AuditLogService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function __construct(
        protected AuditLogService $auditLogService
    ) {}

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
    public function store(
        LoginRequest $request
    ): RedirectResponse {

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
                'email' =>
                'Akun Anda tidak aktif. Hubungi administrator.',
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
        | Audit Log
        |--------------------------------------------------------------------------
        */

        $this->auditLogService->log(
            action: 'LOGIN',
            description: 'User berhasil login',
            module: 'AUTH',
            recordId: $user->id
        );

        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */

        return redirect()->intended(
            route('dashboard')
        );
    }

    /**
     * Logout
     */
    public function destroy(
        Request $request
    ): RedirectResponse {

        $userId = auth()->id();

        if ($userId) {

            $this->auditLogService->log(
                action: 'LOGOUT',
                description: 'User logout',
                module: 'AUTH',
                recordId: $userId
            );
        }

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}