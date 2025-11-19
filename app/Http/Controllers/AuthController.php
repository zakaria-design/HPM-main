<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // ✅ Validasi input
        $request->validate([
            'user_id' => 'required|exists:users,user_id',
            'password' => 'required',
        ]);

        // ✅ Login berdasarkan user_id dan password
        if (Auth::attempt(['user_id' => $request->user_id, 'password' => $request->password])) {
            $request->session()->regenerate();

            $role = Auth::user()->role;

            // ✅ Arahkan sesuai role
            return match ($role) {
                'direktur' => redirect()->route('pimpinan.dashboard.index'),
                'admin'    => redirect()->route('admin.dashboard.index'),
                'manager'  => redirect()->route('manager.dashboard.index'),
                'karyawan' => redirect()->route('karyawan.dashboard.index'),
                default    => tap(Auth::logout(), fn() => 
                                back()->withErrors(['role' => 'Role tidak dikenali.'])
                            ),
            };
        }

        // ❌ Jika gagal login
        return back()->withErrors([
            'user_id' => 'User ID atau password salah.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}