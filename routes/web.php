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
// STUDENT ROUTES (Protected with auth + role:student)
// ============================================================
Route::prefix('siswa')->name('siswa.')->middleware(['auth', 'role:student'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Student\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profil', [App\Http\Controllers\Student\ProfileController::class, 'show'])->name('profil');
    Route::put('/profil', [App\Http\Controllers\Student\ProfileController::class, 'update'])->name('profil.update');

    // Extracurricular catalog
    Route::get('/ekstrakurikuler', [App\Http\Controllers\Student\ExtracurricularController::class, 'index'])->name('ekstrakurikuler.index');
    Route::get('/ekstrakurikuler/{id}', [App\Http\Controllers\Student\ExtracurricularController::class, 'show'])->name('ekstrakurikuler.show');

    // Questionnaire
    Route::get('/kuesioner', [App\Http\Controllers\Student\QuestionnaireController::class, 'index'])->name('kuesioner.index');
    Route::post('/kuesioner', [App\Http\Controllers\Student\QuestionnaireController::class, 'store'])->name('kuesioner.store');
    Route::get('/kuesioner/analisis', [App\Http\Controllers\Student\QuestionnaireController::class, 'analisis'])->name('kuesioner.analisis');
    Route::get('/kuesioner/hasil', [App\Http\Controllers\Student\QuestionnaireController::class, 'hasil'])->name('kuesioner.hasil');

    // Recommendation (SAW Recommendation Engine)
    Route::get('/rekomendasi', [App\Http\Controllers\Student\RecommendationController::class, 'index'])->name('rekomendasi.index');
    Route::get('/rekomendasi/{id}', [App\Http\Controllers\Student\RecommendationController::class, 'show'])->name('rekomendasi.show');

    // Registration (Prototype views preserved for Phase 6)
    Route::get('/pendaftaran', fn () => view('siswa.pendaftaran.index'))->name('pendaftaran.index');
    Route::post('/pendaftaran', fn () => redirect()->route('siswa.pendaftaran.sukses'))->name('pendaftaran.store');
    Route::get('/pendaftaran/sukses', fn () => view('siswa.pendaftaran.sukses'))->name('pendaftaran.sukses');

    // History
    Route::get('/riwayat', fn () => view('siswa.riwayat'))->name('riwayat');
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
    Route::get('/siswa', [App\Http\Controllers\Admin\StudentController::class, 'index'])->name('siswa.index');
    Route::get('/siswa/create', [App\Http\Controllers\Admin\StudentController::class, 'create'])->name('siswa.create');
    Route::post('/siswa', [App\Http\Controllers\Admin\StudentController::class, 'store'])->name('siswa.store');
    Route::get('/siswa/{id}', [App\Http\Controllers\Admin\StudentController::class, 'show'])->name('siswa.show');
    Route::get('/siswa/{id}/edit', [App\Http\Controllers\Admin\StudentController::class, 'edit'])->name('siswa.edit');
    Route::put('/siswa/{id}', [App\Http\Controllers\Admin\StudentController::class, 'update'])->name('siswa.update');
    Route::patch('/siswa/{id}', [App\Http\Controllers\Admin\StudentController::class, 'update']);
    Route::delete('/siswa/{id}', [App\Http\Controllers\Admin\StudentController::class, 'destroy'])->name('siswa.destroy');

    // Ekstrakurikuler
    Route::get('/ekstrakurikuler', [App\Http\Controllers\Admin\ExtracurricularController::class, 'index'])->name('ekstrakurikuler.index');
    Route::get('/ekstrakurikuler/create', [App\Http\Controllers\Admin\ExtracurricularController::class, 'create'])->name('ekstrakurikuler.create');
    Route::post('/ekstrakurikuler', [App\Http\Controllers\Admin\ExtracurricularController::class, 'store'])->name('ekstrakurikuler.store');
    Route::get('/ekstrakurikuler/{id}', [App\Http\Controllers\Admin\ExtracurricularController::class, 'show'])->name('ekstrakurikuler.show');
    Route::get('/ekstrakurikuler/{id}/edit', [App\Http\Controllers\Admin\ExtracurricularController::class, 'edit'])->name('ekstrakurikuler.edit');
    Route::put('/ekstrakurikuler/{id}', [App\Http\Controllers\Admin\ExtracurricularController::class, 'update'])->name('ekstrakurikuler.update');
    Route::patch('/ekstrakurikuler/{id}', [App\Http\Controllers\Admin\ExtracurricularController::class, 'update']);
    Route::delete('/ekstrakurikuler/{id}', [App\Http\Controllers\Admin\ExtracurricularController::class, 'destroy'])->name('ekstrakurikuler.destroy');

    // Pendaftaran
    Route::get('/pendaftaran', [App\Http\Controllers\Admin\RegistrationController::class, 'index'])->name('pendaftaran.index');
    Route::get('/pendaftaran/{id}', [App\Http\Controllers\Admin\RegistrationController::class, 'show'])->name('pendaftaran.show');
    Route::put('/pendaftaran/{id}/status', [App\Http\Controllers\Admin\RegistrationController::class, 'updateStatus'])->name('pendaftaran.update-status');
    Route::patch('/pendaftaran/{id}/status', [App\Http\Controllers\Admin\RegistrationController::class, 'updateStatus']);
    Route::post('/pendaftaran/{id}/status', [App\Http\Controllers\Admin\RegistrationController::class, 'updateStatus']);
    Route::put('/pendaftaran/{id}', [App\Http\Controllers\Admin\RegistrationController::class, 'updateStatus'])->name('pendaftaran.update');

    // Kuesioner
    Route::get('/kuesioner', [App\Http\Controllers\Admin\QuestionnaireController::class, 'index'])->name('kuesioner.index');
    Route::get('/kuesioner/create', [App\Http\Controllers\Admin\QuestionnaireController::class, 'create'])->name('kuesioner.create');
    Route::post('/kuesioner', [App\Http\Controllers\Admin\QuestionnaireController::class, 'store'])->name('kuesioner.store');
    Route::get('/kuesioner/{id}/edit', [App\Http\Controllers\Admin\QuestionnaireController::class, 'edit'])->name('kuesioner.edit');
    Route::put('/kuesioner/{id}', [App\Http\Controllers\Admin\QuestionnaireController::class, 'update'])->name('kuesioner.update');
    Route::patch('/kuesioner/{id}', [App\Http\Controllers\Admin\QuestionnaireController::class, 'update']);
    Route::patch('/kuesioner/{id}/toggle', [App\Http\Controllers\Admin\QuestionnaireController::class, 'toggleStatus'])->name('kuesioner.toggle');
    Route::delete('/kuesioner/{id}', [App\Http\Controllers\Admin\QuestionnaireController::class, 'destroy'])->name('kuesioner.destroy');

    // Kriteria & Bobot (Phase 4)
    Route::get('/kriteria', [App\Http\Controllers\Admin\CriterionController::class, 'index'])->name('kriteria.index');
    Route::get('/kriteria/create', [App\Http\Controllers\Admin\CriterionController::class, 'create'])->name('kriteria.create');
    Route::post('/kriteria', [App\Http\Controllers\Admin\CriterionController::class, 'store'])->name('kriteria.store');
    Route::get('/kriteria/mapping', [App\Http\Controllers\Admin\CriterionController::class, 'mapping'])->name('kriteria.mapping');
    Route::get('/kriteria/{id}', [App\Http\Controllers\Admin\CriterionController::class, 'show'])->name('kriteria.show');
    Route::get('/kriteria/{id}/edit', [App\Http\Controllers\Admin\CriterionController::class, 'edit'])->name('kriteria.edit');
    Route::put('/kriteria/{id}', [App\Http\Controllers\Admin\CriterionController::class, 'update'])->name('kriteria.update');
    Route::patch('/kriteria/{id}', [App\Http\Controllers\Admin\CriterionController::class, 'update']);
    Route::delete('/kriteria/{id}', [App\Http\Controllers\Admin\CriterionController::class, 'destroy'])->name('kriteria.destroy');

    // Rekomendasi & Matriks Keputusan (Phase 5A)
    Route::get('/rekomendasi', [App\Http\Controllers\Admin\RecommendationController::class, 'index'])->name('rekomendasi.index');
    Route::get('/rekomendasi/matriks-keputusan', [App\Http\Controllers\Admin\RecommendationController::class, 'matrixPreview'])->name('rekomendasi.matrix');
    Route::get('/rekomendasi/{id}', [App\Http\Controllers\Admin\RecommendationController::class, 'show'])->name('rekomendasi.show');

    // Laporan
    Route::get('/laporan', [App\Http\Controllers\Admin\ReportController::class, 'index'])->name('laporan');

    // Pengaturan (Periode)
    Route::get('/pengaturan', [App\Http\Controllers\Admin\PeriodController::class, 'index'])->name('pengaturan');
    Route::post('/pengaturan', [App\Http\Controllers\Admin\PeriodController::class, 'store'])->name('pengaturan.store');
    Route::put('/pengaturan/{id}', [App\Http\Controllers\Admin\PeriodController::class, 'update'])->name('pengaturan.update');
    Route::patch('/pengaturan/{id}/toggle', [App\Http\Controllers\Admin\PeriodController::class, 'toggleStatus'])->name('pengaturan.toggle');
});

require __DIR__.'/auth.php';
