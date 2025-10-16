<?php

use App\Http\Controllers\DataSarprasController;
use App\Http\Controllers\DataTendikController;
use App\Http\Controllers\DokumenBaController;
use App\Http\Controllers\DokumenDosenController;
use App\Http\Controllers\DokumenEkonomiController;
use App\Http\Controllers\DokumenHtnController;
use App\Http\Controllers\DokumenMouInstitutIAITController;
use App\Http\Controllers\DokumenMouMPIController;
use App\Http\Controllers\FakultasController;
use App\Http\Controllers\HKIController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FakultasSyariahController;
use App\Http\Controllers\FakultasTarbiyahController;
use App\Http\Controllers\ProdiBkpiController;
use App\Http\Controllers\DokumenMouPIAUDController;
use App\Http\Controllers\DokumenMouPAIController;
use App\Http\Controllers\DokumenMouPascasarjanaController;
use App\Http\Controllers\DokumenMouPGMIController;
use App\Http\Controllers\DokumenPeraturanController;
use App\Http\Controllers\DokumenSkInstitusiController;
use App\Http\Controllers\DokumenSkMahasiswaController;
use App\Http\Controllers\DokumenStController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('dokumen-ekonomi', DokumenEkonomiController::class);
    Route::resource('fakultas', FakultasController::class);
    Route::resource('hki', HKIController::class);
    Route::resource('dokumen_htn', DokumenHtnController::class);
    Route::resource('fakultas_syariahs', FakultasSyariahController::class);
    Route::resource('prodi_bkpi', ProdiBkpiController::class);
    Route::resource('fakultas_tarbiyah', FakultasTarbiyahController::class);
    Route::resource('dokumen_mpi', DokumenMouMPIController::class);
    Route::resource('dokumen_piaud', DokumenMouPIAUDController::class);
    Route::resource('dokumen_pai', DokumenMouPAIController::class);
    Route::resource('dokumen_pgmi', DokumenMouPGMIController::class);
    Route::resource('dokumen_iait', DokumenMouInstitutIAITController::class);
    Route::resource('dokumen_pascasarjana', DokumenMouPascasarjanaController::class);
    Route::resource('dokumen_sk_institusi', DokumenSkInstitusiController::class);
    Route::resource('dokumen_sk_mahasiswa', DokumenSkMahasiswaController::class);
    Route::resource('dokumen_st', DokumenStController::class);
    Route::resource('dokumen_ba', DokumenBaController::class);
    Route::resource('data_sarpras', DataSarprasController::class);
    Route::resource('dokumen_peraturan', DokumenPeraturanController::class);
    Route::resource('data_tendik', DataTendikController::class);
    Route::resource('dokumen-dosen', DokumenDosenController::class);
});

require __DIR__.'/auth.php';
