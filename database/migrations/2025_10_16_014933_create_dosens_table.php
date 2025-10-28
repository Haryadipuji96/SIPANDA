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
        Schema::create('dokumen_dosens', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('nik')->unique();
            $table->string('pendidikan_terakhir');
            $table->string('jabatan');
            $table->date('tmt_kerja')->nullable();
            $table->integer('masa_kerja_tahun')->default(0);
            $table->integer('masa_kerja_bulan')->default(0);
            $table->string('golongan')->nullable();
            $table->integer('masa_kerja_golongan_tahun')->default(0);
            $table->integer('masa_kerja_golongan_bulan')->default(0);
            $table->string('file_dokumen')->nullable(); // 📎 Simpan nama file dokumen
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen_dosens');
    }
};
