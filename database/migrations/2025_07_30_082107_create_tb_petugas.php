<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('tb_petugas', function (Blueprint $table) {
            $table->id('id_petugas');
            $table->string('nama_petugas');
            $table->string('username')->unique();
            $table->string('password');
            $table->string('telepon');
            $table->enum('level', ['admin', 'petugas']);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('tb_petugas');
    }
};

