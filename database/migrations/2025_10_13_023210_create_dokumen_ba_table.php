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
        Schema::create('dokumen_ba', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('nomor_ba')->nullable();
            $table->date('tanggal_ba')->nullable();
            $table->string('tempat')->nullable();
            $table->text('pihak_terlibat')->nullable();
            $table->text('keterangan')->nullable();
            $table->string('file_dokumen')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen_ba');
    }
};
