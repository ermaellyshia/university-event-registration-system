<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    // FR1: Papar halaman login
    public function showLogin(): View|RedirectResponse
    {
        // Kalau dah login, terus ke dashboard ikut peranan
        if (Auth::check()) {
            return $this->redirectByRole();
        }

        return view('auth.login');
    }

    // FR1: Proses login
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();   // elak session fixation
            return $this->redirectByRole();
        }

        return back()
            ->withErrors(['username' => 'Invalid username or password.'])
            ->onlyInput('username');
    }

    // FR1: Logout
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();       // padam sesi lama
        $request->session()->regenerateToken();  // token CSRF baru

        return redirect()->route('login')->with('status', 'You have been logged out.');
    }

    // Hantar pengguna ke dashboard yang betul
    private function redirectByRole(): RedirectResponse
    {
        return Auth::user()->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('student.dashboard');
    }
}