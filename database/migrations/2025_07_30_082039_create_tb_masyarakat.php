<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbMasyarakat extends Migration
{
    public function up(): void
    {
        Schema::create('tb_masyarakat', function (Blueprint $table) {
            $table->string('nik')->primary();
            $table->string('nama');
            $table->string('username')->unique();
            $table->string('password');
            $table->string('telepon');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_masyarakat');
    }
}
