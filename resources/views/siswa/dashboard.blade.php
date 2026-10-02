@extends('layouts.student')

@section('title', 'Dashboard')

@section('content')

{{-- ===================== GREETING CARD ===================== --}}
<div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl p-5 sm:p-6 text-white mb-6 shadow-sm">
    <div class="flex items-start justify-between gap-4">
        <div>
            <p class="text-blue-100 text-sm mb-1">Selamat datang kembali 👋</p>
            <h1 class="text-xl sm:text-2xl font-bold mb-1">Halo, {{ $user->name }}!</h1>
            <div class="flex flex-wrap gap-3 text-blue-100 text-sm mt-2">
                <span class="flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/></svg>
                    NIS: {{ $student->nis ?: '-' }}
                </span>
                <span class="flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    Kelas: {{ $student->class_name ?: 'Belum ditentukan' }}
                </span>
                @if($activePeriod)
                <span class="flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    Periode: {{ $activePeriod->name }}
                </span>
                @endif
            </div>
        </div>
        <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center flex-shrink-0">
            <span class="text-2xl font-bold text-white">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
        </div>
    </div>
</div>

{{-- ===================== STATUS BANNER ===================== --}}
@if($questionnaireProgress['is_complete'])
    <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-4 sm:p-5 mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-start gap-3">
            <div class="w-9 h-9 bg-emerald-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                <svg class="w-5 h-5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            </div>
            <div>
                <p class="font-semibold text-emerald-800 text-sm">Kuesioner Selesai Terisi ({{ $questionnaireProgress['answered_questions'] }} / {{ $questionnaireProgress['total_questions'] }} Pertanyaan)</p>
                <p class="text-emerald-700 text-xs mt-0.5">Terima kasih! Jawaban kuesionermu telah tersimpan di sistem.</p>
            </div>
        </div>
        <a href="{{ route('siswa.kuesioner.index') }}" class="flex-shrink-0 inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-lg transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
            Lihat / Perbarui Jawaban
        </a>
    </div>
@elseif($questionnaireProgress['status'] === 'sedang_mengisi')
    <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 sm:p-5 mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-start gap-3">
            <div class="w-9 h-9 bg-amber-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <p class="font-semibold text-amber-800 text-sm">Kuesioner Sedang Diisi ({{ $questionnaireProgress['answered_questions'] }} dari {{ $questionnaireProgress['total_questions'] }} Terjawab &mdash; {{ $questionnaireProgress['percentage'] }}%)</p>
                <p class="text-amber-700 text-xs mt-0.5">Lanjutkan pengisian kuesioner untuk menyelesaikan seluruh pertanyaan.</p>
            </div>
        </div>
        <a href="{{ route('siswa.kuesioner.index') }}" class="flex-shrink-0 inline-flex items-center gap-2 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-semibold rounded-lg transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            Lanjutkan Kuesioner
        </a>
    </div>
@elseif(! $activePeriod)
    <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 sm:p-5 mb-6 flex items-start gap-3">
        <div class="w-9 h-9 bg-slate-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
            <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div>
            <p class="font-semibold text-slate-800 text-sm">Belum Ada Periode Pendaftaran Aktif</p>
            <p class="text-slate-600 text-xs mt-0.5">Periode pendaftaran ekstrakurikuler belum dibuka oleh pihak sekolah. Pantau pengumuman resmi sekolah.</p>
        </div>
    </div>
@else
    <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 sm:p-5 mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-start gap-3">
            <div class="w-9 h-9 bg-amber-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
            </div>
            <div>
                <p class="font-semibold text-amber-800 text-sm">Kuesioner Belum Diisi</p>
                <p class="text-amber-700 text-xs mt-0.5">Isi kuesioner untuk mengidentifikasi preferensi minat dan karakteristik dirimu.</p>
            </div>
        </div>
        <a href="{{ route('siswa.kuesioner.index') }}" class="flex-shrink-0 inline-flex items-center gap-2 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-semibold rounded-lg transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            Isi Kuesioner Sekarang
        </a>
    </div>
