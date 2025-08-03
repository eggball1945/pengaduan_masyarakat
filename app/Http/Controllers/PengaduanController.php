<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pengaduan;

class PengaduanController extends Controller
{
    public function create()
    {
        return view('pengaduan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'isi_laporan' => 'required|string',
            'foto' => 'nullable|image|max:2048',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('pengaduan_foto', 'public');
        }

        $user = Auth::user();

        Pengaduan::create([
            'nik' => $user->nik,
            'isi_laporan' => $request->isi_laporan,
            'foto' => $fotoPath,
            'tgl_pengaduan' => now(),
            'status' => '0',
        ]);

        return redirect()->route('pengaduan.create')->with('success', 'Pengaduan berhasil dikirim!');
    }

    
}
