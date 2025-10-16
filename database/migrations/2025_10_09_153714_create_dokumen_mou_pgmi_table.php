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
        Schema::create('dokumen_mou_pgmi', function (Blueprint $table) {
            $table->id();
            $table->string('judul_dokumen');
            $table->string('nomor_mou')->nullable();
            $table->date('tanggal_mou')->nullable();
            $table->string('pihak_kerjasama')->nullable();
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
        Schema::dropIfExists('dokumen_mou_pgmi');
    }
};
