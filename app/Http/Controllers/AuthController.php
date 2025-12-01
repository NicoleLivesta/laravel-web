<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman login.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('auth.login');
    }

    /**
     * Memproses permintaan login.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        // PERBAIKAN SINTAKSIS: Validasi dipisahkan dan diformat dengan benar.
        $input = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($input)) {
            $request->session()->regenerate();

            // Cek Role User yang sedang login menggunakan helper auth()
            if (auth()->user()->hasRole('admin')) {
                // Arahkan Admin
                return redirect()->intended('/admin/dashboard');
            }

            // Arahkan User Biasa jika bukan admin
            return redirect()->intended('/dashboard');
        }

        // Jika Login Gagal
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    /**
     * Proses Logout.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
