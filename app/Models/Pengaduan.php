<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    use HasFactory;

    protected $table = 'tb_pengaduan';

    protected $primaryKey = 'id_pengaduan'; // jika ini bukan 'id', sesuaikan
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'nik',
        'tgl_pengaduan',
        'isi_laporan',
        'foto',
        'status',
    ];

    // Relasi ke Masyarakat
    public function masyarakat()
    {
        return $this->belongsTo(Masyarakat::class, 'nik', 'nik');
    }
    public function tanggapan()
    {
        return $this->hasOne(Tanggapan::class, 'id_pengaduan');
    }
}
