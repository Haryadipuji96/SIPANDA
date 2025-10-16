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
        Schema::create('dokumen_sk_institusi', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('nomor_sk');
            $table->date('tanggal_sk');
            $table->string('unit_penerbit');
            $table->string('kategori');
            $table->string('file_dokumen');
            $table->text('keterangan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen_sk_institusi');
    }
};
