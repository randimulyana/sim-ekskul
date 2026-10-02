@extends('layouts.admin')
@section('page-title', 'Pengaturan Periode')
@section('content')
<!-- DATA DEMO: data di halaman ini adalah contoh untuk keperluan pengembangan sistem -->
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
            <p class="text-sm text-amber-700 mt-0.5">Mekanisme pembukaan/penutupan periode pendaftaran, tanggal aktual, dan aturan terkait belum dikonfirmasi dengan pihak sekolah. Data yang ditampilkan merupakan data demo.</p>
        </div>
    </div>

    <!-- Current Period Card -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
        <div class="flex items-start justify-between gap-4 mb-5">
            <div>
                <p class="text-xs font-medium text-slate-500 uppercase tracking-wider mb-1">Periode Aktif</p>
                <h3 class="text-lg font-bold text-slate-900">Tahun Pelajaran 2026/2027</h3>
            </div>
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-sm font-medium bg-emerald-100 text-emerald-700">
                <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                DIBUKA
            </span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
            <div class="bg-slate-50 rounded-lg p-4">
                <p class="text-xs text-slate-500 mb-1">Nama Periode</p>
                <p class="text-sm font-medium text-slate-900">TP 2026/2027 - Semester Ganjil</p>
            </div>
            <div class="bg-slate-50 rounded-lg p-4">
                <p class="text-xs text-slate-500 mb-1">Tanggal Mulai</p>
                <p class="text-sm font-medium text-slate-900">1 Agustus 2026</p>
            </div>
            <div class="bg-slate-50 rounded-lg p-4">
                <p class="text-xs text-slate-500 mb-1">Tanggal Selesai</p>
                <p class="text-sm font-medium text-slate-900">30 September 2026</p>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <button class="inline-flex items-center gap-2 px-5 py-2.5 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                Tutup Pendaftaran
            </button>
            <p class="text-xs text-slate-500">Menutup pendaftaran akan menolak semua pengajuan baru</p>
        </div>
    </div>

    <!-- Edit Period Form -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
        <h3 class="text-base font-semibold text-slate-900 mb-5">Edit Periode</h3>
        <form class="space-y-5" method="POST" action="#">
            @csrf
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Nama Periode</label>
                <input type="text" name="nama_periode" value="TP 2026/2027 - Semester Ganjil" class="block w-full rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500" />
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Tahun Pelajaran</label>
                <input type="text" name="tahun_pelajaran" value="2026/2027" class="block w-full rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500" />
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" value="2026-08-01" class="block w-full rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai" value="2026-09-30" class="block w-full rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500" />
                </div>
            </div>
            <div class="flex items-center gap-3">
                <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">Simpan Perubahan</button>
                <button type="reset" class="px-6 py-2.5 bg-white text-slate-700 text-sm font-medium rounded-lg border border-slate-200 hover:bg-slate-50 transition-colors">Reset</button>
            </div>
        </form>
    </div>

    <!-- Riwayat Periode -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm">
        <div class="px-6 py-4 border-b border-slate-100">
            <h3 class="text-base font-semibold text-slate-900">Riwayat Periode</h3>
        </div>
        <div class="divide-y divide-slate-100">
            @php
            // DATA DEMO
            $riwayat = [
                ['nama' => 'TP 2026/2027 - Semester Ganjil', 'mulai' => '1 Agt 2026', 'selesai' => '30 Sep 2026', 'status' => 'Aktif'],
                ['nama' => 'TP 2025/2026 - Semester Genap', 'mulai' => '1 Feb 2026', 'selesai' => '31 Mei 2026', 'status' => 'Selesai'],
                ['nama' => 'TP 2025/2026 - Semester Ganjil', 'mulai' => '1 Agt 2025', 'selesai' => '30 Sep 2025', 'status' => 'Selesai'],
            ];
            @endphp
            @foreach($riwayat as $r)
            <div class="flex items-center justify-between px-6 py-4">
                <div>
                    <p class="text-sm font-medium text-slate-900">{{ $r['nama'] }}</p>
                    <p class="text-xs text-slate-500 mt-0.5">{{ $r['mulai'] }} &mdash; {{ $r['selesai'] }}</p>
                </div>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $r['status'] === 'Aktif' ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                    {{ $r['status'] }}
                </span>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
