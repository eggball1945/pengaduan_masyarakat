<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pengaduan;
use Illuminate\Support\Facades\Storage;

class PengaduanController extends Controller
{
    public function __construct()
    {
        // Semua user yang login (masyarakat/admin/petugas)
        $this->middleware('auth:masyarakat,petugas,admin');
    }

    // ==========================
    // MASYARAKAT
    // ==========================
    public function index()
    {
        $pengaduans = Pengaduan::with('tanggapan.petugas')
            ->where('nik', Auth::guard('masyarakat')->user()->nik)
            ->orderBy('tgl_pengaduan', 'desc')
            ->get();

        return view('pengaduan.index', compact('pengaduans'));
    }

    public function create()
    {
        return view('pengaduan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'isi_laporan' => 'required|string',
            'foto'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $fotoPath = $request->hasFile('foto')
            ? $request->file('foto')->store('pengaduan_foto', 'public')
            : null;

        $user = Auth::guard('masyarakat')->user();

        Pengaduan::create([
            'nik'           => $user->nik,
            'isi_laporan'   => $request->isi_laporan,
            'foto'          => $fotoPath,
            'tgl_pengaduan' => now(),
            'status'        => '0',
        ]);

        return redirect()->route('pengaduan.index')->with('success', 'Pengaduan berhasil dikirim!');
    }

    public function edit($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);

        if (Auth::guard('masyarakat')->check() &&
            $pengaduan->nik !== Auth::guard('masyarakat')->user()->nik) {
            abort(403, 'Tidak boleh mengedit pengaduan orang lain.');
        }

        return view('pengaduan.edit', compact('pengaduan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'isi_laporan' => 'required|string',
            'foto'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $pengaduan = Pengaduan::findOrFail($id);

        if (Auth::guard('masyarakat')->check() &&
            $pengaduan->nik !== Auth::guard('masyarakat')->user()->nik) {
            abort(403, 'Tidak boleh mengedit pengaduan orang lain.');
        }

        if ($request->hasFile('foto')) {
            if ($pengaduan->foto) {
                Storage::disk('public')->delete($pengaduan->foto);
            }
            $pengaduan->foto = $request->file('foto')->store('pengaduan_foto', 'public');
        }

        $pengaduan->isi_laporan = $request->isi_laporan;
        $pengaduan->save();

        return redirect()->route('pengaduan.index')->with('success', 'Pengaduan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);

        if (Auth::guard('masyarakat')->check() &&
            $pengaduan->nik !== Auth::guard('masyarakat')->user()->nik) {
            abort(403, 'Tidak boleh menghapus pengaduan orang lain.');
        }

        if ($pengaduan->foto) {
            Storage::disk('public')->delete($pengaduan->foto);
        }

        $pengaduan->delete();

        return back()->with('success', 'Pengaduan berhasil dihapus!');
    }

    // ==========================
    // ADMIN & PETUGAS
    // ==========================
    public function indexAdmin()
    {
        $pengaduans = Pengaduan::with('tanggapan.petugas')
            ->orderBy('tgl_pengaduan', 'desc')
            ->get();

        return view('admin.pengaduan.index', compact('pengaduans'));
    }

    public function indexPetugas()
    {
        $pengaduans = Pengaduan::with('tanggapan.petugas')
            ->orderBy('tgl_pengaduan', 'desc')
            ->get();

        return view('admin.pengaduan.index', compact('pengaduans'));
    }

    public function verifikasi($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);
        $pengaduan->status = 'proses';
        $pengaduan->save();

        return redirect()->back()->with('success', 'Pengaduan berhasil diverifikasi.');
    }

    public function selesai($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);
        $pengaduan->status = 'selesai';
        $pengaduan->save();

        return redirect()->back()->with('success', 'Pengaduan berhasil diselesaikan.');
    }
}
