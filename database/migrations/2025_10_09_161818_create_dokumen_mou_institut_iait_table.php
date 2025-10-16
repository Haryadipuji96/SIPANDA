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
        Schema::create('dokumen_mou_institut_iait', function (Blueprint $table) {
            $table->id();
            $table->string('judul_mou');
            $table->string('nomor_mou')->nullable();
            $table->string('lembaga_mitra');
            $table->string('jenis_kerjasama')->nullable();
            $table->string('tingkat_kerjasama')->nullable();
            $table->date('tanggal_ttd')->nullable();
            $table->string('masa_berlaku')->nullable();
            $table->string('penanggung_jawab')->nullable();
            $table->string('file_dokumen')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen_mou_institut_iait');
    }
};
