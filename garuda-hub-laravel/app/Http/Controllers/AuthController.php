<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

//NIM 252410102104
class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('projects.index');
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $throttleKey = Str::transliterate(
            Str::lower($request->input('email')) . '|' . $request->ip()
        );

        // Membatasi percobaan login maksimal 5 kali per menit.
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            throw ValidationException::withMessages([
                'email' => 'Terlalu banyak percobaan login. Silakan coba lagi nanti.',
            ]);
        }

        if (!Auth::attempt($credentials)) {
            RateLimiter::hit($throttleKey, 60);

            throw ValidationException::withMessages([
                'email' => 'Email atau password salah.',
            ]);
        }

        RateLimiter::clear($throttleKey);

        // Mengganti ID session setelah login untuk mencegah session fixation.
        $request->session()->regenerate();

        return redirect()->intended(route('projects.index'))
            ->with('success', 'Login berhasil.');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        // Menghapus session lama dan membuat token CSRF baru.
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Kamu berhasil logout.');
    }
}