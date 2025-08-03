<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Petugas;
use App\Models\Pengaduan;

class AdminController extends Controller
{
    public function index()
    {
        $pengaduan = Pengaduan::with(['tanggapan.petugas'])->get();
        return view('admin', compact('pengaduan'));
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::guard('petugas')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('admin.home')->with('success', 'Login berhasil');
        }

        return redirect()->route('admin.home')->with('error', 'Login gagal');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama_petugas' => 'required',
            'username' => 'required|unique:tb_petugas,username',
            'password' => 'required',
            'telepon' => 'required',
            'level' => 'required|in:admin,petugas',
        ]);

        $user = Petugas::create([
            'nama_petugas' => $request->nama_petugas,
            'username' => $request->username,
            'password' => bcrypt($request->password), // HARUS pakai bcrypt!
            'telepon' => $request->telepon,
            'level' => $request->level,
        ]);

        Auth::guard('petugas')->login($user);

        return redirect()->route('admin.home');
    }

    public function logout(Request $request)
    {
        Auth::guard('petugas')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.home');
    }

    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function generateLaporan()
    {
        // logika generate laporan
    }

    public function verifikasi()
    {
        // logika verifikasi pengaduan
    }

    public function tanggapan()
    {
        // logika tanggapan
    }
}

