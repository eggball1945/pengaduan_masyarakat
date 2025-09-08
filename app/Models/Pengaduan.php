<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    use HasFactory;

    protected $table = 'tb_pengaduan';
    protected $primaryKey = 'id_pengaduan';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'nik',
        'tgl_pengaduan',
        'isi_laporan',
        'foto',
        'status',
    ];

    protected $casts = [
        'tgl_pengaduan' => 'date',
    ];

    /**
     * Relasi ke tabel masyarakat (banyak pengaduan dimiliki oleh satu masyarakat).
     */
    public function masyarakat()
    {
        return $this->belongsTo(Masyarakat::class, 'nik', 'nik');
    }

    /**
     * Relasi satu-ke-satu ke tabel tanggapan.
     */
    public function tanggapan()
    {
        return $this->hasOne(Tanggapan::class, 'id_pengaduan', 'id_pengaduan');
    }
}
