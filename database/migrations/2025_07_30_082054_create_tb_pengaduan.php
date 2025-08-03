<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('tb_pengaduan', function (Blueprint $table) {
            $table->id('id_pengaduan');
            $table->date('tgl_pengaduan');
            $table->string('nik');
            $table->text('isi_laporan');
            $table->string('foto')->nullable();
            $table->enum('status', ['0', 'proses', 'selesai'])->default('0');
            $table->timestamps();

            $table->foreign('nik')->references('nik')->on('tb_masyarakat')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('tb_pengaduan');
    }
};

