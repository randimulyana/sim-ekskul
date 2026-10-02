@extends('layouts.admin')
@section('page-title', 'Data Siswa')
@section('content')
<!-- DATA DEMO: data di halaman ini adalah contoh untuk keperluan pengembangan sistem -->
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Data Siswa</h1>
            <p class="mt-1 text-sm text-slate-500">Kelola data siswa terdaftar di sistem SRPE</p>
        </div>
        <a href="/admin/siswa/create"
           class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2.5 rounded-lg transition-colors shadow-sm self-start">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            Tambah Siswa
        </a>
    </div>

    {{-- Filter Bar --}}
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4">
        <div class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1 relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" placeholder="Cari nama atau NIS..."
                       class="w-full pl-10 pr-4 py-2.5 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <select class="text-sm border border-slate-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white text-slate-700">
                <option value="">Semua Kelas</option>
                <option>KULINER 1</option>
                <option>KULINER 2</option>
                <option>BUSANA 1</option>
                <option>BUSANA 2</option>
                <option>PERHOTELAN 1</option>
                <option>PERHOTELAN 2</option>
                <option>TKJ 1</option>
                <option>TKJ 2</option>
                <option>ANIMASI 1</option>
                <option>AKUNTANSI 1</option>
            </select>
            <select class="text-sm border border-slate-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white text-slate-700">
                <option value="">Semua Status</option>
                <option>Aktif</option>
                <option>Nonaktif</option>
            </select>
            <button class="inline-flex items-center gap-2 text-sm text-slate-600 border border-slate-200 px-3 py-2.5 rounded-lg hover:bg-slate-50 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/></svg>
                Filter
            </button>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
            <p class="text-sm text-slate-500">Menampilkan <span class="font-semibold text-slate-900">10</span> dari <span class="font-semibold text-slate-900">247</span> siswa</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider w-12">No</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Nama</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">NIS</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Kelas</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">WhatsApp</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="text-right px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @php
                    // DATA DEMO
                    $siswa = [
                        ['no'=>1,  'nama'=>'Andi Saputra',      'nis'=>'2024001', 'kelas'=>'KULINER 1',    'wa'=>'0812-3456-7890', 'status'=>'aktif'],
                        ['no'=>2,  'nama'=>'Bunga Lestari',      'nis'=>'2024002', 'kelas'=>'BUSANA 2',     'wa'=>'0813-2345-6789', 'status'=>'aktif'],
                        ['no'=>3,  'nama'=>'Rizky Pratama',      'nis'=>'2024003', 'kelas'=>'TKJ 1',        'wa'=>'0814-3456-8901', 'status'=>'aktif'],
                        ['no'=>4,  'nama'=>'Siti Aulia',         'nis'=>'2024004', 'kelas'=>'PERHOTELAN 1', 'wa'=>'0815-4567-9012', 'status'=>'aktif'],
                        ['no'=>5,  'nama'=>'Danu Wirawan',       'nis'=>'2024005', 'kelas'=>'ANIMASI 1',    'wa'=>'0816-5678-0123', 'status'=>'aktif'],
                        ['no'=>6,  'nama'=>'Farah Nadia',        'nis'=>'2024006', 'kelas'=>'AKUNTANSI 1',  'wa'=>'0817-6789-1234', 'status'=>'aktif'],
                        ['no'=>7,  'nama'=>'Gilang Ramadhan',    'nis'=>'2024007', 'kelas'=>'TKJ 2',        'wa'=>'0818-7890-2345', 'status'=>'aktif'],
                        ['no'=>8,  'nama'=>'Hesti Wulandari',    'nis'=>'2024008', 'kelas'=>'BUSANA 1',     'wa'=>'0819-8901-3456', 'status'=>'nonaktif'],
                        ['no'=>9,  'nama'=>'Irfan Maulana',      'nis'=>'2024009', 'kelas'=>'KULINER 2',    'wa'=>'0821-9012-4567', 'status'=>'aktif'],
                        ['no'=>10, 'nama'=>'Jeni Karlina',       'nis'=>'2024010', 'kelas'=>'PERHOTELAN 2', 'wa'=>'0822-0123-5678', 'status'=>'nonaktif'],
                    ];
                    @endphp
                    @foreach($siswa as $s)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 text-slate-500">{{ $s['no'] }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center text-xs font-bold flex-shrink-0">
                                    {{ strtoupper(substr($s['nama'], 0, 1)) }}
                                </div>
                                <span class="font-medium text-slate-900">{{ $s['nama'] }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-slate-600 font-mono text-xs">{{ $s['nis'] }}</td>
                        <td class="px-6 py-4 text-slate-600">{{ $s['kelas'] }}</td>
                        <td class="px-6 py-4 text-slate-600">{{ $s['wa'] }}</td>
                        <td class="px-6 py-4">
                            @if($s['status'] === 'aktif')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">Aktif</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-600">Nonaktif</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="/admin/siswa/{{ $s['no'] }}" class="text-xs text-blue-600 hover:text-blue-700 font-medium hover:underline">Lihat</a>
                                <span class="text-slate-300">|</span>
                                <a href="/admin/siswa/{{ $s['no'] }}/edit" class="text-xs text-slate-600 hover:text-slate-700 font-medium hover:underline">Edit</a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="flex items-center justify-between px-6 py-4 border-t border-slate-100">
            <p class="text-sm text-slate-500">Halaman <span class="font-medium">1</span> dari <span class="font-medium">25</span></p>
            <div class="flex items-center gap-1">
                <button class="px-3 py-1.5 text-sm text-slate-500 border border-slate-200 rounded-lg hover:bg-slate-50 disabled:opacity-40" disabled>
                    &larr; Sebelumnya
                </button>
                <button class="px-3 py-1.5 text-sm bg-blue-600 text-white rounded-lg font-medium">1</button>
                <button class="px-3 py-1.5 text-sm text-slate-600 border border-slate-200 rounded-lg hover:bg-slate-50">2</button>
                <button class="px-3 py-1.5 text-sm text-slate-600 border border-slate-200 rounded-lg hover:bg-slate-50">3</button>
                <span class="px-2 text-slate-400 text-sm">...</span>
                <button class="px-3 py-1.5 text-sm text-slate-600 border border-slate-200 rounded-lg hover:bg-slate-50">25</button>
                <button class="px-3 py-1.5 text-sm text-slate-600 border border-slate-200 rounded-lg hover:bg-slate-50">
                    Berikutnya &rarr;
                </button>
            </div>
        </div>
    </div>

</div>
@endsection
