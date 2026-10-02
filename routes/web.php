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
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// ============================================================
// Breeze Profile Routes (kept untouched)
// ============================================================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ============================================================
// STUDENT ROUTES (UI only - no auth middleware for now)
// ============================================================
Route::prefix('siswa')->name('siswa.')->group(function () {
    Route::get('/dashboard', fn () => view('siswa.dashboard'))->name('dashboard');
    Route::get('/profil', fn () => view('siswa.profil'))->name('profil');

    // Extracurricular catalog
    Route::get('/ekstrakurikuler', fn () => view('siswa.ekstrakurikuler.index'))->name('ekstrakurikuler.index');
    Route::get('/ekstrakurikuler/{id}', fn ($id) => view('siswa.ekstrakurikuler.show', ['id' => $id]))->name('ekstrakurikuler.show');

    // Questionnaire
    Route::get('/kuesioner', fn () => view('siswa.kuesioner.index'))->name('kuesioner.index');
    Route::get('/kuesioner/analisis', fn () => view('siswa.kuesioner.analisis'))->name('kuesioner.analisis');
    Route::get('/kuesioner/hasil', fn () => view('siswa.kuesioner.hasil'))->name('kuesioner.hasil');

    // Recommendation
    Route::get('/rekomendasi', fn () => view('siswa.rekomendasi.index'))->name('rekomendasi.index');
    Route::get('/rekomendasi/{id}', fn ($id) => view('siswa.rekomendasi.show', ['id' => $id]))->name('rekomendasi.show');

    // Registration
    Route::get('/pendaftaran', fn () => view('siswa.pendaftaran.index'))->name('pendaftaran.index');
    Route::post('/pendaftaran', fn () => redirect()->route('siswa.pendaftaran.sukses'))->name('pendaftaran.store');
    Route::get('/pendaftaran/sukses', fn () => view('siswa.pendaftaran.sukses'))->name('pendaftaran.sukses');

    // History
    Route::get('/riwayat', fn () => view('siswa.riwayat'))->name('riwayat');
});

// ============================================================
// ADMIN ROUTES (UI only - no auth middleware for now)
// ============================================================
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', fn () => view('admin.dashboard'))->name('dashboard');
    Route::get('/profil', fn () => view('admin.profil'))->name('profil');

    // Siswa (Students)
    Route::get('/siswa', fn () => view('admin.siswa.index'))->name('siswa.index');
    Route::get('/siswa/create', fn () => view('admin.siswa.create'))->name('siswa.create');
    Route::get('/siswa/{id}', fn ($id) => view('admin.siswa.show', ['id' => $id]))->name('siswa.show');
    Route::get('/siswa/{id}/edit', fn ($id) => view('admin.siswa.edit', ['id' => $id]))->name('siswa.edit');

    // Ekstrakurikuler
    Route::get('/ekstrakurikuler', fn () => view('admin.ekstrakurikuler.index'))->name('ekstrakurikuler.index');
    Route::get('/ekstrakurikuler/create', fn () => view('admin.ekstrakurikuler.create'))->name('ekstrakurikuler.create');
    Route::get('/ekstrakurikuler/{id}', fn ($id) => view('admin.ekstrakurikuler.show', ['id' => $id]))->name('ekstrakurikuler.show');
    Route::get('/ekstrakurikuler/{id}/edit', fn ($id) => view('admin.ekstrakurikuler.edit', ['id' => $id]))->name('ekstrakurikuler.edit');

    // Pendaftaran
    Route::get('/pendaftaran', fn () => view('admin.pendaftaran.index'))->name('pendaftaran.index');
    Route::get('/pendaftaran/{id}', fn ($id) => view('admin.pendaftaran.show', ['id' => $id]))->name('pendaftaran.show');

    // Kuesioner
    Route::get('/kuesioner', fn () => view('admin.kuesioner.index'))->name('kuesioner.index');
    Route::get('/kuesioner/create', fn () => view('admin.kuesioner.create'))->name('kuesioner.create');
    Route::get('/kuesioner/{id}/edit', fn ($id) => view('admin.kuesioner.edit', ['id' => $id]))->name('kuesioner.edit');

    // Rekomendasi
    Route::get('/rekomendasi', fn () => view('admin.rekomendasi.index'))->name('rekomendasi.index');
    Route::get('/rekomendasi/{id}', fn ($id) => view('admin.rekomendasi.show', ['id' => $id]))->name('rekomendasi.show');

    // Laporan
    Route::get('/laporan', fn () => view('admin.laporan'))->name('laporan');

    // Pengaturan (Periode)
    Route::get('/pengaturan', fn () => view('admin.pengaturan'))->name('pengaturan');
});

require __DIR__.'/auth.php';
