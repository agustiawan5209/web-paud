<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;
use App\Providers\RouteServiceProvider;
use App\Http\Requests\Auth\PhoneRequest;

class PhoneLoginController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/PhoneLogin', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(PhoneRequest $request): RedirectResponse
    {
        $user = User::where('phone', $request->no_telpon)->first();
        // dd($user->getRoleNames());
        if ($user && $user->hasRole('Orang Tua')) {
            Auth::login($user);
            $request->session()->regenerate();

            return redirect()->route('dashboard'); // Ganti dengan route sesuai kebutuhan Anda
        }

        return back()->withErrors([
            'no_telpon' => 'Nomor Telepon Tidak Cocok dengan data kami.',
        ]);

        return redirect()->intended(RouteServiceProvider::HOME);
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
