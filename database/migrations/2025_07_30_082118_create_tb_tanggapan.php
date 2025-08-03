<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('tb_tanggapan', function (Blueprint $table) {
            $table->id('id_tanggapan');
            $table->unsignedBigInteger('id_pengaduan');
            $table->date('tgl_pengaduan');
            $table->text('tanggapan');
            $table->unsignedBigInteger('id_petugas');
            $table->timestamps();

            $table->foreign('id_pengaduan')->references('id_pengaduan')->on('tb_pengaduan')->onDelete('cascade');
            $table->foreign('id_petugas')->references('id_petugas')->on('tb_petugas')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('tb_tanggapan');
    }
};
