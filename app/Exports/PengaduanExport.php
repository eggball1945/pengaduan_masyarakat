<?php

namespace App\Exports;

use App\Models\Pengaduan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PengaduanExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Pengaduan::with(['tanggapan.petugas'])
            ->get()
            ->map(function ($p) {
                return [
                    'NIK'        => $p->nik,
                    'Isi Laporan'=> $p->isi_laporan,
                    'Tanggal'    => $p->tgl_pengaduan->format('Y-m-d'), // format lebih rapi
                    'Tanggapan'  => $p->tanggapan->tanggapan ?? '-',
                    'Petugas'    => $p->tanggapan->petugas->nama_petugas ?? '-',
                    'Status'     => match($p->status) {
                        '0' => 'Belum',
                        'proses' => 'Proses',
                        'selesai' => 'Selesai',
                        default => '-',
                    },
                ];
            });
    }

    public function headings(): array
    {
        return ['NIK', 'Isi Laporan', 'Tanggal', 'Tanggapan', 'Petugas', 'Status'];
    }
}
