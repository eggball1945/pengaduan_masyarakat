<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Masyarakat;
use App\Models\Pengaduan;

class AuthController extends Controller
{
    // Login Masyarakat
    public function login(Request $request)
    {
        $request->validate([
            'nik' => 'required',
            'password' => 'required'
        ]);

        $user = Masyarakat::where('nik', $request->nik)
            ->where('password', $request->password)
            ->first();

        if ($user) {
            Auth::guard('masyarakat')->login($user);
            $request->session()->regenerate();
            return redirect()->route('home')->with('success', 'Login berhasil');
        }

        return back()->with('error', 'NIK atau password salah')->withInput();
    }

    // Register Masyarakat
    public function register(Request $request)
    {
        $request->validate([
            'nik' => 'required|unique:tb_masyarakat,nik',
            'nama' => 'required',
            'username' => 'required|unique:tb_masyarakat,username',
            'password' => 'required|min:6',
            'telepon' => 'required',
        ]);

        Masyarakat::create([
            'nik' => $request->nik,
            'nama' => $request->nama,
            'username' => $request->username,
            'password' => $request->password, // TODO: gunakan Hash::make()
            'telepon' => $request->telepon
        ]);

        return back()->with('success', 'Registrasi berhasil, silakan login.');
    }

    // Logout (semua guard)
    public function logout(Request $request)
    {
        foreach (['masyarakat', 'petugas', 'admin'] as $guard) {
            if (Auth::guard($guard)->check()) {
                Auth::guard($guard)->logout();
            }
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('landing')->with('success', 'Berhasil logout');
    }

    // Halaman Data Pengaduan
    public function index()
    {
        if (Auth::guard('masyarakat')->check() || Auth::guard('petugas')->check() || Auth::guard('admin')->check()) {
            // Semua role bisa lihat semua pengaduan
            $pengaduans = Pengaduan::with('masyarakat')
                ->orderBy('tgl_pengaduan', 'desc')
                ->get();
        } else {
            return redirect()->route('')->with('error', 'Silakan login terlebih dahulu');
        }

        return view('pengaduan.index', compact('pengaduans'));
    }
}
