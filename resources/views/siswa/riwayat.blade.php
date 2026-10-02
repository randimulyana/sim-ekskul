@extends('layouts.student')

@section('title', 'Riwayat Pendaftaran')

@section('content')
{{-- DATA DEMO: data riwayat pendaftaran siswa prototype UI --}}

<div class="max-w-4xl mx-auto space-y-6">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Riwayat Pendaftaran</h1>
            <p class="text-sm text-slate-500 mt-1">Daftar pengajuan pemilihan ekstrakurikuler yang pernah kamu buat</p>
        </div>
        <a href="/siswa/pendaftaran" class="self-start sm:self-auto inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-lg shadow-sm transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Daftar Ekskul Baru
        </a>
    </div>

    <!-- Active Registration Alert -->
    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 flex items-start sm:items-center justify-between gap-3 text-xs text-blue-900">
        <div class="flex items-center gap-2.5">
            <span class="w-2.5 h-2.5 rounded-full bg-blue-600 animate-pulse"></span>
            <div>
                <strong>Pendaftaran Terakhir:</strong> PASKIBRAKA (No: REG-2026-001) sedang dalam status <span class="font-bold underline text-blue-800">Ditinjau</span>.
            </div>
        </div>
        <span class="text-blue-700 font-semibold text-[11px] whitespace-nowrap">TP 2026/2027</span>
    </div>

    <!-- Table Container for Desktop, Card for Mobile -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <h3 class="text-sm font-bold text-slate-900">Semua Pengajuan (2)</h3>
            <span class="text-xs text-slate-500">Andi Saputra · KULINER 1</span>
        </div>

        @php
        // DATA DEMO
        $riwayat = [
            [
                'no_reg' => 'REG-2026-001',
                'ekskul' => 'PASKIBRAKA',
                'kategori' => 'Organisasi',
                'periode' => 'TP 2026/2027 (Ganjil)',
                'tanggal' => '1 Okt 2026',
                'status' => 'reviewed',
                'status_label' => 'Ditinjau (Reviewed)',
                'badge' => 'bg-amber-100 text-amber-800 border-amber-200',
                'catatan' => 'Berkas pendaftaran sedang dalam verifikasi panitia pemilihan ekskul.',
            ],
            [
                'no_reg' => 'REG-2025-089',
                'ekskul' => 'PRAMUKA',
                'kategori' => 'Organisasi',
                'periode' => 'TP 2025/2026 (Genap)',
                'tanggal' => '12 Agt 2025',
                'status' => 'accepted',
                'status_label' => 'Diterima (Accepted)',
                'badge' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                'catatan' => 'Telah resmi terdaftar dan menyelesaikan kegiatan masa bakti tahun lalu.',
            ],
        ];
        @endphp

        <!-- Desktop Table View -->
        <div class="hidden sm:block overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase tracking-wider font-semibold">
                    <tr>
                        <th class="px-6 py-3.5">No. Registrasi</th>
                        <th class="px-6 py-3.5">Ekstrakurikuler</th>
                        <th class="px-6 py-3.5">Periode / Tanggal</th>
                        <th class="px-6 py-3.5">Status</th>
                        <th class="px-6 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($riwayat as $r)
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="px-6 py-4 font-mono font-bold text-slate-800">
                            {{ $r['no_reg'] }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-bold text-slate-900 block text-sm">{{ $r['ekskul'] }}</span>
                            <span class="text-slate-400 text-[11px]">{{ $r['kategori'] }}</span>
                        </td>
                        <td class="px-6 py-4 text-slate-600">
                            <span class="font-medium block text-slate-800">{{ $r['periode'] }}</span>
                            <span class="text-slate-400 text-[11px]">{{ $r['tanggal'] }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold border {{ $r['badge'] }}">
                                {{ $r['status_label'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="/siswa/pendaftaran/sukses" class="text-blue-600 hover:text-blue-800 font-semibold text-xs">
                                Lihat Detail &rarr;
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Mobile Card View -->
        <div class="sm:hidden divide-y divide-slate-100">
            @foreach($riwayat as $r)
            <div class="p-4 space-y-3">
                <div class="flex items-start justify-between">
                    <div>
                        <span class="font-mono text-xs font-bold text-slate-500">{{ $r['no_reg'] }}</span>
                        <h4 class="text-base font-bold text-slate-900 mt-0.5">{{ $r['ekskul'] }}</h4>
                        <span class="text-[11px] text-slate-400">{{ $r['kategori'] }}</span>
                    </div>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold border {{ $r['badge'] }}">
                        {{ $r['status_label'] }}
                    </span>
                </div>

                <div class="bg-slate-50 rounded-lg p-2.5 text-xs text-slate-600 space-y-1">
                    <div class="flex justify-between">
                        <span class="text-slate-400">Periode:</span>
                        <span class="font-medium text-slate-800">{{ $r['periode'] }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-400">Tanggal:</span>
                        <span class="font-medium text-slate-800">{{ $r['tanggal'] }}</span>
                    </div>
                </div>

                <div class="text-right pt-1">
                    <a href="/siswa/pendaftaran/sukses" class="inline-flex items-center gap-1 text-xs font-bold text-blue-600 hover:text-blue-800">
                        <span>Lihat Detail Status</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>
            @endforeach
        </div>

    </div>

</div>
@endsection
