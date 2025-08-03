<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Masyarakat;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect('/')->with('success', 'Berhasil login!');
        }

        return redirect('/')->with('error', 'Username atau password salah.');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nik' => 'required|unique:tb_masyarakat,nik',
            'nama' => 'required|string',
            'username' => 'required|string|unique:tb_masyarakat,username',
            'password' => 'required|string|min:6',
            'telepon' => 'required|string',
        ]);

        $user = Masyarakat::create([
            'nik' => $request->nik,
            'nama' => $request->nama,
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'telepon' => $request->telepon,
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect('/')->with('success', 'Berhasil register dan login.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Berhasil logout.');
    }
}
