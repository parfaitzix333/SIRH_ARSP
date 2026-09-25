<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\employe;
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

        $user = Auth::user();
        $employe = employe::where('user_id', $user->id)->first();

        if ($user->id === 1 || $user->role === 'DP') {
            return redirect()->route('accueil_dg');
        }
        if ($user->role === 'Suspendu') {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Votre compte est suspendu. Veuillez contacter l’administrateur.');
        }
        if ($user->role === 'SecDG') {
            return redirect()->route('accueil_secDg');
        }
        if ($user->role === 'Chef-Division') {
            return redirect()->route('accueil_cd');
        }
        if ($user->role === 'Chef-Service') {
            return redirect()->route('accueil_cs');
        } elseif ($user->role === 'Chef-Bureau1') {
            return redirect()->route('accueil_employe');
        } elseif ($user->role === 'Chef-Bureau2') {
            return redirect()->route('accueil_employe');
        } elseif ($user->role === 'Chef-Bureau3') {
            return redirect()->route('accueil_employe');
        } elseif ($employe) {
            return redirect()->route('accueil_employe');
        } else {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Votre compte n’est pas associé à un employé. Veuillez contacter l’administrateur.');
        }

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
