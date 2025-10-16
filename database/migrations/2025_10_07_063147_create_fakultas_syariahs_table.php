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
        Schema::create('fakultas_syariahs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_fakultas');
            $table->string('dekan');
            $table->text('deskripsi');
            $table->string('file');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fakultas_syariahs');
    }
};
