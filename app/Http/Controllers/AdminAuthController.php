<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Petugas;

class AdminAuthController extends Controller
{
    /**
     * Tampilkan halaman login admin/petugas
     */
    public function showLogin()
    {
        return view('admin.login');
    }

    /**
     * Proses login admin / petugas
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Cari user berdasarkan username & password (plain text)
        $user = Petugas::where('username', $request->username)
                       ->where('password', $request->password)
                       ->first();

        if (!$user) {
            return back()->with('error', 'Username atau password salah');
        }

        // Login sesuai level
        if ($user->level === 'admin') {
            Auth::guard('admin')->login($user);
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }

        if ($user->level === 'petugas') {
            Auth::guard('petugas')->login($user);
            $request->session()->regenerate();
            return redirect()->route('petugas.dashboard');
        }

        return back()->with('error', 'Level user tidak valid');
    }

    /**
     * Logout admin / petugas
     */
    public function logout(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        } elseif (Auth::guard('petugas')->check()) {
            Auth::guard('petugas')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('success', 'Berhasil logout.');
    }
}
