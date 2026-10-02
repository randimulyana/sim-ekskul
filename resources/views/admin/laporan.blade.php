@extends('layouts.admin')
@section('page-title', 'Laporan & Rekap')
@section('content')
<!-- DATA DEMO: data di halaman ini adalah contoh untuk keperluan pengembangan sistem -->
<div class="space-y-6">

    <!-- Page Header -->
    <div class="flex items-start justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Laporan & Rekap Pendaftaran</h1>
            <p class="mt-1 text-sm text-slate-500">Ringkasan dan rekap data pendaftaran ekstrakurikuler</p>
        </div>
        <div class="flex items-center gap-2">
            <button onclick="window.print()" class="inline-flex items-center gap-2 px-4 py-2 bg-white text-slate-700 text-sm font-medium rounded-lg border border-slate-200 hover:bg-slate-50 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                Cetak
            </button>
            <button
                title="Fitur export belum tersedia"
                disabled
                class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 text-slate-400 text-sm font-medium rounded-lg cursor-not-allowed"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                Export
                <span class="text-xs bg-slate-200 text-slate-500 px-1.5 py-0.5 rounded">Segera</span>
            </button>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4">
        <div class="flex flex-col sm:flex-row gap-3">
            <div>
                <label class="block text-xs font-medium text-slate-500 mb-1">Periode</label>
                <select class="rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                    <option>TP 2026/2027</option>
                    <option>TP 2025/2026</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-slate-500 mb-1">Kelas</label>
                <select class="rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                    <option value="">Semua Kelas</option>
                    <option>BUSANA 1</option>
                    <option>TKJ</option>
                    <option>ANIMASI</option>
                    <option>KULINER 1</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-slate-500 mb-1">Ekstrakurikuler</label>
                <select class="rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                    <option value="">Semua Ekskul</option>
                    <option>PASKIBRAKA</option>
                    <option>PRAMUKA</option>
                    <option>MARCHING BAND</option>
                </select>
            </div>
            <div class="flex items-end">
                <button class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                    Filter
                </button>
            </div>
        </div>
    </div>

    <!-- Summary Stats -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        @php
        // DATA DEMO
        $stats = [
            ['label' => 'Total Pendaftar', 'value' => '183', 'color' => 'text-blue-600', 'bg' => 'bg-blue-100'],
            ['label' => 'Diterima', 'value' => '121', 'color' => 'text-emerald-600', 'bg' => 'bg-emerald-100'],
            ['label' => 'Menunggu', 'value' => '42', 'color' => 'text-amber-600', 'bg' => 'bg-amber-100'],
            ['label' => 'Ditolak', 'value' => '20', 'color' => 'text-red-600', 'bg' => 'bg-red-100'],
        ];
        @endphp
        @foreach($stats as $s)
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5">
            <p class="text-xs font-medium text-slate-500 mb-1">{{ $s['label'] }}</p>
            <p class="text-2xl font-bold text-slate-900">{{ $s['value'] }}</p>
        </div>
        @endforeach
    </div>

    <!-- Rekap Table -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm">
        <div class="px-6 py-4 border-b border-slate-100">
            <h3 class="text-base font-semibold text-slate-900">Rekap per Ekstrakurikuler</h3>
            <p class="text-xs text-slate-500 mt-0.5">Periode: TP 2026/2027 &mdash; Data demo untuk keperluan pengembangan</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">No</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Ekstrakurikuler</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Kategori</th>
                        <th class="text-right px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Pendaftar</th>
                        <th class="text-right px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Diterima</th>
                        <th class="text-right px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Menunggu</th>
                        <th class="text-right px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Ditolak</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @php
                    // DATA DEMO
                    $rekap = [
                        ['nama' => 'PASKIBRAKA', 'kat' => 'Organisasi', 'total' => 34, 'diterima' => 22, 'menunggu' => 10, 'ditolak' => 2],
                        ['nama' => 'PRAMUKA', 'kat' => 'Organisasi', 'total' => 28, 'diterima' => 18, 'menunggu' => 8, 'ditolak' => 2],
                        ['nama' => 'MARCHING BAND', 'kat' => 'Seni & Budaya', 'total' => 22, 'diterima' => 15, 'menunggu' => 5, 'ditolak' => 2],
                        ['nama' => 'SILAT TRADISI', 'kat' => 'Bela Diri', 'total' => 18, 'diterima' => 12, 'menunggu' => 4, 'ditolak' => 2],
                        ['nama' => 'PADUAN SUARA', 'kat' => 'Seni & Budaya', 'total' => 20, 'diterima' => 14, 'menunggu' => 4, 'ditolak' => 2],
                        ['nama' => 'ENGLISH CLUB', 'kat' => 'Akademik', 'total' => 15, 'diterima' => 10, 'menunggu' => 4, 'ditolak' => 1],
                        ['nama' => 'PIK-R', 'kat' => 'Organisasi', 'total' => 12, 'diterima' => 8, 'menunggu' => 3, 'ditolak' => 1],
                        ['nama' => 'TAHFIDZ', 'kat' => 'Keagamaan', 'total' => 11, 'diterima' => 8, 'menunggu' => 2, 'ditolak' => 1],
                        ['nama' => 'MODELLING', 'kat' => 'Seni & Budaya', 'total' => 14, 'diterima' => 7, 'menunggu' => 5, 'ditolak' => 2],
                        ['nama' => 'KESENIAN', 'kat' => 'Seni & Budaya', 'total' => 8, 'diterima' => 5, 'menunggu' => 2, 'ditolak' => 1],
                        ['nama' => 'RANDAI', 'kat' => 'Seni & Budaya', 'total' => 10, 'diterima' => 7, 'menunggu' => 2, 'ditolak' => 1],
                        ['nama' => 'JAPANESE CLUB', 'kat' => 'Akademik', 'total' => 9, 'diterima' => 0, 'menunggu' => 0, 'ditolak' => 0],
                    ];
                    @endphp
                    @foreach($rekap as $i => $r)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-3 text-slate-500">{{ $i + 1 }}</td>
                        <td class="px-6 py-3 font-semibold text-slate-900">{{ $r['nama'] }}</td>
                        <td class="px-6 py-3 text-slate-600">{{ $r['kat'] }}</td>
                        <td class="px-6 py-3 text-right font-medium text-slate-900">{{ $r['total'] }}</td>
                        <td class="px-6 py-3 text-right text-emerald-600 font-medium">{{ $r['diterima'] }}</td>
                        <td class="px-6 py-3 text-right text-amber-600 font-medium">{{ $r['menunggu'] }}</td>
                        <td class="px-6 py-3 text-right text-red-600 font-medium">{{ $r['ditolak'] }}</td>
                    </tr>
                    @endforeach
                    <!-- Total row -->
                    <tr class="bg-slate-50 font-semibold">
                        <td class="px-6 py-3" colspan="3">Total</td>
                        <td class="px-6 py-3 text-right text-slate-900">183</td>
                        <td class="px-6 py-3 text-right text-emerald-600">121</td>
                        <td class="px-6 py-3 text-right text-amber-600">42</td>
                        <td class="px-6 py-3 text-right text-red-600">20</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="px-6 py-3 border-t border-slate-100">
            <p class="text-xs text-amber-600">⚠ Data di atas merupakan data demo untuk keperluan pengembangan sistem, bukan data resmi sekolah.</p>
        </div>
    </div>
</div>
@endsection
