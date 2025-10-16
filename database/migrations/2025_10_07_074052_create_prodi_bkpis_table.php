<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prodi_bkpi', function (Blueprint $table) {
            $table->id();
            $table->string('judul_mou');
            $table->string('mitra_kerjasama');
            $table->string('nomor_dokumen')->nullable();
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_berakhir')->nullable();
            $table->string('bidang_kerjasama')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('file')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prodi_bkpi');
    }
};
