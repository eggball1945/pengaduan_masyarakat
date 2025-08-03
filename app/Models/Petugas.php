<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Petugas extends Authenticatable
{
    use Notifiable;

    protected $table = 'tb_petugas';
    protected $primaryKey = 'id_petugas'; // 👈 Tambahkan ini

    protected $fillable = [
        'nama_petugas',
        'username',
        'password',
        'telepon',
        'level',
    ];

    protected $hidden = [
        'password',
    ];
}
