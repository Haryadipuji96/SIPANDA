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
        Schema::create('data_tendik', function (Blueprint $table) {
            $table->id();
            $table->string('nama_tendik');
            $table->string('nip')->nullable();
            $table->string('jabatan');
            $table->string('status_kepegawaian');
            $table->string('pendidikan_terakhir');
            $table->string('jenis_kelamin');
            $table->string('no_hp')->nullable();
            $table->string('email')->nullable();
            $table->text('alamat')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_tendik');
    }
};
