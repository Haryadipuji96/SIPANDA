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
        Schema::create('data_sarpras', function (Blueprint $table) {
            $table->id();
            $table->string('nama_barang');
            $table->string('kategori'); // dropdown: Sarana / Prasarana
            $table->string('lokasi')->nullable();
            $table->integer('jumlah')->default(1);
            $table->string('kondisi'); // dropdown: Baik, Rusak Ringan, Rusak Berat, dll
            $table->date('tanggal_pengadaan')->nullable();
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
        Schema::dropIfExists('data_sarpras');
    }
};
