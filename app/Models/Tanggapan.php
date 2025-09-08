<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tanggapan extends Model
{
    use HasFactory;

    protected $table = 'tb_tanggapan';
    protected $primaryKey = 'id_tanggapan';
    protected $keyType = 'int';
    public $incrementing = true;

    // Kalau tabel TIDAK punya kolom created_at & updated_at → ubah jadi false
    public $timestamps = false;

    protected $fillable = [
        'id_pengaduan',
        'tgl_tanggapan', // kolom yg benar
        'tanggapan',
        'id_petugas',
    ];

    protected $casts = [
        'tgl_tanggapan' => 'date',
    ];

    /**
     * Relasi ke Petugas
     */
    public function petugas()
    {
        return $this->belongsTo(Petugas::class, 'id_petugas', 'id_petugas');
    }

    /**
     * Relasi ke Pengaduan
     */
    public function pengaduan()
    {
        return $this->belongsTo(Pengaduan::class, 'id_pengaduan', 'id_pengaduan');
    }
}
