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
            $table->foreignId('dosen_id')->constrained('dosens')->onDelete('cascade');
            $table->foreignId('kategori_id')->constrained('kategori_dokumens')->onDelete('cascade');
            $table->string('nama_dokumen');
            $table->string('file_path');
            $table->date('tanggal_upload')->nullable();
            $table->text('keterangan')->nullable();
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
