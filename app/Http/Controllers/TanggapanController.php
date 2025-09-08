<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tanggapan;
use App\Models\Pengaduan;
use Illuminate\Support\Facades\Auth;

class TanggapanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin,petugas');
    }

    /**
     * Tampilkan semua pengaduan dengan tanggapan
     */
    public function index()
    {
        $pengaduans = Pengaduan::with(['tanggapan.petugas', 'masyarakat'])
            ->orderBy('tgl_pengaduan', 'desc')
            ->get();

        return view('admin.tanggapan', compact('pengaduans'));
    }

    /**
     * Tambah atau update tanggapan
     */
    public function updateOrStore(Request $request, $id_pengaduan)
    {
        $request->validate([
            'tanggapan' => 'required|string|max:1000',
        ]);

        $pengaduan = Pengaduan::findOrFail($id_pengaduan);

        // Tentukan petugas berdasarkan guard login
        $petugas_id = Auth::guard('admin')->check() 
                        ? Auth::guard('admin')->id() 
                        : Auth::guard('petugas')->id();

        $tanggapan = $pengaduan->tanggapan;

        if ($tanggapan) {
            // Update tanggapan
            $tanggapan->update([
                'tanggapan'     => $request->tanggapan,
                'tgl_tanggapan' => now(),
                'id_petugas'    => $petugas_id,
            ]);
        } else {
            // Buat tanggapan baru
            Tanggapan::create([
                'id_pengaduan'  => $pengaduan->id_pengaduan,
                'tgl_tanggapan' => now(),
                'tanggapan'     => $request->tanggapan,
                'id_petugas'    => $petugas_id,
            ]);
        }

        // Jika status sebelumnya '0', otomatis ubah ke 'proses'
        if ($pengaduan->status === '0') {
            $pengaduan->update(['status' => 'proses']);
        }

        return redirect()->back()->with('success', 'Tanggapan berhasil disimpan.');
    }

    /**
     * Hapus tanggapan
     */
    public function destroy($id)
    {
        $tanggapan = Tanggapan::findOrFail($id);
        $pengaduan = $tanggapan->pengaduan;

        $tanggapan->delete();

        // Jika tidak ada tanggapan tersisa, set status pengaduan ke '0'
        if ($pengaduan && $pengaduan->tanggapan()->count() === 0) {
            $pengaduan->update(['status' => '0']);
        }

        return redirect()->back()->with('success', 'Tanggapan berhasil dihapus.');
    }

    /**
     * Update status pengaduan
     */
    public function updateStatus(Request $request, $id_pengaduan)
    {
        $request->validate([
            'status' => 'required|in:0,proses,selesai',
        ]);

        $pengaduan = Pengaduan::findOrFail($id_pengaduan);
        $pengaduan->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status pengaduan berhasil diperbarui.');
    }
}
