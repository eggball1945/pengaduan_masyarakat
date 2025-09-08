<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaduan;
use App\Models\Tanggapan;
use App\Models\Petugas;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class StaffController extends Controller
{
    // ================== DASHBOARD ==================
    public function dashboard()
    {
        $pengaduans = Pengaduan::with('masyarakat')->latest()->get();
        return view('admin.dashboard', compact('pengaduans')); // Admin & Petugas pakai view sama
    }

    // ================== LAPORAN (Admin Only) ==================
    public function laporan()
    {
        $pengaduans = Pengaduan::with(['masyarakat', 'tanggapan'])->latest()->get();
        return view('admin.laporan', compact('pengaduans'));
    }

    // ================== VERIFIKASI & SELESAI PENGADUAN ==================
    public function verifikasi($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);
        $pengaduan->update(['status' => 'proses']);

        return back()->with('success', 'Pengaduan diverifikasi.');
    }

    public function selesai($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);
        $pengaduan->update(['status' => 'selesai']);

        return back()->with('success', 'Pengaduan diselesaikan.');
    }

    // ================== TANGGAPAN ==================
    public function tanggapanStore(Request $request, $id_pengaduan)
    {
        $request->validate([
            'tanggapan' => 'required|string|max:1000',
        ]);

        $petugas_id = Auth::guard('admin')->check() ? Auth::guard('admin')->id() : Auth::guard('petugas')->id();

        Tanggapan::create([
            'id_pengaduan'  => $id_pengaduan,
            'tgl_tanggapan' => now(),
            'tanggapan'     => $request->tanggapan,
            'id_petugas'    => $petugas_id,
        ]);

        $pengaduan = Pengaduan::findOrFail($id_pengaduan);
        if ($pengaduan->status === '0') {
            $pengaduan->update(['status' => 'proses']);
        }

        return back()->with('success', 'Tanggapan berhasil disimpan.');
    }

    public function tanggapanHapus($id)
    {
        $tanggapan = Tanggapan::findOrFail($id);
        $tanggapan->delete();

        return back()->with('success', 'Tanggapan berhasil dihapus.');
    }

    // ================== PETUGAS (Admin Only) ==================
    public function indexPetugas()
    {
        $petugas = Petugas::latest()->get();
        return view('admin.register', compact('petugas'));
    }

    public function storePetugas(Request $request)
    {
        $request->validate([
            'nama_petugas' => 'required|string|max:100',
            'username'     => 'required|string|unique:tb_petugas,username',
            'password'     => 'required|string|min:6',
            'telepon'      => 'required|string|max:15',
            'level'        => 'required|in:admin,petugas'
        ]);

        Petugas::create([
            'nama_petugas' => $request->nama_petugas,
            'username'     => $request->username,
            'password'     => $request->password,
            'telepon'      => $request->telepon,
            'level'        => $request->level
        ]);

        return redirect()->route('admin.register')->with('success', 'Petugas berhasil diregistrasi.');
    }

    public function editPetugas($id)
    {
        $petugasToEdit = Petugas::findOrFail($id);
        $petugas = Petugas::latest()->get();
        return view('admin.register', compact('petugas', 'petugasToEdit'));
    }

    public function updatePetugas(Request $request, $id)
    {
        $petugas = Petugas::findOrFail($id);

        $request->validate([
            'nama_petugas' => 'required|string|max:100',
            'username'     => 'required|string|unique:tb_petugas,username,' . $id . ',id_petugas',
            'telepon'      => 'required|string|max:15',
            'level'        => 'required|in:admin,petugas'
        ]);

        $data = [
            'nama_petugas' => $request->nama_petugas,
            'username'     => $request->username,
            'telepon'      => $request->telepon,
            'level'        => $request->level,
        ];

        if ($request->filled('password')) {
            $data['password'] = $request->password;
        }

        $petugas->update($data);

        return redirect()->route('admin.register')->with('success', 'Petugas berhasil diperbarui.');
    }

    public function destroyPetugas($id)
    {
        $petugas = Petugas::findOrFail($id);
        $petugas->delete();
        return back()->with('success', 'Petugas berhasil dihapus.');
    }
}
