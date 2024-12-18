<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Show the login form.
     */
    public function index()
    {
        return view('login');
    }

    /**
     * Handle an authentication attempt.
     */
    public function authenticate(Request $request): RedirectResponse
    {
        // Validasi input login
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Percobaan autentikasi menggunakan kredensial yang diberikan
        if (Auth::attempt($credentials)) {
            // Regenerasi sesi untuk melindungi dari serangan fixation
            $request->session()->regenerate();

            // Dapatkan peran pengguna saat ini
            $user = Auth::user();

            // Redirect berdasarkan peran pengguna
            if ($user->role === 'customer') {
                return redirect()->route('customer.home')->with('success', 'Welcome ' . $user->name);
            } elseif (in_array($user->role, ['admin', 'super_admin', 'kurir'])) {
                return redirect()->route('dashboard.index')->with('success', 'Welcome ' . $user->name);
            }

            // Default redirect jika peran tidak dikenal
            return redirect()->intended('home')->with('success', 'Welcome ' . $user->name);
        }

        // Kembali ke halaman login dengan pesan error jika autentikasi gagal
        return back()->withErrors([
            'email' => 'Email atau password yang dimasukkan tidak cocok.',
        ])->withInput($request->only('email'));
    }

    /**
     * Handle logout and session cleanup.
     */
    public function logout(Request $request): RedirectResponse
    {
        // Logout pengguna yang sedang login
        Auth::logout();

        // Invalidasi sesi saat ini
        $request->session()->invalidate();

        // Regenerasi token CSRF
        $request->session()->regenerateToken();

        // Redirect ke halaman utama setelah logout dengan pesan sukses
        return redirect('/home')->with('success', 'Anda telah berhasil logout.');
    }


}
