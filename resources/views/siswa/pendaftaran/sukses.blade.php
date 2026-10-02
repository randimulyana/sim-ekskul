@extends('layouts.student')

@section('title', 'Pendaftaran Berhasil')

@section('content')
{{-- DATA DEMO: status pendaftaran sukses simulasi prototype UI --}}

<div class="max-w-xl mx-auto space-y-6">

    <!-- Success Card -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8 text-center">

        <!-- Checkmark Icon -->
        <div class="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-4 text-emerald-600 shadow-xs">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
        </div>

        <span class="inline-block px-3 py-1 bg-emerald-50 text-emerald-700 text-xs font-bold rounded-full uppercase tracking-wider mb-2">
            Pengajuan Diterima
        </span>
        <h1 class="text-2xl font-extrabold text-slate-900">Pendaftaran Berhasil Terkirim!</h1>
        <p class="text-xs text-slate-500 mt-1">Formulir pendaftaran ekstrakurikuler kamu telah berhasil disimpan di sistem.</p>

        <!-- No Referensi Badge -->
        <div class="mt-5 p-3.5 bg-slate-50 rounded-xl border border-slate-200/80 inline-block text-left w-full sm:w-auto min-w-[280px]">
            <p class="text-[11px] text-slate-500 uppercase font-semibold">Nomor Registrasi Referensi</p>
            <p class="text-lg font-mono font-bold text-slate-900 mt-0.5">REG-2026-001</p>
            <p class="text-[10px] text-slate-400 mt-0.5">Waktu: 1 Oktober 2026, 14:35 WIB</p>
        </div>

        <!-- Registration Summary Details -->
        <div class="mt-6 text-left border-t border-slate-100 pt-5 space-y-2.5 text-xs">
            <div class="flex justify-between py-1 border-b border-slate-50">
                <span class="text-slate-500">Pilihan Ekstrakurikuler</span>
                <span class="font-bold text-slate-800">PASKIBRAKA</span>
            </div>
            <div class="flex justify-between py-1 border-b border-slate-50">
                <span class="text-slate-500">Nama Siswa</span>
                <span class="font-bold text-slate-800">Andi Saputra</span>
            </div>
            <div class="flex justify-between py-1 border-b border-slate-50">
                <span class="text-slate-500">Kelas / NIS</span>
                <span class="font-bold text-slate-800">KULINER 1 / 2026001</span>
            </div>
            <div class="flex justify-between py-1 border-b border-slate-50">
                <span class="text-slate-500">Tahun Pelajaran</span>
                <span class="font-bold text-slate-800">2026/2027</span>
            </div>
        </div>

        <!-- Status Timeline (PRD 9.11) -->
        <div class="mt-8 text-left">
            <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider mb-4">Progres Status Pendaftaran</h3>
            <div class="space-y-4 relative pl-6 before:content-[''] before:absolute before:left-2.5 before:top-2 before:bottom-2 before:w-0.5 before:bg-slate-200">

                <!-- Step 1: Submitted -->
                <div class="relative">
                    <span class="absolute -left-6 top-0.5 w-5 h-5 rounded-full bg-emerald-500 text-white flex items-center justify-center text-[10px] ring-4 ring-white">
                        ✓
                    </span>
                    <div>
                        <p class="text-xs font-bold text-slate-800">Terkirim (Submitted)</p>
                        <p class="text-[11px] text-slate-500">Formulir pendaftaran berhasil dikirim pada 1 Oktober 2026.</p>
                    </div>
                </div>

                <!-- Step 2: Reviewed -->
                <div class="relative">
                    <span class="absolute -left-6 top-0.5 w-5 h-5 rounded-full bg-blue-500 text-white flex items-center justify-center text-[10px] ring-4 ring-white animate-pulse">
                        ●
                    </span>
                    <div>
                        <p class="text-xs font-bold text-blue-700">Dalam Peninjauan (Reviewed)</p>
                        <p class="text-[11px] text-slate-500">Pihak sekolah/admin sedang memverifikasi kelengkapan berkas siswa.</p>
                    </div>
                </div>

                <!-- Step 3: Accepted -->
                <div class="relative">
                    <span class="absolute -left-6 top-0.5 w-5 h-5 rounded-full bg-slate-200 text-slate-400 flex items-center justify-center text-[10px] ring-4 ring-white">
                        ○
                    </span>
                    <div>
                        <p class="text-xs font-semibold text-slate-400">Diterima (Accepted)</p>
                        <p class="text-[11px] text-slate-400">Pengumuman penetapan anggota resmi ekskul.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-8 pt-6 border-t border-slate-100 flex flex-col sm:flex-row gap-3">
            <a href="/siswa/riwayat" class="flex-1 inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-lg shadow-sm transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                Lihat Riwayat & Status
            </a>
            <a href="/siswa/dashboard" class="flex-1 inline-flex items-center justify-center gap-2 px-5 py-2.5 border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-semibold rounded-lg transition-colors">
                Kembali ke Beranda
            </a>
        </div>

    </div>

</div>
@endsection
