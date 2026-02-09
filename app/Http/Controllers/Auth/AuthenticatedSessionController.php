<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = $request->user();

        // Log Login Activity
        \App\Models\ActivityLog::create([
            'user_id' => $user->id,
            'action' => 'login',
            'module' => 'Auth',
            'description' => 'User logged in',
            'ip_address' => $request->ip(),
        ]);

        if ($user->hasRole('Super Admin')) {
            return redirect()->intended(route('dashboard', absolute: false));
        } elseif ($user->hasRole('Admin')) {
            return redirect()->route('rekap-timbangan.index');
        } elseif ($user->hasRole('Kasir')) {
            return redirect()->route('penjualan.index');
        }

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        if (Auth::check()) {
            // Log Logout Activity
            \App\Models\ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => 'logout',
                'module' => 'Auth',
                'description' => 'User logged out',
                'ip_address' => $request->ip(),
            ]);
        }

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
