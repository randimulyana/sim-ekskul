@extends('layouts.admin')

@section('page-title', 'Hasil Rekomendasi Siswa')

@section('content')
<!-- DATA DEMO: data hasil rekomendasi siswa admin prototype UI -->
<div class="space-y-6">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Hasil Rekomendasi Siswa</h1>
            <p class="text-xs text-slate-500 mt-1">Daftar rekap pemetaan rekomendasi ekstrakurikuler yang telah selesai dianalisis</p>
        </div>
        <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-blue-50 border border-blue-200 text-xs font-semibold text-blue-800">
            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>Label: "Skor Kecocokan" (Bukan ukuran bakat mutlak)</span>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4">
        <div class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1">
                <input
                    type="text"
                    placeholder="Cari siswa atau NIS..."
                    class="block w-full rounded-lg border border-slate-200 px-3.5 py-2 text-xs text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-blue-500"
                />
            </div>
            <select class="rounded-lg border border-slate-200 px-3 py-2 text-xs text-slate-900 focus:outline-none focus:ring-1 focus:ring-blue-500">
                <option value="">Semua Kelas</option>
                <option>KULINER 1</option>
                <option>TKJ</option>
                <option>ANIMASI</option>
                <option>BUSANA 2</option>
                <option>PERHOTELAN 1</option>
            </select>
            <select class="rounded-lg border border-slate-200 px-3 py-2 text-xs text-slate-900 focus:outline-none focus:ring-1 focus:ring-blue-500">
                <option value="">Semua Ekskul Rekomendasi</option>
                <option>PASKIBRAKA</option>
                <option>PRAMUKA</option>
                <option>MARCHING BAND</option>
                <option>PADUAN SUARA</option>
            </select>
        </div>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <h3 class="text-sm font-bold text-slate-900">Rekap Analisis Rekomendasi (8 Data Terbaru)</h3>
            <span class="text-xs text-slate-400">Periode: TP 2026/2027</span>
        </div>

        @php
        // DATA DEMO: data hasil analisis rekomendasi
        $results = [
            ['id' => 1, 'nama' => 'Andi Saputra', 'nis' => '2026001', 'kelas' => 'KULINER 1', 'top' => 'PASKIBRAKA', 'kat' => 'Organisasi', 'skor' => 92, 'tgl' => '1 Okt 2026'],
            ['id' => 2, 'nama' => 'Bunga Lestari', 'nis' => '2026045', 'kelas' => 'BUSANA 2', 'top' => 'PADUAN SUARA', 'kat' => 'Seni & Budaya', 'skor' => 95, 'tgl' => '1 Okt 2026'],
            ['id' => 3, 'nama' => 'Rizky Pratama', 'nis' => '2026089', 'kelas' => 'TKJ', 'top' => 'ENGLISH CLUB', 'kat' => 'Akademik', 'skor' => 88, 'tgl' => '2 Okt 2026'],
            ['id' => 4, 'nama' => 'Siti Aulia', 'nis' => '2026112', 'kelas' => 'PERHOTELAN 1', 'top' => 'PRAMUKA', 'kat' => 'Organisasi', 'skor' => 89, 'tgl' => '2 Okt 2026'],
            ['id' => 5, 'nama' => 'Danu Wirawan', 'nis' => '2026067', 'kelas' => 'ANIMASI', 'top' => 'MARCHING BAND', 'kat' => 'Seni & Budaya', 'skor' => 86, 'tgl' => '2 Okt 2026'],
            ['id' => 6, 'nama' => 'Ahmad Fadhil', 'nis' => '2026033', 'kelas' => 'TKJ', 'top' => 'SILAT TRADISI', 'kat' => 'Bela Diri', 'skor' => 91, 'tgl' => '2 Okt 2026'],
            ['id' => 7, 'nama' => 'Nabila Putri', 'nis' => '2026021', 'kelas' => 'BUSANA 1', 'top' => 'MODELLING', 'kat' => 'Seni & Budaya', 'skor' => 94, 'tgl' => '3 Okt 2026'],
            ['id' => 8, 'nama' => 'Farhan Hakim', 'nis' => '2026078', 'kelas' => 'ULW', 'top' => 'TAHFIDZ', 'kat' => 'Keagamaan', 'skor' => 90, 'tgl' => '3 Okt 2026'],
        ];
        @endphp

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase tracking-wider font-semibold">
                    <tr>
                        <th class="px-6 py-3.5">No</th>
                        <th class="px-6 py-3.5">Siswa</th>
                        <th class="px-6 py-3.5">Kelas</th>
                        <th class="px-6 py-3.5">Rekomendasi Teratas</th>
                        <th class="px-6 py-3.5">Skor Kecocokan</th>
                        <th class="px-6 py-3.5">Tanggal</th>
                        <th class="px-6 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($results as $i => $row)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-3.5 text-slate-400 font-mono">{{ $i + 1 }}</td>
                        <td class="px-6 py-3.5">
                            <span class="font-bold text-slate-900 block text-xs">{{ $row['nama'] }}</span>
                            <span class="text-slate-400 font-mono text-[11px]">NIS: {{ $row['nis'] }}</span>
                        </td>
                        <td class="px-6 py-3.5 text-slate-700 font-medium">{{ $row['kelas'] }}</td>
                        <td class="px-6 py-3.5">
                            <span class="font-bold text-slate-800 block text-xs">{{ $row['top'] }}</span>
                            <span class="text-[10px] text-slate-400">{{ $row['kat'] }}</span>
                        </td>
                        <td class="px-6 py-3.5">
                            <div class="flex items-center gap-2">
                                <span class="font-extrabold text-blue-600 text-sm font-mono">{{ $row['skor'] }}</span>
                                <span class="text-[10px] text-slate-400">/ 100</span>
                            </div>
                        </td>
                        <td class="px-6 py-3.5 text-slate-500">{{ $row['tgl'] }}</td>
                        <td class="px-6 py-3.5 text-right">
                            <a href="/admin/rekomendasi/{{ $row['id'] }}" class="text-blue-600 hover:text-blue-800 font-bold">
                                Detail &rarr;
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100 text-xs text-slate-500 flex justify-between items-center">
            <span>Menampilkan 8 data simulasi</span>
            <div class="flex gap-1">
                <button class="px-3 py-1 border border-slate-200 rounded text-slate-400" disabled>Sebelumnya</button>
                <button class="px-3 py-1 bg-blue-600 text-white rounded font-bold">1</button>
                <button class="px-3 py-1 border border-slate-200 rounded text-slate-700">Berikutnya</button>
            </div>
        </div>
    </div>

</div>
@endsection
