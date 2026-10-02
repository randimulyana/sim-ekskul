@extends('layouts.admin')

@section('page-title', 'Matriks Mapping Kriteria Ekstrakurikuler')

@section('content')
<div class="space-y-6">

    <!-- Back button & Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <a href="{{ route('admin.kriteria.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-slate-800 transition-colors mb-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Kriteria
            </a>
            <h1 class="text-2xl font-bold text-slate-900">Matriks Mapping Kriteria Ekstrakurikuler</h1>
            <p class="mt-1 text-sm text-slate-500">Struktur pemetaan kebutuhan kriteria (C1–C5) terhadap masing-masing ekstrakurikuler.</p>
        </div>
        <div>
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold bg-amber-100 text-amber-900 border border-amber-200">
                <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                Status: Needs Validation (Belum Ada Profil Resmi)
            </span>
        </div>
    </div>

    <!-- Mandatory Warning Banner (PRD & Rules Section 8-10) -->
    <div class="bg-amber-50 border border-amber-200 rounded-xl p-5 text-amber-900 text-xs leading-relaxed space-y-2">
        <div class="flex items-center gap-2 font-bold text-sm text-amber-800">
            <svg class="w-5 h-5 text-amber-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            [PERLU KONFIRMASI] Prinsip Integritas Data & Validasi Sekolah:
        </div>
        <p>
            1. <strong>Daftar Ekstrakurikuler:</strong> 12 ekstrakurikuler di bawah merupakan <em>data observasi awal</em> di lingkungan SMK Negeri 3 Payakumbuh, bukan daftar resmi final.
        </p>
        <p>
            2. <strong>Larangan Mengarang Nilai Ideal:</strong> Belum ada dokumen profil kriteria ideal atau standar pembina untuk masing-masing ekskul. Sesuai prinsip penelitian objektif, sistem <strong>TIDAK MENGARANG</strong> angka/matriks nilai ideal secara sembarangan.
        </p>
        <p>
            3. Seluruh sel di bawah berstatus <strong>NEEDS_VALIDATION</strong> sampai pihak sekolah/pembina menetapkan instrumen penilaian resmi.
        </p>
    </div>

    <!-- Matrix Table -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <h2 class="text-sm font-bold text-slate-900">Matriks Ekstrakurikuler &times; Kriteria</h2>
            <span class="text-xs text-slate-400">12 Ekskul Observasi &times; 5 Kriteria</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left">
                <thead class="bg-slate-50 border-b border-slate-200 font-semibold text-slate-700 uppercase tracking-wider">
                    <tr>
                        <th class="px-4 py-3.5 w-12 text-center">No</th>
                        <th class="px-4 py-3.5 min-w-[180px]">Ekstrakurikuler (Observed)</th>
                        <th class="px-4 py-3.5 min-w-[120px]">Kategori</th>
                        @foreach($criteria as $c)
                        <th class="px-4 py-3.5 text-center min-w-[110px]">
                            <div class="font-bold text-blue-700">{{ $c->code }}</div>
                            <div class="text-[10px] text-slate-500 font-normal">{{ $c->name }} ({{ round($c->weight * 100) }}%)</div>
                        </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($extracurriculars as $i => $ekskul)
                    <tr class="hover:bg-slate-50/70 transition-colors">
                        <td class="px-4 py-3.5 text-center text-slate-400 font-mono">{{ $i + 1 }}</td>
                        <td class="px-4 py-3.5">
                            <span class="font-bold text-slate-900">{{ $ekskul->name }}</span>
                            <span class="block text-[10px] text-amber-700 font-medium">Observed Data</span>
                        </td>
                        <td class="px-4 py-3.5 text-slate-500">{{ $ekskul->category ?? 'Umum' }}</td>
                        @foreach($criteria as $c)
                            @php
                                $key = "{$ekskul->id}_{$c->id}";
                                $mappedItem = $mappings->get($key)?->first();
                            @endphp
                            <td class="px-4 py-3.5 text-center">
                                @if($mappedItem && $mappedItem->status === 'validated')
                                    <span class="px-2 py-0.5 rounded font-bold text-xs bg-emerald-100 text-emerald-800">
                                        {{ $mappedItem->value }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-medium bg-amber-50 text-amber-700 border border-amber-200" title="Nilai ideal belum ditetapkan pihak sekolah">
                                        Perlu Validasi
                                    </span>
                                @endif
                            </td>
                        @endforeach
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ 3 + $criteria->count() }}" class="px-4 py-8 text-center text-sm text-slate-400">
                            Belum ada data ekstrakurikuler.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-3 bg-slate-50 border-t border-slate-100 text-right text-[11px] text-slate-500">
            * Seluruh ekstrakurikuler dan sel kriteria siap untuk dihubungkan pada Phase 5 setelah ada instrumen pembina.
        </div>
    </div>

</div>
@endsection
