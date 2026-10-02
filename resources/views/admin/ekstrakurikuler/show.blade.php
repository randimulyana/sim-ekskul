@extends('layouts.admin')

@section('page-title', 'Detail Ekstrakurikuler')

@section('content')
<!-- DATA DEMO: detail data ekstrakurikuler admin prototype UI -->
<div class="space-y-6">

    <!-- Breadcrumb & Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <nav class="flex items-center gap-1 text-xs text-slate-500 mb-2">
                <a href="/admin/dashboard" class="hover:text-slate-700">Dashboard</a>
                <svg class="w-3.5 h-3.5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <a href="/admin/ekstrakurikuler" class="hover:text-slate-700">Ekstrakurikuler</a>
                <svg class="w-3.5 h-3.5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <span class="text-slate-800 font-semibold">PASKIBRAKA</span>
            </nav>
            <div class="flex items-center gap-3">
                <h1 class="text-2xl font-bold text-slate-900">PASKIBRAKA</h1>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                    Aktif
                </span>
            </div>
            <p class="text-xs text-slate-500 mt-1">Kategori: Organisasi &middot; Periode Aktif: TP 2026/2027</p>
        </div>

        <div class="flex items-center gap-2">
            <a href="/admin/ekstrakurikuler" class="px-4 py-2 border border-slate-200 text-slate-700 hover:bg-slate-50 text-xs font-semibold rounded-lg transition-colors">
                &larr; Kembali
            </a>
            <a href="/admin/ekstrakurikuler/1/edit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-lg shadow-sm transition-colors">
                Edit Ekskul
            </a>
        </div>
    </div>

    <!-- Stats Row -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl border border-slate-200 p-4 shadow-sm">
            <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Total Pendaftar</span>
            <p class="text-2xl font-bold text-slate-900 mt-1">34</p>
            <span class="text-[11px] text-blue-600 font-medium">Kapasitas Kuota: 60</span>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 p-4 shadow-sm">
            <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Diterima</span>
            <p class="text-2xl font-bold text-emerald-600 mt-1">22</p>
            <span class="text-[11px] text-emerald-700 font-medium">65% dari pendaftar</span>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 p-4 shadow-sm">
            <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Menunggu Tinjauan</span>
            <p class="text-2xl font-bold text-amber-600 mt-1">10</p>
            <span class="text-[11px] text-amber-700 font-medium">Perlu verifikasi</span>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 p-4 shadow-sm">
            <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Ditolak / Batal</span>
            <p class="text-2xl font-bold text-red-600 mt-1">2</p>
            <span class="text-[11px] text-slate-400 font-medium">Tidak memenuhi syarat</span>
        </div>
    </div>

    <!-- Info Detail Card -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 space-y-4">
        <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Informasi Kegiatan</h3>
        <p class="text-xs text-slate-600 leading-relaxed">
            Pasukan Pengibar Bendera Pusaka yang melatih kedisiplinan tingkat tinggi, ketahanan fisik, kepemimpinan, dan rasa cinta tanah air.
        </p>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-2 text-xs">
            <div class="bg-slate-50 p-3 rounded-lg border border-slate-200/70">
                <span class="text-slate-400 block font-semibold uppercase text-[10px]">Jadwal Kegiatan (Placeholder)</span>
                <span class="text-slate-800 font-bold mt-0.5 block">Rabu &amp; Sabtu, 15.30 - 17.30 WIB</span>
            </div>
            <div class="bg-slate-50 p-3 rounded-lg border border-slate-200/70">
                <span class="text-slate-400 block font-semibold uppercase text-[10px]">Lokasi Latihan (Placeholder)</span>
                <span class="text-slate-800 font-bold mt-0.5 block">Lapangan Utama SMKN 3 Payakumbuh</span>
            </div>
            <div class="bg-slate-50 p-3 rounded-lg border border-slate-200/70">
                <span class="text-slate-400 block font-semibold uppercase text-[10px]">Pembina (Placeholder)</span>
                <span class="text-slate-800 font-bold mt-0.5 block">Drs. Hendri Syahputra, M.Pd.</span>
            </div>
        </div>
    </div>

    <!-- Pendaftar List Table -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="text-sm font-bold text-slate-900">Daftar Pendaftar Ekskul Ini (34)</h3>
                <p class="text-xs text-slate-500 mt-0.5">Siswa yang mengajukan pilihan pada periode aktif 2026/2027</p>
            </div>
            <a href="/admin/pendaftaran" class="text-xs font-semibold text-blue-600 hover:text-blue-800">
                Buka Kelola Pendaftaran &rarr;
            </a>
        </div>

        @php
        // DATA DEMO: pendaftar di ekskul Paskibraka
        $pendaftarList = [
            ['nama' => 'Andi Saputra', 'nis' => '2026001', 'kelas' => 'KULINER 1', 'wa' => '08123456789', 'tgl' => '1 Okt 2026', 'status' => 'reviewed', 'label' => 'Ditinjau', 'badge' => 'bg-amber-100 text-amber-800'],
            ['nama' => 'Rizky Pratama', 'nis' => '2026089', 'kelas' => 'TKJ', 'wa' => '08219876543', 'tgl' => '2 Okt 2026', 'status' => 'accepted', 'label' => 'Diterima', 'badge' => 'bg-emerald-100 text-emerald-800'],
            ['nama' => 'Bunga Lestari', 'nis' => '2026045', 'kelas' => 'BUSANA 2', 'wa' => '08521122334', 'tgl' => '2 Okt 2026', 'status' => 'accepted', 'label' => 'Diterima', 'badge' => 'bg-emerald-100 text-emerald-800'],
            ['nama' => 'Danu Wirawan', 'nis' => '2026067', 'kelas' => 'ANIMASI', 'wa' => '08139988776', 'tgl' => '2 Okt 2026', 'status' => 'submitted', 'label' => 'Terkirim', 'badge' => 'bg-blue-100 text-blue-800'],
            ['nama' => 'Siti Aulia', 'nis' => '2026112', 'kelas' => 'PERHOTELAN 1', 'wa' => '08776655443', 'tgl' => '3 Okt 2026', 'status' => 'reviewed', 'label' => 'Ditinjau', 'badge' => 'bg-amber-100 text-amber-800'],
        ];
        @endphp

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase tracking-wider font-semibold">
                    <tr>
                        <th class="px-6 py-3.5">No</th>
                        <th class="px-6 py-3.5">Nama Siswa</th>
                        <th class="px-6 py-3.5">NIS</th>
                        <th class="px-6 py-3.5">Kelas</th>
                        <th class="px-6 py-3.5">Tanggal</th>
                        <th class="px-6 py-3.5">Status</th>
                        <th class="px-6 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($pendaftarList as $i => $p)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-3.5 text-slate-400 font-mono">{{ $i + 1 }}</td>
                        <td class="px-6 py-3.5 font-bold text-slate-800">{{ $p['nama'] }}</td>
                        <td class="px-6 py-3.5 font-mono text-slate-600">{{ $p['nis'] }}</td>
                        <td class="px-6 py-3.5 text-slate-600">{{ $p['kelas'] }}</td>
                        <td class="px-6 py-3.5 text-slate-500">{{ $p['tgl'] }}</td>
                        <td class="px-6 py-3.5">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold {{ $p['badge'] }}">
                                {{ $p['label'] }}
                            </span>
                        </td>
                        <td class="px-6 py-3.5 text-right">
                            <a href="/admin/pendaftaran/1" class="text-blue-600 hover:text-blue-800 font-semibold">Detail</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
