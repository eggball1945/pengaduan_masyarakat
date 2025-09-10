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

    public function index()
    {
        $pengaduans = Pengaduan::with(['tanggapan.petugas', 'masyarakat'])
            ->orderBy('tgl_pengaduan', 'desc')
            ->get()
            ->map(function ($item) {
                $item->foto_array = $item->foto ? json_decode($item->foto, true) : [];
                return $item;
            });

        return view('admin.tanggapan', compact('pengaduans'));
    }

    public function updateOrStore(Request $request, $id_pengaduan)
    {
        $request->validate([
            'tanggapan' => 'required|string|max:1000',
        ]);

        $pengaduan = Pengaduan::findOrFail($id_pengaduan);

        $petugas = Auth::guard('admin')->user() ?? Auth::guard('petugas')->user();

        Tanggapan::updateOrCreate(
            ['id_pengaduan' => $pengaduan->id_pengaduan],
            [
                'tgl_tanggapan' => now(),
                'tanggapan'     => $request->tanggapan,
                'id_petugas'    => $petugas->id_petugas,
            ]
        );

        if ($pengaduan->status === '0') {
            $pengaduan->update(['status' => 'proses']);
        }

        return redirect()->back()->with('success', 'Tanggapan berhasil disimpan.');
    }

    public function destroy($id)
    {
        $tanggapan = Tanggapan::findOrFail($id);
        $pengaduan = $tanggapan->pengaduan;

        $tanggapan->delete();

        if ($pengaduan && !$pengaduan->tanggapan) {
            $pengaduan->update(['status' => '0']);
        }

        return redirect()->back()->with('success', 'Tanggapan berhasil dihapus.');
    }

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
