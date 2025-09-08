<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PengaduanExport;

class LaporanController extends Controller
{
    // Halaman laporan untuk admin & petugas
    public function index()
    {
        $pengaduans = Pengaduan::with(['tanggapan.petugas'])->latest()->get();
        return view('admin.laporan', compact('pengaduans'));
    }

    // Export PDF (admin only)
    public function exportPdf()
    {
        $pengaduans = Pengaduan::with(['tanggapan.petugas'])->latest()->get();

        $pdf = Pdf::loadView('admin.laporan', compact('pengaduans'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('laporan_pengaduan.pdf');
    }

    // Export Excel (admin only)
    public function exportExcel()
    {
        return Excel::download(new PengaduanExport, 'laporan_pengaduan.xlsx');
    }
}
