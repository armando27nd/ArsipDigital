<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Tampilkan form login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        // Validasi input username dan password
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            // Jika berhasil login, regenerate session agar aman
            $request->session()->regenerate();

            // Redirect ke halaman dashboard atau home
            return redirect()->intended('/');
        }

        // Jika gagal, kembalikan ke halaman login dengan error
        return back()->withErrors([
            'username' => 'Login gagal, username atau password salah.',
        ])->withInput($request->only('username'));
    }

    // Proses logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}