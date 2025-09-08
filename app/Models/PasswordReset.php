<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    protected $table = 'password_resets';
    protected $primaryKey = 'nik';
    public $incrementing = false;
    public $timestamps = false; // karena hanya ada created_at

    protected $fillable = [
        'nik',
        'token',
        'created_at',
    ];
}
