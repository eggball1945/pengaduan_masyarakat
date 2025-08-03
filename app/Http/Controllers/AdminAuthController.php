<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AdminAuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

    $credentials = $request->only('username', 'password');

    dd(Auth::guard('petugas')->attempt($credentials));

    if (Auth::guard('petugas')->attempt($credentials)) {
        $request->session()->regenerate();

        $petugas = Auth::guard('petugas')->user();
        if ($petugas->level === 'admin' || $petugas->level === 'petugas') {
            return redirect()->route('admin.dashboard')->with('success', 'Login admin berhasil!');
        } else {
            Auth::guard('petugas')->logout();
            return redirect('/')->with('error', 'Akses ditolak. Anda bukan admin/petugas.');
        }
    }

    return redirect('admin.dashboard')->with('error', 'Username atau password admin salah.');
}

    public function dashboard()
    {
        return view('admin.dashboard');
    }
}
