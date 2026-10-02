@extends('layouts.admin')

@section('page-title', 'Detail Rekomendasi Siswa')

@section('content')
<div class="max-w-4xl space-y-6">

    <!-- Header & Breadcrumb -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <nav class="flex items-center gap-1 text-xs text-slate-500 mb-2">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-slate-700">Dashboard</a>
                <svg class="w-3.5 h-3.5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <a href="{{ route('admin.rekomendasi.index') }}" class="hover:text-slate-700">Rekomendasi</a>
                <svg class="w-3.5 h-3.5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <span class="text-slate-800 font-semibold">{{ $recommendation->student->user->name ?? 'Siswa' }}</span>
            </nav>
            <h1 class="text-2xl font-bold text-slate-900">Hasil Rekomendasi: {{ $recommendation->student->user->name ?? '-' }}</h1>
            <p class="text-xs text-slate-500 mt-1">
                NIS: {{ $recommendation->student->nis ?? '-' }} &middot; Kelas: {{ $recommendation->student->class_name ?? '-' }} &middot; Waktu Analisis: {{ $recommendation->created_at->translatedFormat('d M Y, H:i') }} WIB
            </p>
        </div>

        <a href="{{ route('admin.rekomendasi.index') }}" class="self-start sm:self-auto px-4 py-2 border border-slate-200 text-slate-700 hover:bg-slate-50 text-xs font-semibold rounded-lg transition-colors">
            &larr; Kembali ke Daftar
        </a>
    </div>

    <!-- Student Info Summary Card -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
        <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-3">Ringkasan Data Siswa</h3>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-xs">
            <div>
                <span class="text-slate-400 block font-semibold">Nama Siswa</span>
                <span class="text-slate-900 font-bold block mt-0.5">{{ $recommendation->student->user->name ?? '-' }}</span>
            </div>
            <div>
                <span class="text-slate-400 block font-semibold">NIS</span>
                <span class="text-slate-900 font-mono font-bold block mt-0.5">{{ $recommendation->student->nis ?? '-' }}</span>
            </div>
            <div>
                <span class="text-slate-400 block font-semibold">Kelas</span>
                <span class="text-slate-900 font-bold block mt-0.5">{{ $recommendation->student->class_name ?? '-' }}</span>
            </div>
            <div>
                <span class="text-slate-400 block font-semibold">WhatsApp Aktif</span>
                <span class="text-slate-900 font-mono font-bold block mt-0.5">{{ $recommendation->student->whatsapp ?: '-' }}</span>
            </div>
        </div>
    </div>

    <!-- Ranking Rekomendasi Cards -->
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Hasil Pemeringkatan Rekomendasi</h3>
            <span class="text-xs text-slate-400">Total: {{ $recommendation->items->count() }} Pilihan</span>
        </div>

        @forelse($recommendation->items->sortBy('rank') as $r)
        @php
        $isTop = ($r->rank === 1);
        @endphp
        <div class="bg-white rounded-xl border {{ $isTop ? 'border-blue-300 ring-2 ring-blue-500/10' : 'border-slate-200' }} shadow-sm p-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-start gap-3">
                    <span class="w-8 h-8 rounded-full {{ $isTop ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-700' }} flex items-center justify-center font-bold text-sm flex-shrink-0 mt-0.5">
                        #{{ $r->rank }}
                    </span>
                    <div>
                        <div class="flex items-center gap-2">
                            <h4 class="text-base font-bold text-slate-900">{{ $r->extracurricular->name ?? '-' }}</h4>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-slate-100 text-slate-700">
                                {{ $r->extracurricular->category ?? 'Umum' }}
                            </span>
                            @if($isTop)
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-blue-100 text-blue-700">Rekomendasi Utama</span>
                            @endif
                        </div>
                        <p class="text-xs text-slate-600 mt-1">
                            {{ $r->notes ?: ($r->extracurricular->description ?: 'Berdasarkan kesesuaian preferensi kuesioner siswa.') }}
                        </p>
                    </div>
                </div>

                <div class="text-right flex-shrink-0">
                    <span class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider block">Skor Kecocokan</span>
                    <span class="font-extrabold text-2xl font-mono text-blue-600">{{ round($r->score * 100) }}</span>
                    <span class="text-xs text-slate-400">/ 100</span>
                </div>
            </div>
        </div>
        @empty
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-8 text-center text-sm text-slate-400">
            Belum ada rincian item rekomendasi untuk data ini.
        </div>
        @endforelse
    </div>

</div>
@endsection
