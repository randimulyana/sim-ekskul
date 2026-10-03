<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

// ============================================================
// Landing Page
// ============================================================
Route::get('/', function () {
    return view('landing');
})->name('home');

// ============================================================
// Breeze Dashboard (kept for compatibility)
// ============================================================
Route::get('/dashboard', function () {
    if (auth()->user()?->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }

    return redirect()->route('siswa.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// ============================================================
// Breeze Profile Routes (account self-deletion disabled)
// ============================================================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// ============================================================
// STUDENT ROUTES (Protected with auth + role:student)
// ============================================================
Route::prefix('siswa')->name('siswa.')->middleware(['auth', 'role:student'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Student\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profil', [App\Http\Controllers\Student\ProfileController::class, 'show'])->name('profil');
    Route::put('/profil', [App\Http\Controllers\Student\ProfileController::class, 'update'])->name('profil.update');

    // Extracurricular catalog
    Route::get('/ekstrakurikuler', [App\Http\Controllers\Student\EkstrakurikulerController::class, 'index'])->name('ekstrakurikuler.index');
    Route::get('/ekstrakurikuler/{id}', [App\Http\Controllers\Student\EkstrakurikulerController::class, 'show'])->name('ekstrakurikuler.show');

    // Questionnaire
    Route::get('/kuesioner', [App\Http\Controllers\Student\KuesionerController::class, 'index'])->name('kuesioner.index');
    Route::post('/kuesioner', [App\Http\Controllers\Student\KuesionerController::class, 'store'])->name('kuesioner.store');
    Route::get('/kuesioner/analisis', [App\Http\Controllers\Student\KuesionerController::class, 'analisis'])->name('kuesioner.analisis');
    Route::get('/kuesioner/hasil', [App\Http\Controllers\Student\KuesionerController::class, 'hasil'])->name('kuesioner.hasil');

    // Recommendation (SAW Recommendation Engine)
    Route::get('/rekomendasi', [App\Http\Controllers\Student\RekomendasiController::class, 'index'])->name('rekomendasi.index');
    Route::get('/rekomendasi/{id}', [App\Http\Controllers\Student\RekomendasiController::class, 'show'])->name('rekomendasi.show');

    // Registration & History
    Route::get('/pendaftaran', [App\Http\Controllers\Student\PendaftaranController::class, 'index'])->name('pendaftaran.index');
    Route::post('/pendaftaran', [App\Http\Controllers\Student\PendaftaranController::class, 'store'])->name('pendaftaran.store');
    Route::get('/pendaftaran/sukses', [App\Http\Controllers\Student\PendaftaranController::class, 'sukses'])->name('pendaftaran.sukses');
    Route::get('/riwayat', [App\Http\Controllers\Student\PendaftaranController::class, 'riwayat'])->name('riwayat');
});

// ============================================================
// ADMIN ROUTES (Protected with auth + role:admin)
// ============================================================
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    // Profil Admin
    Route::get('/profil', [App\Http\Controllers\Admin\AdminProfileController::class, 'edit'])->name('profil');
    Route::put('/profil', [App\Http\Controllers\Admin\AdminProfileController::class, 'update'])->name('profil.update');
    Route::patch('/profil', [App\Http\Controllers\Admin\AdminProfileController::class, 'update']);
    Route::put('/profil/password', [App\Http\Controllers\Admin\AdminProfileController::class, 'updatePassword'])->name('profil.password');

    // Siswa (Students)
    Route::get('/siswa', [App\Http\Controllers\Admin\SiswaController::class, 'index'])->name('siswa.index');
    Route::get('/siswa/create', [App\Http\Controllers\Admin\SiswaController::class, 'create'])->name('siswa.create');
    Route::post('/siswa', [App\Http\Controllers\Admin\SiswaController::class, 'store'])->name('siswa.store');
    Route::get('/siswa/{id}', [App\Http\Controllers\Admin\SiswaController::class, 'show'])->name('siswa.show');
    Route::get('/siswa/{id}/edit', [App\Http\Controllers\Admin\SiswaController::class, 'edit'])->name('siswa.edit');
    Route::put('/siswa/{id}', [App\Http\Controllers\Admin\SiswaController::class, 'update'])->name('siswa.update');
    Route::patch('/siswa/{id}', [App\Http\Controllers\Admin\SiswaController::class, 'update']);
    Route::delete('/siswa/{id}', [App\Http\Controllers\Admin\SiswaController::class, 'destroy'])->name('siswa.destroy');

    // Ekstrakurikuler
    Route::get('/ekstrakurikuler', [App\Http\Controllers\Admin\EkstrakurikulerController::class, 'index'])->name('ekstrakurikuler.index');
    Route::get('/ekstrakurikuler/create', [App\Http\Controllers\Admin\EkstrakurikulerController::class, 'create'])->name('ekstrakurikuler.create');
    Route::post('/ekstrakurikuler', [App\Http\Controllers\Admin\EkstrakurikulerController::class, 'store'])->name('ekstrakurikuler.store');
    Route::get('/ekstrakurikuler/{id}', [App\Http\Controllers\Admin\EkstrakurikulerController::class, 'show'])->name('ekstrakurikuler.show');
    Route::get('/ekstrakurikuler/{id}/edit', [App\Http\Controllers\Admin\EkstrakurikulerController::class, 'edit'])->name('ekstrakurikuler.edit');
    Route::put('/ekstrakurikuler/{id}', [App\Http\Controllers\Admin\EkstrakurikulerController::class, 'update'])->name('ekstrakurikuler.update');
    Route::patch('/ekstrakurikuler/{id}', [App\Http\Controllers\Admin\EkstrakurikulerController::class, 'update']);
    Route::delete('/ekstrakurikuler/{id}', [App\Http\Controllers\Admin\EkstrakurikulerController::class, 'destroy'])->name('ekstrakurikuler.destroy');

    // Pendaftaran
    Route::get('/pendaftaran', [App\Http\Controllers\Admin\PendaftaranController::class, 'index'])->name('pendaftaran.index');
    Route::get('/pendaftaran/{id}', [App\Http\Controllers\Admin\PendaftaranController::class, 'show'])->name('pendaftaran.show');
    Route::put('/pendaftaran/{id}/status', [App\Http\Controllers\Admin\PendaftaranController::class, 'updateStatus'])->name('pendaftaran.update-status');
    Route::patch('/pendaftaran/{id}/status', [App\Http\Controllers\Admin\PendaftaranController::class, 'updateStatus']);
    Route::post('/pendaftaran/{id}/status', [App\Http\Controllers\Admin\PendaftaranController::class, 'updateStatus']);
    Route::put('/pendaftaran/{id}', [App\Http\Controllers\Admin\PendaftaranController::class, 'updateStatus'])->name('pendaftaran.update');

    // Kuesioner
    Route::get('/kuesioner', [App\Http\Controllers\Admin\KuesionerController::class, 'index'])->name('kuesioner.index');
    Route::get('/kuesioner/create', [App\Http\Controllers\Admin\KuesionerController::class, 'create'])->name('kuesioner.create');
    Route::post('/kuesioner', [App\Http\Controllers\Admin\KuesionerController::class, 'store'])->name('kuesioner.store');
    Route::get('/kuesioner/{id}/edit', [App\Http\Controllers\Admin\KuesionerController::class, 'edit'])->name('kuesioner.edit');
    Route::put('/kuesioner/{id}', [App\Http\Controllers\Admin\KuesionerController::class, 'update'])->name('kuesioner.update');
    Route::patch('/kuesioner/{id}', [App\Http\Controllers\Admin\KuesionerController::class, 'update']);
    Route::patch('/kuesioner/{id}/toggle', [App\Http\Controllers\Admin\KuesionerController::class, 'toggleStatus'])->name('kuesioner.toggle');
    Route::delete('/kuesioner/{id}', [App\Http\Controllers\Admin\KuesionerController::class, 'destroy'])->name('kuesioner.destroy');

    // Kriteria & Bobot (Phase 4)
    Route::get('/kriteria', [App\Http\Controllers\Admin\KriteriaController::class, 'index'])->name('kriteria.index');
    Route::get('/kriteria/create', [App\Http\Controllers\Admin\KriteriaController::class, 'create'])->name('kriteria.create');
    Route::post('/kriteria', [App\Http\Controllers\Admin\KriteriaController::class, 'store'])->name('kriteria.store');
    Route::get('/kriteria/mapping', [App\Http\Controllers\Admin\KriteriaController::class, 'mapping'])->name('kriteria.mapping');
    Route::get('/kriteria/{id}', [App\Http\Controllers\Admin\KriteriaController::class, 'show'])->name('kriteria.show');
    Route::get('/kriteria/{id}/edit', [App\Http\Controllers\Admin\KriteriaController::class, 'edit'])->name('kriteria.edit');
    Route::put('/kriteria/{id}', [App\Http\Controllers\Admin\KriteriaController::class, 'update'])->name('kriteria.update');
    Route::patch('/kriteria/{id}', [App\Http\Controllers\Admin\KriteriaController::class, 'update']);
    Route::delete('/kriteria/{id}', [App\Http\Controllers\Admin\KriteriaController::class, 'destroy'])->name('kriteria.destroy');

    // Rekomendasi & Matriks Keputusan (Phase 5A)
    Route::get('/rekomendasi', [App\Http\Controllers\Admin\RekomendasiController::class, 'index'])->name('rekomendasi.index');
    Route::get('/rekomendasi/matriks-keputusan', [App\Http\Controllers\Admin\RekomendasiController::class, 'matrixPreview'])->name('rekomendasi.matrix');
    Route::get('/rekomendasi/{id}', [App\Http\Controllers\Admin\RekomendasiController::class, 'show'])->name('rekomendasi.show');

    // Laporan
    Route::get('/laporan', [App\Http\Controllers\Admin\LaporanController::class, 'index'])->name('laporan');

    // Pengaturan (Periode)
    Route::get('/pengaturan', [App\Http\Controllers\Admin\PeriodeController::class, 'index'])->name('pengaturan');
    Route::post('/pengaturan', [App\Http\Controllers\Admin\PeriodeController::class, 'store'])->name('pengaturan.store');
    Route::put('/pengaturan/{id}', [App\Http\Controllers\Admin\PeriodeController::class, 'update'])->name('pengaturan.update');
    Route::patch('/pengaturan/{id}/toggle', [App\Http\Controllers\Admin\PeriodeController::class, 'toggleStatus'])->name('pengaturan.toggle');
});

require __DIR__.'/auth.php';
