<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pengaduan;
use App\Models\Tanggapan;
use Illuminate\Support\Facades\Storage;

class PengaduanController extends Controller
{
    public function __construct()
    {
        // Hanya untuk user login (masyarakat/petugas/admin)
        $this->middleware('auth:masyarakat,petugas,admin');
    }

    // ==========================
    // INDEX (LISTING)
    // ==========================
    public function index()
    {
        if (Auth::guard('masyarakat')->check()) {
            // Masyarakat hanya melihat pengaduan miliknya sendiri
            $nik = Auth::guard('masyarakat')->user()->nik;
            $pengaduans = Pengaduan::with('tanggapan.petugas')
                ->where('nik', $nik)
                ->orderBy('tgl_pengaduan', 'desc')
                ->get();
        } else {
            // Admin / Petugas bisa lihat semua
            $pengaduans = Pengaduan::with('tanggapan.petugas')
                ->orderBy('tgl_pengaduan', 'desc')
                ->get();
        }

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
            'foto.*'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::guard('masyarakat')->user();

        $fotoPaths = null;
        if ($request->hasFile('foto')) {
            $paths = [];
            foreach ($request->file('foto') as $file) {
                $paths[] = $file->store('pengaduan_foto', 'public');
            }
            $fotoPaths = json_encode($paths);
        }

        Pengaduan::create([
            'nik'           => $user->nik,
            'isi_laporan'   => $request->isi_laporan,
            'foto'          => $fotoPaths,
            'tgl_pengaduan' => now(),
            'status'        => '0',
        ]);

        return redirect()->route('pengaduan.index')->with('success', 'Pengaduan berhasil dikirim!');
    }

    // ==========================
    // EDIT & UPDATE
    // ==========================
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
        $pengaduan = Pengaduan::findOrFail($id);

        // Update oleh masyarakat (hanya isi_laporan + foto)
        if (Auth::guard('masyarakat')->check()) {
            if ($pengaduan->nik !== Auth::guard('masyarakat')->user()->nik) {
                abort(403, 'Tidak boleh mengedit pengaduan orang lain.');
            }

            $request->validate([
                'isi_laporan' => 'required|string',
                'foto.*'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            if ($request->hasFile('foto')) {
                // hapus foto lama
                if ($pengaduan->foto) {
                    $oldFiles = json_decode($pengaduan->foto, true) ?? [];
                    foreach ($oldFiles as $old) {
                        Storage::disk('public')->delete($old);
                    }
                }

                $paths = [];
                foreach ($request->file('foto') as $file) {
                    $paths[] = $file->store('pengaduan_foto', 'public');
                }
                $pengaduan->foto = json_encode($paths);
            }

            $pengaduan->isi_laporan = $request->isi_laporan;
            $pengaduan->save();

            return redirect()->route('pengaduan.index')->with('success', 'Pengaduan berhasil diperbarui!');
        }

        // Update oleh admin/petugas → status + tanggapan
        if (Auth::guard('admin')->check() || Auth::guard('petugas')->check()) {
            $request->validate([
                'status'     => 'required|in:0,proses,selesai',
                'tanggapan'  => 'nullable|string',
            ]);

            $pengaduan->status = $request->status;
            $pengaduan->save();

            $petugas = Auth::guard('admin')->user() ?? Auth::guard('petugas')->user();

            Tanggapan::updateOrCreate(
                ['id_pengaduan' => $pengaduan->id_pengaduan],
                [
                    'tgl_tanggapan' => now(),
                    'tanggapan'     => $request->tanggapan,
                    'id_petugas'    => $petugas->id_petugas,
                ]
            );

            return back()->with('success', 'Pengaduan & tanggapan berhasil diperbarui!');
        }

        abort(403, 'Akses ditolak.');
    }

    // ==========================
    // HAPUS
    // ==========================
    public function destroy($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);

        if (Auth::guard('masyarakat')->check() &&
            $pengaduan->nik !== Auth::guard('masyarakat')->user()->nik) {
            abort(403, 'Tidak boleh menghapus pengaduan orang lain.');
        }

        if ($pengaduan->foto) {
            $oldFiles = json_decode($pengaduan->foto, true) ?? [];
            foreach ($oldFiles as $old) {
                Storage::disk('public')->delete($old);
            }
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
