<?php

use App\Http\Controllers\DashboardController;
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
use App\Http\Controllers\GlobalSearchController;
use App\Http\Controllers\UserController;
use App\Models\DokumenBa;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware(['auth'])->group(function () {
//     Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
// });

// Route Checkbok
Route::delete('/fakultas/bulk-delete', [FakultasController::class, 'bulkDelete'])->name('fakultas.bulkDelete');
Route::delete('/dokumen-ekonomi/bulk-delete', [DokumenEkonomiController::class, 'bulkDelete'])->name('dokumen-ekonomi.bulkDelete');
Route::delete('/fakultas_syariahs/bulk-delete', [FakultasSyariahController::class, 'bulkDelete'])->name('fakultas_syariahs.bulkDelete');
Route::delete('/data_tendik/bulk-delete', [DataTendikController::class, 'bulkDelete'])->name('data_tendik.bulkDelete');
Route::delete('/hki/bulk-delete', [HKIController::class, 'bulkDelete'])->name('hki.bulkDelete');
Route::delete('/dokumen_htn/bulk-delete', [DokumenHtnController::class, 'bulkDelete'])->name('dokumen_htn.bulkDelete');
Route::delete('/prodi_bkpi/bulk-delete', [ProdiBkpiController::class, 'bulkDelete'])->name('prodi_bkpi.bulkDelete');
Route::delete('/fakultas_tarbiyah/bulk-delete', [FakultasTarbiyahController::class, 'bulkDelete'])->name('fakultas_tarbiyah.bulkDelete');
Route::delete('/dokumen_mpi/bulk-delete', [DokumenMouMPIController::class, 'bulkDelete'])->name('dokumen_mpi.bulkDelete');
Route::delete('/dokumen_piaud/bulk-delete', [DokumenMouPIAUDController::class, 'bulkDelete'])->name('dokumen_piaud.bulkDelete');
Route::delete('/dokumen_pai/bulk-delete', [DokumenMouPAIController::class, 'bulkDelete'])->name('dokumen_pai.bulkDelete');
Route::delete('/dokumen_pgmi/bulk-delete', [DokumenMouPGMIController::class, 'bulkDelete'])->name('dokumen_pgmi.bulkDelete');
Route::delete('/dokumen_iait/bulk-delete', [DokumenMouInstitutIAITController::class, 'bulkDelete'])->name('dokumen_iait.bulkDelete');
Route::delete('/dokumen_pascasarjana/bulk-delete', [DokumenMouPascasarjanaController::class, 'bulkDelete'])->name('dokumen_pascasarjana.bulkDelete');
Route::delete('/dokumen_sk_institusi/bulk-delete', [DokumenSkInstitusiController::class, 'bulkDelete'])->name('dokumen_sk_institusi.bulkDelete');
Route::delete('/dokumen_sk_mahasiswa/bulk-delete', [DokumenSkMahasiswaController::class, 'bulkDelete'])->name('dokumen_sk_mahasiswa.bulkDelete');
Route::delete('/dokumen_st/bulk-delete', [DokumenStController::class, 'bulkDelete'])->name('dokumen_st.bulkDelete');
Route::delete('/dokumen_ba/bulk-delete', [DokumenBaController::class, 'bulkDelete'])->name('dokumen_ba.bulkDelete');
Route::delete('/data_sarpras/bulk-delete', [DataSarprasController::class, 'bulkDelete'])->name('data_sarpras.bulkDelete');
Route::delete('/dokumen_peraturan/bulk-delete', [DokumenPeraturanController::class, 'bulkDelete'])->name('dokumen_peraturan.bulkDelete');
Route::delete('/dokumen-dosen/bulk-delete', [DokumenDosenController::class, 'bulkDelete'])->name('dokumen-dosen.bulkDelete');










Route::get('/activity-report', function () {
    return view('page.reports.activity');
})->name('activity.report');

Route::get('/search', [GlobalSearchController::class, 'index'])->name('search');
Route::get('/dokumen-dosen/{id}', [DokumenDosenController::class, 'show'])->name('dokumen-dosen.show');


Route::middleware('auth')->group(function () {
    Route::resource('users', UserController::class)->middleware(['auth', 'verified']);
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

require __DIR__ . '/auth.php';
