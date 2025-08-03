<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Masyarakat extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'tb_masyarakat';

    // Gunakan NIK sebagai primary key (bukan auto-increment ID)
    protected $primaryKey = 'nik';
    public $incrementing = false;
    protected $keyType = 'string';

    // Kolom yang bisa diisi
    protected $fillable = [
        'nik',
        'nama',
        'username',
        'password',
        'telepon',
    ];

    // Sembunyikan field sensitif saat data diserialisasi (misalnya ke JSON)
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Jika kamu ingin mengaktifkan fitur remember me
    public function getAuthIdentifierName()
    {
        return 'nik';
    }
}
