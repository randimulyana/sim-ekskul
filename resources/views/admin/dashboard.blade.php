@extends('layouts.admin')
@section('page-title', 'Dashboard')
@section('content')
<!-- DATA DEMO: data di halaman ini adalah contoh untuk keperluan pengembangan sistem -->
<div class="space-y-6">

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Dashboard</h1>
            <p class="mt-1 text-sm text-slate-500">Selamat datang, Admin &mdash; SMK Negeri 3 Payakumbuh</p>
        </div>
        <span class="inline-flex items-center gap-1.5 text-xs text-slate-500 bg-slate-100 px-3 py-1.5 rounded-lg self-start">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            Jumat, 2 Oktober 2026
        </span>
    </div>

    {{-- Stat Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        {{-- Total Siswa --}}
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Total Siswa</p>
                    <p class="mt-1 text-3xl font-bold text-slate-900">{{ $totalStudents ?? 0 }}</p>
                    <p class="mt-1 text-xs text-slate-500">Terdata di sistem</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
            </div>
        </div>

        {{-- Total Ekskul --}}
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Total Ekstrakurikuler</p>
                    <p class="mt-1 text-3xl font-bold text-slate-900">{{ $totalExtracurriculars ?? 0 }}</p>
                    <p class="mt-1 text-xs text-slate-500">Aktif periode ini</p>
                </div>
                <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                </div>
            </div>
        </div>

        {{-- Total Pendaftar --}}
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Total Pendaftar</p>
                    <p class="mt-1 text-3xl font-bold text-slate-900">{{ $totalRegistrations ?? 0 }}</p>
                    <p class="mt-1 text-xs text-slate-500">Periode aktif</p>
                </div>
                <div class="w-12 h-12 bg-amber-100 text-amber-600 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
            </div>
        </div>

        {{-- Pending --}}
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Pendaftaran Pending</p>
                    <p class="mt-1 text-3xl font-bold text-slate-900">{{ $pendingRegistrations ?? 0 }}</p>
                    <p class="mt-1 text-xs text-amber-600 font-medium">Menunggu tinjau</p>
                </div>
                <div class="w-12 h-12 bg-red-100 text-red-600 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Period Alert --}}
    @if(isset($activePeriod) && $activePeriod)
    <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-4 flex items-center gap-3">
        <div class="w-2.5 h-2.5 bg-emerald-500 rounded-full flex-shrink-0 animate-pulse"></div>
        <div class="flex-1 min-w-0">
            <p class="text-sm font-semibold text-emerald-800">Periode Pendaftaran Aktif: {{ $activePeriod->name }}</p>
            <p class="text-xs text-emerald-600 mt-0.5">{{ $activePeriod->school_year }} &mdash; Dibuka sejak {{ \Carbon\Carbon::parse($activePeriod->start_date)->translatedFormat('j F Y') }} &middot; Ditutup {{ \Carbon\Carbon::parse($activePeriod->end_date)->translatedFormat('j F Y') }}</p>
        </div>
        <a href="/admin/pengaturan" class="text-xs text-emerald-700 font-semibold hover:underline whitespace-nowrap">Kelola Periode</a>
    </div>
    @else
    <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 flex items-center gap-3">
        <div class="w-2.5 h-2.5 bg-amber-500 rounded-full flex-shrink-0"></div>
        <div class="flex-1 min-w-0">
            <p class="text-sm font-semibold text-amber-800">Tidak ada periode pendaftaran aktif</p>
            <p class="text-xs text-amber-600 mt-0.5">Aktifkan periode pendaftaran agar siswa dapat mendaftar ekstrakurikuler.</p>
        </div>
        <a href="/admin/pengaturan" class="text-xs text-amber-700 font-semibold hover:underline whitespace-nowrap">Atur Periode</a>
    </div>
    @endif

    {{-- Two Column Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Pendaftaran Terbaru --}}
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm">
            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                <h3 class="text-base font-semibold text-slate-900">Pendaftaran Terbaru</h3>
                <a href="/admin/pendaftaran" class="text-sm text-blue-600 hover:text-blue-700 font-medium">Lihat semua</a>
            </div>
            <div class="divide-y divide-slate-100">
                @php
                $statusColors = [
                    'accepted'  => 'bg-emerald-100 text-emerald-700',
                    'reviewed'  => 'bg-amber-100 text-amber-700',
                    'submitted' => 'bg-blue-100 text-blue-700',
                    'rejected'  => 'bg-red-100 text-red-700',
                    'cancelled' => 'bg-slate-100 text-slate-700',
                ];
                $statusLabels = [
                    'accepted'  => 'Diterima',
                    'reviewed'  => 'Ditinjau',
                    'submitted' => 'Terkirim',
                    'rejected'  => 'Ditolak',
                    'cancelled' => 'Dibatalkan',
                ];
                @endphp
                @forelse($recentRegistrations ?? [] as $p)
                <div class="flex items-center justify-between px-6 py-3.5 hover:bg-slate-50 transition-colors">
                    <div class="min-w-0">
                        <p class="text-sm font-medium text-slate-900 truncate">{{ $p->student->user->name ?? '-' }}</p>
                        <p class="text-xs text-slate-500 mt-0.5">{{ $p->student->class_name ?? '-' }} &middot; {{ $p->extracurricular->name ?? '-' }}</p>
                    </div>
                    <span class="ml-3 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$p->status] ?? 'bg-slate-100 text-slate-700' }}">
                        {{ $statusLabels[$p->status] ?? ucfirst($p->status) }}
                    </span>
                </div>
                @empty
                <div class="px-6 py-8 text-center text-sm text-slate-400">
                    Belum ada pendaftaran yang masuk.
                </div>
                @endforelse
            </div>
            <div class="px-6 py-3 border-t border-slate-100 bg-slate-50 rounded-b-xl">
                <a href="/admin/pendaftaran" class="text-xs text-slate-500 hover:text-blue-600 transition-colors">Tampilkan selengkapnya &rarr;</a>
            </div>
        </div>

        {{-- Ekskul Stats --}}
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm">
            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                <h3 class="text-base font-semibold text-slate-900">Pendaftar per Ekskul</h3>
                <a href="/admin/laporan" class="text-sm text-blue-600 hover:text-blue-700 font-medium">Detail</a>
            </div>
            <div class="px-6 py-4 space-y-4">
                @php
                $barColors = ['bg-blue-500', 'bg-emerald-500', 'bg-amber-500', 'bg-purple-500', 'bg-sky-500', 'bg-red-500'];
                @endphp
                @forelse($ekskulStats ?? [] as $index => $e)
                <div>
                    <div class="flex items-center justify-between text-sm mb-1.5">
                        <span class="font-medium text-slate-700">{{ $e->name }}</span>
                        <span class="text-slate-500 text-xs">{{ $e->registrations_count }} pendaftar</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-2">
                        <div class="{{ $barColors[$index % count($barColors)] }} h-2 rounded-full transition-all" style="width: {{ $e->percentage ?? 0 }}%"></div>
                    </div>
                </div>
                @empty
                <div class="py-8 text-center text-sm text-slate-400">
                    Belum ada data pendaftar per ekstrakurikuler.
                </div>
                @endforelse
            </div>
            <div class="px-6 py-3 border-t border-slate-100 bg-slate-50 rounded-b-xl">
                <p class="text-xs text-slate-400">Data berdasarkan pendaftaran terdata</p>
            </div>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
        <h3 class="text-base font-semibold text-slate-900 mb-4">Aksi Cepat</h3>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
            <a href="/admin/siswa/create" class="flex flex-col items-center gap-2 p-4 rounded-xl border border-slate-200 hover:border-blue-300 hover:bg-blue-50 transition-all group">
                <div class="w-10 h-10 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                </div>
                <span class="text-xs font-medium text-slate-700 text-center">Tambah Siswa</span>
            </a>
            <a href="/admin/ekstrakurikuler/create" class="flex flex-col items-center gap-2 p-4 rounded-xl border border-slate-200 hover:border-emerald-300 hover:bg-emerald-50 transition-all group">
                <div class="w-10 h-10 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center group-hover:bg-emerald-600 group-hover:text-white transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                </div>
                <span class="text-xs font-medium text-slate-700 text-center">Tambah Ekskul</span>
            </a>
            <a href="/admin/pendaftaran" class="flex flex-col items-center gap-2 p-4 rounded-xl border border-slate-200 hover:border-amber-300 hover:bg-amber-50 transition-all group">
                <div class="w-10 h-10 bg-amber-100 text-amber-600 rounded-xl flex items-center justify-center group-hover:bg-amber-600 group-hover:text-white transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                </div>
                <span class="text-xs font-medium text-slate-700 text-center">Kelola Pendaftaran</span>
            </a>
            <a href="/admin/laporan" class="flex flex-col items-center gap-2 p-4 rounded-xl border border-slate-200 hover:border-purple-300 hover:bg-purple-50 transition-all group">
                <div class="w-10 h-10 bg-purple-100 text-purple-600 rounded-xl flex items-center justify-center group-hover:bg-purple-600 group-hover:text-white transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <span class="text-xs font-medium text-slate-700 text-center">Lihat Laporan</span>
            </a>
        </div>
    </div>

</div>
@endsection
