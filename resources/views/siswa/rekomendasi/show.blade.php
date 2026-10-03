@extends('layouts.student')

@section('title', 'Detail Rekomendasi Ekstrakurikuler')

@section('content')
@php
$name = $rankItem['name'] ?? $extracurricular?->name ?? 'Ekstrakurikuler';
$category = $rankItem['category'] ?? $extracurricular?->category ?? 'Umum';
$score = isset($rankItem['preference_score']) ? round($rankItem['preference_score'] * 100) : null;
$rank = $rankItem['rank'] ?? null;
$description = $extracurricular?->description ?? 'Kegiatan ekstrakurikuler terdaftar di SMK Negeri 3 Payakumbuh.';
$schedule = $extracurricular?->schedule_info ?? 'Jadwal akan diumumkan oleh pembina';
$location = $extracurricular?->location_info ?? 'Lingkungan Sekolah SMKN 3 Payakumbuh';
$coach = $extracurricular?->coach_name ?? 'Pembina Terdaftar';
@endphp

<div class="max-w-4xl mx-auto space-y-6">

    <!-- Back Button -->
    <div>
        <a href="{{ route('siswa.rekomendasi.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-slate-800 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Daftar Rekomendasi
        </a>
    </div>

    <!-- Main Card -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <!-- Top Banner -->
        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 p-6 sm:p-8 text-white">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <span class="inline-block px-3 py-1 bg-white/20 backdrop-blur-sm rounded-full text-xs font-semibold uppercase tracking-wider text-blue-100 mb-2">
                        {{ $category }}
                    </span>
                    <h1 class="text-2xl sm:text-3xl font-extrabold">{{ $name }}</h1>
                    <p class="text-blue-100 text-xs sm:text-sm mt-1">Detail Analisis Kesesuaian Kuesioner Minat Siswa (Metode SAW)</p>
                </div>
                <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl px-5 py-3 text-center sm:text-right">
                    @if($rank)
                        <p class="text-xs text-blue-200 font-semibold uppercase">Peringkat #{{ $rank }} &middot; Skor</p>
                        <p class="text-3xl font-extrabold text-white mt-0.5">{{ $score }} <span class="text-sm font-normal text-blue-200">/ 100</span></p>
                    @elseif($score !== null)
                        <p class="text-xs text-blue-200 font-semibold uppercase">Skor Kecocokan</p>
                        <p class="text-3xl font-extrabold text-white mt-0.5">{{ $score }} <span class="text-sm font-normal text-blue-200">/ 100</span></p>
                    @else
                        <p class="text-xs text-blue-200 font-semibold uppercase">Status Rekomendasi</p>
                        <p class="text-lg font-bold text-white mt-0.5">Belum Dihitung</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="p-6 sm:p-8 space-y-8">
            <!-- Penjelasan Mengapa Cocok -->
            <div>
                <h2 class="text-base font-bold text-slate-900 mb-2">Deskripsi Ekstrakurikuler</h2>
                <p class="text-sm text-slate-600 leading-relaxed bg-slate-50 p-4 rounded-xl border border-slate-200/70">{{ $description }}</p>
            </div>

            <!-- Analisis Kriteria jika rankItem tersedia -->
            @if(!empty($rankItem['criteria_breakdown']))
            <div>
                <h2 class="text-base font-bold text-slate-900 mb-3">Rincian Nilai Terbobot Kriteria (Metode SAW)</h2>
                <div class="grid grid-cols-1 sm:grid-cols-5 gap-3">
                    @foreach($rankItem['criteria_breakdown'] as $code => $bd)
                    <div class="p-3 bg-slate-50 border border-slate-200 rounded-lg text-center">
                        <span class="text-xs font-bold text-blue-700 block">{{ $code }}</span>
                        <span class="text-sm font-black text-slate-800 mt-1 block">v = {{ number_format($bd['v'], 3) }}</span>
                        <span class="text-[10px] text-slate-400 block mt-0.5">r: {{ number_format($bd['r'], 2) }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
            @else
            <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 text-xs text-slate-600">
                <span class="font-bold text-slate-800">Status Rekomendasi:</span> Rincian nilai kriteria untuk ekstrakurikuler ini belum tersedia. Silakan lengkapi pengisian kuesioner pada periode aktif untuk melihat analisis kecocokan SAW.
            </div>
            @endif

            <!-- Ringkasan Kegiatan Ekskul -->
            <div>
                <h2 class="text-base font-bold text-slate-900 mb-3">Informasi Jadwal &amp; Pembina</h2>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-xs">
                    <div class="p-3.5 bg-slate-50 rounded-lg border border-slate-200/70">
                        <span class="text-slate-400 font-semibold block uppercase">Jadwal Latihan</span>
                        <span class="text-slate-800 font-bold mt-1 block">{{ $schedule }}</span>
                    </div>
                    <div class="p-3.5 bg-slate-50 rounded-lg border border-slate-200/70">
                        <span class="text-slate-400 font-semibold block uppercase">Lokasi</span>
                        <span class="text-slate-800 font-bold mt-1 block">{{ $location }}</span>
                    </div>
                    <div class="p-3.5 bg-slate-50 rounded-lg border border-slate-200/70">
                        <span class="text-slate-400 font-semibold block uppercase">Nama Pembina</span>
                        <span class="text-slate-800 font-bold mt-1 block">{{ $coach }}</span>
                    </div>
                </div>
            </div>

            <!-- Catatan Batasan -->
            <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 text-xs text-amber-900">
                <span class="font-bold">Batasan Rekomendasi:</span> Hasil ini adalah instrumen bantu pertimbangan. Pilihan ekstrakurikuler sepenuhnya merupakan hak siswa secara sadar sesuai dengan minat yang ingin dikembangkan di SMK Negeri 3 Payakumbuh.
            </div>

            <!-- Action buttons -->
            <div class="pt-4 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                <a href="{{ isset($extracurricular) ? route('siswa.ekstrakurikuler.show', $extracurricular->id) : route('siswa.ekstrakurikuler.index') }}" class="text-xs font-semibold text-slate-600 hover:text-slate-900">
                    &larr; Lihat Selengkapnya di Profil Ekskul
                </a>
                <a href="{{ route('siswa.pendaftaran.index', ['ekskul_id' => $extracurricular->id]) }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow-sm transition-colors">
                    <span>Pilih dan Ajukan Pendaftaran</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            </div>
        </div>
    </div>

</div>
@endsection
