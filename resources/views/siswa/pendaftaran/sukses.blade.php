@extends('layouts.student')

@section('title', 'Pendaftaran Berhasil')

@section('content')
<div class="max-w-xl mx-auto space-y-6">

    <!-- Success Card -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8 text-center">

        <!-- Checkmark Icon -->
        <div class="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-4 text-emerald-600 shadow-xs">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
        </div>

        <span class="inline-block px-3 py-1 bg-emerald-50 text-emerald-700 text-xs font-bold rounded-full uppercase tracking-wider mb-2">
            Pengajuan Berhasil
        </span>
        <h1 class="text-2xl font-extrabold text-slate-900">Pendaftaran Berhasil Terkirim!</h1>
        <p class="text-xs text-slate-500 mt-1">Formulir pendaftaran ekstrakurikuler kamu telah berhasil disimpan di sistem.</p>

        <!-- No Referensi Badge -->
        <div class="mt-5 p-3.5 bg-slate-50 rounded-xl border border-slate-200/80 inline-block text-left w-full sm:w-auto min-w-[280px]">
            <p class="text-[11px] text-slate-500 uppercase font-semibold">Nomor Registrasi Referensi</p>
            <p class="text-lg font-mono font-bold text-slate-900 mt-0.5">{{ $registration->registration_number }}</p>
            <p class="text-[10px] text-slate-400 mt-0.5">
                Waktu: {{ $registration->registered_at ? $registration->registered_at->format('d M Y, H:i') . ' WIB' : now()->format('d M Y, H:i') . ' WIB' }}
            </p>
        </div>

        <!-- Registration Summary Details -->
        <div class="mt-6 text-left border-t border-slate-100 pt-5 space-y-2.5 text-xs">
            <div class="flex justify-between py-1 border-b border-slate-50">
                <span class="text-slate-500">Pilihan Ekstrakurikuler</span>
                <span class="font-bold text-slate-800">{{ $registration->extracurricular?->name }}</span>
            </div>
            <div class="flex justify-between py-1 border-b border-slate-50">
                <span class="text-slate-500">Nama Siswa</span>
                <span class="font-bold text-slate-800">{{ $student->name }}</span>
            </div>
            <div class="flex justify-between py-1 border-b border-slate-50">
                <span class="text-slate-500">Kelas / NIS</span>
                <span class="font-bold text-slate-800">{{ $student->class_name ?? '-' }} / {{ $student->nis }}</span>
            </div>
            <div class="flex justify-between py-1 border-b border-slate-50">
                <span class="text-slate-500">Periode Pendaftaran</span>
                <span class="font-bold text-slate-800">{{ $registration->period?->name ?? 'Periode Aktif' }}</span>
            </div>
            @if($registration->motivation)
            <div class="py-1">
                <span class="text-slate-500 block mb-0.5">Motivasi Siswa:</span>
                <p class="text-slate-700 italic bg-slate-50 p-2.5 rounded-lg border border-slate-100">{{ $registration->motivation }}</p>
            </div>
            @endif
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
                        <p class="text-[11px] text-slate-500">
                            Formulir pendaftaran berhasil dikirim pada {{ $registration->registered_at ? $registration->registered_at->format('d M Y') : 'hari ini' }}.
                        </p>
                    </div>
                </div>

                <!-- Step 2: Reviewed -->
                @php
                    $isReviewed = in_array($registration->status, ['reviewed', 'accepted', 'rejected']);
                    $isReviewing = $registration->status === 'reviewed';
                @endphp
                <div class="relative">
                    <span class="absolute -left-6 top-0.5 w-5 h-5 rounded-full {{ $isReviewed ? ($isReviewing ? 'bg-blue-500 text-white animate-pulse' : 'bg-emerald-500 text-white') : 'bg-slate-200 text-slate-400' }} flex items-center justify-center text-[10px] ring-4 ring-white">
                        {{ $isReviewed ? ($isReviewing ? '●' : '✓') : '○' }}
                    </span>
                    <div>
                        <p class="text-xs font-bold {{ $isReviewing ? 'text-blue-700' : ($isReviewed ? 'text-slate-800' : 'text-slate-400') }}">
                            Dalam Peninjauan (Reviewed)
                        </p>
                        <p class="text-[11px] text-slate-500">Pihak sekolah/admin memverifikasi kelengkapan berkas pendaftar.</p>
                    </div>
                </div>

                <!-- Step 3: Accepted / Final -->
                @php
                    $isAccepted = $registration->status === 'accepted';
                    $isRejected = $registration->status === 'rejected';
                @endphp
                <div class="relative">
                    <span class="absolute -left-6 top-0.5 w-5 h-5 rounded-full {{ $isAccepted ? 'bg-emerald-500 text-white' : ($isRejected ? 'bg-red-500 text-white' : 'bg-slate-200 text-slate-400') }} flex items-center justify-center text-[10px] ring-4 ring-white">
                        {{ $isAccepted ? '✓' : ($isRejected ? '✕' : '○') }}
                    </span>
                    <div>
                        <p class="text-xs font-semibold {{ $isAccepted ? 'text-emerald-700 font-bold' : ($isRejected ? 'text-red-700 font-bold' : 'text-slate-400') }}">
                            {{ $isAccepted ? 'Diterima (Accepted)' : ($isRejected ? 'Ditolak (Rejected)' : 'Diterima (Accepted)') }}
                        </p>
                        <p class="text-[11px] text-slate-400">
                            {{ $isAccepted ? 'Selamat! Anda resmi diterima di ekstrakurikuler ini.' : ($isRejected ? 'Pengajuan pendaftaran tidak dapat disetujui.' : 'Pengumuman penetapan anggota resmi ekskul.') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-8 pt-6 border-t border-slate-100 flex flex-col sm:flex-row gap-3">
            <a href="{{ route('siswa.riwayat') }}" class="flex-1 inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-lg shadow-sm transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                Lihat Riwayat &amp; Status
            </a>
            <a href="{{ route('siswa.dashboard') }}" class="flex-1 inline-flex items-center justify-center gap-2 px-5 py-2.5 border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-semibold rounded-lg transition-colors">
                Kembali ke Beranda
            </a>
        </div>

    </div>

</div>
@endsection
