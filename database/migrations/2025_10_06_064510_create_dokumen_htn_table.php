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
        Schema::create('dokumen_htn', function (Blueprint $table) {
            $table->id();
            $table->string('judul_mou');
            $table->string('lembaga_mitra');
            $table->string('nomor_mou');
            $table->string('kategori');
            $table->text('deskripsi');
            $table->string("file");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen_htn');
    }
};