@endif

{{-- ===================== STAT BADGES ===================== --}}
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
    {{-- Ekskul Aktif --}}
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 flex items-center gap-4">
        <div class="w-11 h-11 bg-blue-50 rounded-xl flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        </div>
        <div>
            <p class="text-xs text-slate-500 mb-0.5">Ekskul Tersedia</p>
            <p class="text-2xl font-bold text-slate-900">{{ $totalActiveEkskuls }}</p>
        </div>
    </div>

    {{-- Status Kuesioner --}}
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 flex items-center gap-4">
        <div class="w-11 h-11 {{ $questionnaireProgress['is_complete'] ? 'bg-emerald-50' : ($questionnaireProgress['status'] === 'sedang_mengisi' ? 'bg-blue-50' : 'bg-amber-50') }} rounded-xl flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6 {{ $questionnaireProgress['is_complete'] ? 'text-emerald-600' : ($questionnaireProgress['status'] === 'sedang_mengisi' ? 'text-blue-600' : 'text-amber-500') }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        </div>
        <div>
            <p class="text-xs text-slate-500 mb-0.5">Status Kuesioner</p>
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $questionnaireProgress['is_complete'] ? 'bg-emerald-100 text-emerald-700' : ($questionnaireProgress['status'] === 'sedang_mengisi' ? 'bg-blue-100 text-blue-700' : 'bg-amber-100 text-amber-700') }}">
                {{ $questionnaireProgress['status_label'] }}
            </span>
        </div>
    </div>

    {{-- Status Pendaftaran --}}
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 flex items-center gap-4">
        <div class="w-11 h-11 {{ $latestRegistration ? 'bg-blue-50' : 'bg-slate-100' }} rounded-xl flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6 {{ $latestRegistration ? 'text-blue-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
        </div>
        <div>
            <p class="text-xs text-slate-500 mb-0.5">Status Pendaftaran</p>
            @if($latestRegistration)
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">
                    {{ ucfirst($latestRegistration->status) }} &middot; {{ $latestRegistration->extracurricular?->name }}
                </span>
            @else
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-600">
                    Belum Mendaftar
                </span>
            @endif
        </div>
    </div>
</div>

{{-- ===================== REKOMENDASI TERBARU ===================== --}}
<div class="mb-6">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-base font-bold text-slate-900">Rekomendasi Terbaru</h2>
    </div>
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-8 flex flex-col items-center text-center">
        <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mb-4">
            <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
        </div>
        @if($questionnaireProgress['is_complete'])
            <h3 class="text-sm font-semibold text-slate-800 mb-1">Kuesioner Berhasil Disimpan</h3>
            <p class="text-xs text-slate-500 max-w-sm mb-4">Jawaban kuesionermu telah tersimpan. Perhitungan rekomendasi kecocokan ekstrakurikuler (algoritma SAW) akan dijalankan pada tahap sistem berikutnya.</p>
            <a href="{{ route('siswa.kuesioner.hasil') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg transition-colors">
                Lihat Ringkasan Kuesioner
            </a>
        @else
            <h3 class="text-sm font-semibold text-slate-700 mb-1">Belum Ada Rekomendasi</h3>
            <p class="text-xs text-slate-500 max-w-xs mb-5">Isi kuesioner minat dan karakteristik dirimu terlebih dahulu untuk mendapatkan rekomendasi ekstrakurikuler yang cocok.</p>
            <a href="{{ route('siswa.kuesioner.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Mulai Isi Kuesioner
            </a>
        @endif
    </div>
</div>

