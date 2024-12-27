<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login() {
        return view('pages.login');
    }

    public function postLogin(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Cek kredensial pengguna
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->role == 'admin') {
                return redirect()->route('produk')->with('success', 'Anda berhasil login'); // Halaman Admin
            } elseif ($user->role == 'kasir') {
                return redirect()->route('pembelian')->with('success', 'Anda berhasil login'); // Halaman Kasir
            } else {
                return redirect()->route('labaKeuntungan')->with('success', 'Anda berhasil login'); // Halaman User biasa
            }
        }

        // Jika login gagal
        return back()->with('error', 'Username atau password salah!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('')->with('success', 'Anda berhasil logout');
    }
}
