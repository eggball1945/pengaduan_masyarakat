<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tb_tanggapan', function (Blueprint $table) {
            $table->timestamp('tgl_tanggapan')->nullable()->after('id_pengaduan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_tanggapan', function (Blueprint $table) {
            $table->dropColumn('tgl_tanggapan');
        });
    }
};
