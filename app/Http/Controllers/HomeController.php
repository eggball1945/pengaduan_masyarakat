<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Masyarakat;
use App\Models\Pengaduan;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    // public landing / dashboard (bisa diakses publik atau via auth, tergantung route)
    public function index()
    {
        $totalUser = Masyarakat::count();
        $totalPengaduan = Pengaduan::count();
        $pengaduanSelesai = Pengaduan::where('status', 'selesai')->count();

        // catat ke log supaya bisa dipastikan method ini terpanggil dan variabel ada
        Log::debug('HomeController@index =>', compact('totalUser','totalPengaduan','pengaduanSelesai'));

        // kirim variabel secara eksplisit (safe)
        return view('home')
            ->with('totalUser', $totalUser)
            ->with('totalPengaduan', $totalPengaduan)
            ->with('pengaduanSelesai', $pengaduanSelesai);
    }

    // ROUTE DEBUG (sementara) - akan menampilkan isi variabel langsung
    public function debug()
    {
        $vars = [
            'totalUser' => Masyarakat::count(),
            'totalPengaduan' => Pengaduan::count(),
            'pengaduanSelesai' => Pengaduan::where('status','selesai')->count(),
        ];

        // Tampilkan langsung di browser untuk verifikasi cepat
        dd($vars);
    }
}
