@extends('layouts.admin')
@section('page-title', 'Ekstrakurikuler')
@section('content')
<!-- DATA DEMO: data di halaman ini adalah contoh untuk keperluan pengembangan -->
<div class="space-y-5">

    {{-- Page Header --}}
    <div class="flex items-start justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Data Ekstrakurikuler</h1>
            <p class="mt-1 text-sm text-slate-500">
                Kelola daftar ekstrakurikuler yang tersedia &mdash;
                <span class="text-amber-600 font-medium">⚠ Data demo berdasarkan observasi awal, bukan daftar resmi final</span>
            </p>
        </div>
        <a href="/admin/ekstrakurikuler/create"
            class="flex-shrink-0 inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Ekskul
        </a>
    </div>

    {{-- Summary Cards --}}
    @php
    // DATA DEMO
    $ekskuls = [
        ['nama' => 'PASKIBRAKA',    'kategori' => 'Organisasi',      'peserta' => 34, 'aktif' => true,  'pembina' => 'Bpk. Harun, S.Pd'],
        ['nama' => 'PRAMUKA',       'kategori' => 'Organisasi',      'peserta' => 28, 'aktif' => true,  'pembina' => 'Ibu Sari, S.Pd'],
        ['nama' => 'PIK-R',         'kategori' => 'Organisasi',      'peserta' => 12, 'aktif' => true,  'pembina' => 'Ibu Dewi, M.Pd'],
        ['nama' => 'SILAT TRADISI', 'kategori' => 'Bela Diri',       'peserta' => 18, 'aktif' => true,  'pembina' => 'Bpk. Reza, S.Pd'],
        ['nama' => 'RANDAI',        'kategori' => 'Seni & Budaya',   'peserta' => 10, 'aktif' => true,  'pembina' => 'Bpk. Fikri, S.Sn'],
        ['nama' => 'MARCHING BAND', 'kategori' => 'Seni & Budaya',   'peserta' => 22, 'aktif' => true,  'pembina' => 'Ibu Ratna, S.Pd'],
        ['nama' => 'MODELLING',     'kategori' => 'Seni & Budaya',   'peserta' => 14, 'aktif' => true,  'pembina' => 'Ibu Citra, S.Pd'],
        ['nama' => 'KESENIAN',      'kategori' => 'Seni & Budaya',   'peserta' => 8,  'aktif' => true,  'pembina' => 'Bpk. Yogi, S.Sn'],
        ['nama' => 'PADUAN SUARA',  'kategori' => 'Seni & Budaya',   'peserta' => 20, 'aktif' => true,  'pembina' => 'Ibu Nurul, S.Pd'],
        ['nama' => 'ENGLISH CLUB',  'kategori' => 'Akademik',        'peserta' => 15, 'aktif' => true,  'pembina' => 'Ibu Lina, S.S'],
        ['nama' => 'JAPANESE CLUB', 'kategori' => 'Akademik',        'peserta' => 9,  'aktif' => false, 'pembina' => '-'],
        ['nama' => 'TAHFIDZ',       'kategori' => 'Keagamaan',       'peserta' => 11, 'aktif' => true,  'pembina' => 'Bpk. Ustadz Fajar'],
    ];
    $totalAktif   = collect($ekskuls)->where('aktif', true)->count();
    $totalPeserta = collect($ekskuls)->sum('peserta');
    @endphp

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4">
            <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Total Ekskul</p>
            <p class="mt-1 text-3xl font-bold text-slate-900">{{ count($ekskuls) }}</p>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4">
            <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Ekskul Aktif</p>
            <p class="mt-1 text-3xl font-bold text-emerald-600">{{ $totalAktif }}</p>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4">
            <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Nonaktif</p>
            <p class="mt-1 text-3xl font-bold text-slate-400">{{ count($ekskuls) - $totalAktif }}</p>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4">
            <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Total Peserta</p>
            <p class="mt-1 text-3xl font-bold text-blue-600">{{ $totalPeserta }}</p>
        </div>
    </div>

    {{-- Filters --}}
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4">
        <div class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1">
                <input type="text" placeholder="Cari nama ekstrakurikuler..."
                    class="block w-full rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-900 placeholder-slate-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500" />
            </div>
            <select class="rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                <option value="">Semua Kategori</option>
                <option>Organisasi</option>
                <option>Seni &amp; Budaya</option>
                <option>Bela Diri</option>
                <option>Akademik</option>
                <option>Keagamaan</option>
            </select>
            <select class="rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                <option value="">Semua Status</option>
                <option>Aktif</option>
                <option>Nonaktif</option>
            </select>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">No</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Nama Ekstrakurikuler</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Kategori</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Pembina</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Peserta</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($ekskuls as $i => $e)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 text-slate-500">{{ $i + 1 }}</td>
                        <td class="px-6 py-4">
                            <p class="font-semibold text-slate-900">{{ $e['nama'] }}</p>
                        </td>
                        <td class="px-6 py-4 text-slate-600">{{ $e['kategori'] }}</td>
                        <td class="px-6 py-4 text-slate-600">{{ $e['pembina'] }}</td>
                        <td class="px-6 py-4 text-slate-600">{{ $e['peserta'] }} orang</td>
                        <td class="px-6 py-4">
                            @if($e['aktif'])
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">Aktif</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-600">Nonaktif</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <a href="/admin/ekstrakurikuler/{{ $i + 1 }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">Detail</a>
                                <span class="text-slate-300">|</span>
                                <a href="/admin/ekstrakurikuler/{{ $i + 1 }}/edit" class="text-sm text-slate-600 hover:text-slate-900">Edit</a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="flex items-center justify-between px-6 py-4 border-t border-slate-100">
            <p class="text-sm text-slate-500">Menampilkan {{ count($ekskuls) }} dari {{ count($ekskuls) }} data</p>
            <div class="flex items-center gap-1">
                <button disabled class="px-3 py-1.5 text-sm text-slate-400 border border-slate-200 rounded-lg cursor-not-allowed">Sebelumnya</button>
                <button class="px-3 py-1.5 text-sm bg-blue-600 text-white border border-blue-600 rounded-lg">1</button>
                <button disabled class="px-3 py-1.5 text-sm text-slate-400 border border-slate-200 rounded-lg cursor-not-allowed">Berikutnya</button>
            </div>
        </div>
    </div>
</div>
@endsection
