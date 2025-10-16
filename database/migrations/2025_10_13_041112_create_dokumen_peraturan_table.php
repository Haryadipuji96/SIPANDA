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
        Schema::create('dokumen_peraturan', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('nomor_peraturan')->nullable();
            $table->string('kategori')->nullable();
            $table->date('tanggal_terbit')->nullable();
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
        Schema::dropIfExists('dokumen_peraturan');
    }
};
