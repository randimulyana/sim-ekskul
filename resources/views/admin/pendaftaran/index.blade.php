@extends('layouts.admin')

@section('page-title', 'Kelola Pendaftaran')

@section('content')
<!-- DATA DEMO: data pendaftaran siswa admin prototype UI -->
<div class="space-y-6">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Data Pendaftaran Siswa</h1>
            <p class="text-xs text-slate-500 mt-1">Kelola dan periksa pengajuan pemilihan ekstrakurikuler siswa periode aktif</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                Periode Aktif: TP 2026/2027
            </span>
        </div>
    </div>

    <!-- Filters Bar -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 space-y-3">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
            <!-- Search -->
            <div>
                <label class="block text-[11px] font-semibold text-slate-500 uppercase mb-1">Cari Siswa</label>
                <input
                    type="text"
                    placeholder="Nama siswa atau NIS..."
                    class="block w-full rounded-lg border border-slate-200 px-3 py-2 text-xs text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-blue-500"
                />
            </div>

            <!-- Filter Status -->
            <div>
                <label class="block text-[11px] font-semibold text-slate-500 uppercase mb-1">Status</label>
                <select class="block w-full rounded-lg border border-slate-200 px-3 py-2 text-xs text-slate-900 focus:outline-none focus:ring-1 focus:ring-blue-500">
                    <option value="">Semua Status</option>
                    <option>Terkirim (Submitted)</option>
                    <option>Ditinjau (Reviewed)</option>
                    <option>Diterima (Accepted)</option>
                    <option>Ditolak (Rejected)</option>
                </select>
            </div>

            <!-- Filter Ekskul -->
            <div>
                <label class="block text-[11px] font-semibold text-slate-500 uppercase mb-1">Ekstrakurikuler</label>
                <select class="block w-full rounded-lg border border-slate-200 px-3 py-2 text-xs text-slate-900 focus:outline-none focus:ring-1 focus:ring-blue-500">
                    <option value="">Semua Ekskul</option>
                    <option>PASKIBRAKA</option>
                    <option>PRAMUKA</option>
                    <option>MARCHING BAND</option>
                    <option>SILAT TRADISI</option>
                    <option>ENGLISH CLUB</option>
                </select>
            </div>

            <!-- Filter Kelas -->
            <div>
                <label class="block text-[11px] font-semibold text-slate-500 uppercase mb-1">Kelas</label>
                <select class="block w-full rounded-lg border border-slate-200 px-3 py-2 text-xs text-slate-900 focus:outline-none focus:ring-1 focus:ring-blue-500">
                    <option value="">Semua Kelas</option>
                    <option>KULINER 1</option>
                    <option>TKJ</option>
                    <option>ANIMASI</option>
                    <option>BUSANA 2</option>
                    <option>PERHOTELAN 1</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <h3 class="text-sm font-bold text-slate-900">Daftar Pendaftar (Total: 183 Pengajuan)</h3>
            <span class="text-xs text-slate-400">Menampilkan 10 data demo</span>
        </div>

        @php
        // DATA DEMO: daftar pendaftaran dengan status bervariasi
        $registrations = [
            ['id' => 1, 'nama' => 'Andi Saputra', 'nis' => '2026001', 'kelas' => 'KULINER 1', 'ekskul' => 'PASKIBRAKA', 'tgl' => '1 Okt 2026', 'status' => 'reviewed', 'label' => 'Ditinjau', 'badge' => 'bg-amber-100 text-amber-800'],
            ['id' => 2, 'nama' => 'Bunga Lestari', 'nis' => '2026045', 'kelas' => 'BUSANA 2', 'ekskul' => 'PADUAN SUARA', 'tgl' => '1 Okt 2026', 'status' => 'accepted', 'label' => 'Diterima', 'badge' => 'bg-emerald-100 text-emerald-800'],
            ['id' => 3, 'nama' => 'Rizky Pratama', 'nis' => '2026089', 'kelas' => 'TKJ', 'ekskul' => 'ENGLISH CLUB', 'tgl' => '2 Okt 2026', 'status' => 'submitted', 'label' => 'Terkirim', 'badge' => 'bg-blue-100 text-blue-800'],
            ['id' => 4, 'nama' => 'Siti Aulia', 'nis' => '2026112', 'kelas' => 'PERHOTELAN 1', 'ekskul' => 'PRAMUKA', 'tgl' => '2 Okt 2026', 'status' => 'accepted', 'label' => 'Diterima', 'badge' => 'bg-emerald-100 text-emerald-800'],
            ['id' => 5, 'nama' => 'Danu Wirawan', 'nis' => '2026067', 'kelas' => 'ANIMASI', 'ekskul' => 'MARCHING BAND', 'tgl' => '2 Okt 2026', 'status' => 'accepted', 'label' => 'Diterima', 'badge' => 'bg-emerald-100 text-emerald-800'],
            ['id' => 6, 'nama' => 'Ahmad Fadhil', 'nis' => '2026033', 'kelas' => 'TKJ', 'ekskul' => 'SILAT TRADISI', 'tgl' => '2 Okt 2026', 'status' => 'reviewed', 'label' => 'Ditinjau', 'badge' => 'bg-amber-100 text-amber-800'],
            ['id' => 7, 'nama' => 'Nabila Putri', 'nis' => '2026021', 'kelas' => 'BUSANA 1', 'ekskul' => 'MODELLING', 'tgl' => '3 Okt 2026', 'status' => 'submitted', 'label' => 'Terkirim', 'badge' => 'bg-blue-100 text-blue-800'],
            ['id' => 8, 'nama' => 'Farhan Hakim', 'nis' => '2026078', 'kelas' => 'ULW', 'ekskul' => 'TAHFIDZ', 'tgl' => '3 Okt 2026', 'status' => 'accepted', 'label' => 'Diterima', 'badge' => 'bg-emerald-100 text-emerald-800'],
            ['id' => 9, 'nama' => 'Dinda Rahma', 'nis' => '2026090', 'kelas' => 'KC SPA', 'ekskul' => 'PIK-R', 'tgl' => '3 Okt 2026', 'status' => 'reviewed', 'label' => 'Ditinjau', 'badge' => 'bg-amber-100 text-amber-800'],
            ['id' => 10, 'nama' => 'Ilham Maulana', 'nis' => '2026054', 'kelas' => 'KULINER 2', 'ekskul' => 'RANDAI', 'tgl' => '3 Okt 2026', 'status' => 'rejected', 'label' => 'Ditolak', 'badge' => 'bg-red-100 text-red-800'],
        ];
        @endphp

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase tracking-wider font-semibold">
                    <tr>
                        <th class="px-6 py-3.5">No</th>
                        <th class="px-6 py-3.5">Siswa</th>
                        <th class="px-6 py-3.5">Kelas</th>
                        <th class="px-6 py-3.5">Pilihan Ekskul</th>
                        <th class="px-6 py-3.5">Tanggal</th>
                        <th class="px-6 py-3.5">Status</th>
                        <th class="px-6 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($registrations as $i => $row)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-3.5 text-slate-400 font-mono">{{ $i + 1 }}</td>
                        <td class="px-6 py-3.5">
                            <span class="font-bold text-slate-900 block text-xs">{{ $row['nama'] }}</span>
                            <span class="text-slate-400 font-mono text-[11px]">NIS: {{ $row['nis'] }}</span>
                        </td>
                        <td class="px-6 py-3.5 text-slate-700 font-medium">{{ $row['kelas'] }}</td>
                        <td class="px-6 py-3.5 font-semibold text-slate-800">{{ $row['ekskul'] }}</td>
                        <td class="px-6 py-3.5 text-slate-500">{{ $row['tgl'] }}</td>
                        <td class="px-6 py-3.5">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold {{ $row['badge'] }}">
                                {{ $row['label'] }}
                            </span>
                        </td>
                        <td class="px-6 py-3.5 text-right">
                            <a href="/admin/pendaftaran/{{ $row['id'] }}" class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-800 font-bold">
                                Detail &rarr;
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination UI Dummy -->
        <div class="flex items-center justify-between px-6 py-4 border-t border-slate-100 text-xs">
            <span class="text-slate-500">Menampilkan 1 - 10 dari 183 data</span>
            <div class="flex items-center gap-1">
                <button disabled class="px-3 py-1.5 border border-slate-200 rounded-lg text-slate-300 cursor-not-allowed">Sebelumnya</button>
                <button class="px-3 py-1.5 bg-blue-600 text-white rounded-lg font-bold">1</button>
                <button class="px-3 py-1.5 border border-slate-200 text-slate-700 rounded-lg hover:bg-slate-50">2</button>
                <button class="px-3 py-1.5 border border-slate-200 text-slate-700 rounded-lg hover:bg-slate-50">3</button>
                <button class="px-3 py-1.5 border border-slate-200 rounded-lg text-slate-700 hover:bg-slate-50">Berikutnya</button>
            </div>
        </div>
    </div>

</div>
@endsection
