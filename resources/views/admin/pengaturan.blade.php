@extends('layouts.admin')
@section('page-title', 'Pengaturan Periode')
@section('content')
<div class="max-w-3xl space-y-6">

    <!-- Page Header -->
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Pengaturan Periode Pendaftaran</h1>
        <p class="mt-1 text-sm text-slate-500">Kelola periode pendaftaran ekstrakurikuler</p>
    </div>

    <!-- [PERLU KONFIRMASI] Notice -->
    <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 flex items-start gap-3">
        <svg class="w-5 h-5 text-amber-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
        <div>
            <p class="text-sm font-medium text-amber-800">[PERLU KONFIRMASI] Aturan Periode Aktual</p>
            <p class="text-sm text-amber-700 mt-0.5">Mekanisme pembukaan/penutupan periode pendaftaran, tanggal aktual, dan aturan terkait dapat disesuaikan kembali dengan pihak sekolah.</p>
        </div>
    </div>

    <!-- Current Period Card -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
        @if($activePeriod)
            <div class="flex items-start justify-between gap-4 mb-5">
                <div>
                    <p class="text-xs font-medium text-slate-500 uppercase tracking-wider mb-1">Periode Aktif</p>
                    <h3 class="text-lg font-bold text-slate-900">{{ $activePeriod->name }}</h3>
                </div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-sm font-medium bg-emerald-100 text-emerald-700">
                    <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span>
                    DIBUKA
                </span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                <div class="bg-slate-50 rounded-lg p-4">
                    <p class="text-xs text-slate-500 mb-1">Tahun Pelajaran</p>
                    <p class="text-sm font-medium text-slate-900">{{ $activePeriod->school_year }}</p>
                </div>
                <div class="bg-slate-50 rounded-lg p-4">
                    <p class="text-xs text-slate-500 mb-1">Tanggal Mulai</p>
                    <p class="text-sm font-medium text-slate-900">{{ \Carbon\Carbon::parse($activePeriod->start_date)->translatedFormat('d F Y') }}</p>
                </div>
                <div class="bg-slate-50 rounded-lg p-4">
                    <p class="text-xs text-slate-500 mb-1">Tanggal Selesai</p>
                    <p class="text-sm font-medium text-slate-900">{{ \Carbon\Carbon::parse($activePeriod->end_date)->translatedFormat('d F Y') }}</p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <form method="POST" action="{{ route('admin.pengaturan.toggle', $activePeriod->id) }}">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                        Tutup Pendaftaran
                    </button>
                </form>
                <p class="text-xs text-slate-500">Menutup pendaftaran akan menghentikan pengajuan pendaftaran baru</p>
            </div>
        @else
            <div class="py-6 text-center">
                <p class="text-sm font-semibold text-slate-700">Tidak ada periode pendaftaran aktif saat ini</p>
                <p class="text-xs text-slate-500 mt-1">Buat periode baru atau aktifkan salah satu periode dari riwayat di bawah.</p>
            </div>
        @endif
    </div>

    <!-- Edit / Create Period Form -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
        <h3 class="text-base font-semibold text-slate-900 mb-5">
            {{ $activePeriod ? 'Perbarui Periode Aktif' : 'Tambah Periode Pendaftaran' }}
        </h3>
        <form class="space-y-5" method="POST" action="{{ $activePeriod ? route('admin.pengaturan.update', $activePeriod->id) : route('admin.pengaturan.store') }}">
            @csrf
            @if($activePeriod)
                @method('PUT')
            @endif

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Nama Periode <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name', $activePeriod->name ?? 'TP 2026/2027 - Semester Ganjil') }}" required
                    class="block w-full rounded-lg border @error('name') border-red-500 bg-red-50 @else border-slate-200 @enderror px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500" />
                @error('name')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Tahun Pelajaran <span class="text-red-500">*</span></label>
                <input type="text" name="school_year" value="{{ old('school_year', $activePeriod->school_year ?? '2026/2027') }}" required
                    class="block w-full rounded-lg border @error('school_year') border-red-500 bg-red-50 @else border-slate-200 @enderror px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500" />
                @error('school_year')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Tanggal Mulai <span class="text-red-500">*</span></label>
                    <input type="date" name="start_date" value="{{ old('start_date', $activePeriod ? \Carbon\Carbon::parse($activePeriod->start_date)->format('Y-m-d') : '2026-08-01') }}" required
                        class="block w-full rounded-lg border @error('start_date') border-red-500 bg-red-50 @else border-slate-200 @enderror px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500" />
                    @error('start_date')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Tanggal Selesai <span class="text-red-500">*</span></label>
                    <input type="date" name="end_date" value="{{ old('end_date', $activePeriod ? \Carbon\Carbon::parse($activePeriod->end_date)->format('Y-m-d') : '2026-09-30') }}" required
                        class="block w-full rounded-lg border @error('end_date') border-red-500 bg-red-50 @else border-slate-200 @enderror px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500" />
                    @error('end_date')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="flex items-center gap-3">
                <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                    {{ $activePeriod ? 'Simpan Perubahan' : 'Tambah Periode' }}
                </button>
            </div>
        </form>
    </div>

    <!-- Riwayat Periode -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <h3 class="text-base font-semibold text-slate-900">Riwayat Periode</h3>
            <span class="text-xs text-slate-400">Total: {{ count($periods ?? []) }} periode</span>
        </div>
        <div class="divide-y divide-slate-100">
            @forelse($periods ?? [] as $r)
            <div class="flex items-center justify-between px-6 py-4 hover:bg-slate-50 transition-colors">
                <div>
                    <p class="text-sm font-medium text-slate-900">{{ $r->name }} ({{ $r->school_year }})</p>
                    <p class="text-xs text-slate-500 mt-0.5">
                        {{ \Carbon\Carbon::parse($r->start_date)->translatedFormat('d M Y') }} &mdash; {{ \Carbon\Carbon::parse($r->end_date)->translatedFormat('d M Y') }}
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    @if($r->is_active)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">
                            Aktif
                        </span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-600">
                            Nonaktif
                        </span>
                        <form method="POST" action="{{ route('admin.pengaturan.toggle', $r->id) }}" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="text-xs font-semibold text-blue-600 hover:text-blue-800">
                                Aktifkan
                            </button>
                        </form>
                    @endif
                </div>
            </div>
            @empty
            <div class="px-6 py-8 text-center text-slate-400 text-sm">
                Belum ada data periode.
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