{{-- ===================== EKSKUL POPULER ===================== --}}
<div class="mb-6">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-base font-bold text-slate-900">Ekskul Populer</h2>
        <a href="{{ route('siswa.ekstrakurikuler.index') }}" class="text-xs font-medium text-blue-600 hover:text-blue-700">Lihat Semua →</a>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        @forelse($popularEkskuls as $e)
        <a href="{{ route('siswa.ekstrakurikuler.show', $e->id) }}" class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 flex items-start gap-4 hover:border-blue-300 transition-colors">
            <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center flex-shrink-0 font-bold text-sm">
                {{ strtoupper(substr($e->name, 0, 2)) }}
            </div>
            <div class="flex-1 min-w-0">
                <div class="flex items-start justify-between gap-2">
                    <div>
                        <p class="text-sm font-semibold text-slate-900 truncate">{{ $e->name }}</p>
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-medium bg-slate-100 text-slate-700 mt-1">{{ $e->category ?: 'Umum' }}</span>
                    </div>
                </div>
                <p class="text-xs text-slate-500 mt-1.5 line-clamp-2">{{ $e->description ?: 'Kegiatan ekstrakurikuler di lingkungan SMKN 3 Payakumbuh.' }}</p>
                <div class="flex items-center gap-1 mt-2">
                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span class="text-xs text-slate-400">{{ $e->registrations_count }} pendaftar</span>
                </div>
            </div>
        </a>
        @empty
        <div class="col-span-2 text-center py-6 text-xs text-slate-400">
            Belum ada data ekstrakurikuler aktif saat ini.
        </div>
        @endforelse
    </div>
</div>

{{-- ===================== PROFILE COMPLETION WIDGET ===================== --}}
<div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5">
    <div class="flex items-center justify-between mb-3">
        <div>
            <h3 class="text-sm font-semibold text-slate-900">Kelengkapan Profil</h3>
            <p class="text-xs text-slate-500 mt-0.5">Lengkapi profilmu untuk pengalaman terbaik</p>
        </div>
        <span class="text-2xl font-bold text-blue-600">{{ $profileCompletion }}%</span>
    </div>
    <div class="w-full bg-slate-100 rounded-full h-2 mb-4">
        <div class="bg-blue-500 h-2 rounded-full transition-all duration-500" style="width: {{ $profileCompletion }}%"></div>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
        <div class="flex items-center gap-2">
            @if($student->nis && $student->class_name)
                <div class="w-4 h-4 bg-emerald-100 rounded-full flex items-center justify-center flex-shrink-0">
                    <svg class="w-2.5 h-2.5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                </div>
                <span class="text-xs text-slate-700 font-medium">Data siswa lengkap</span>
            @else
                <div class="w-4 h-4 bg-amber-100 rounded-full flex items-center justify-center flex-shrink-0">
                    <svg class="w-2.5 h-2.5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01"/></svg>
                </div>
                <span class="text-xs text-slate-500">Data siswa</span>
            @endif
        </div>
        <div class="flex items-center gap-2">
            @if($student->whatsapp)
                <div class="w-4 h-4 bg-emerald-100 rounded-full flex items-center justify-center flex-shrink-0">
                    <svg class="w-2.5 h-2.5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                </div>
                <span class="text-xs text-slate-700 font-medium">WhatsApp terdaftar</span>
            @else
                <div class="w-4 h-4 bg-slate-100 rounded-full flex items-center justify-center flex-shrink-0">
                    <svg class="w-2.5 h-2.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </div>
                <a href="{{ route('siswa.profil') }}" class="text-xs text-blue-600 font-medium hover:underline">Tambah WhatsApp</a>
            @endif
        </div>
        <div class="flex items-center gap-2">
            @if($questionnaireProgress['is_complete'])
                <div class="w-4 h-4 bg-emerald-100 rounded-full flex items-center justify-center flex-shrink-0">
                    <svg class="w-2.5 h-2.5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                </div>
                <span class="text-xs text-slate-700 font-medium">Kuesioner terisi</span>
            @else
                <div class="w-4 h-4 bg-slate-100 rounded-full flex items-center justify-center flex-shrink-0">
                    <svg class="w-2.5 h-2.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </div>
                <a href="{{ route('siswa.kuesioner.index') }}" class="text-xs text-blue-600 font-medium hover:underline">Isi kuesioner</a>
            @endif
        </div>
    </div>
</div>

@endsection
