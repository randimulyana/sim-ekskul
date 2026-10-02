@extends('layouts.admin')

@section('page-title', 'Kriteria & Bobot Rekomendasi')

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Kriteria & Bobot Rekomendasi</h1>
            <p class="mt-1 text-sm text-slate-500">Konfigurasi bobot kriteria dan skala indikator penilaian untuk sistem rekomendasi.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.kriteria.mapping') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 text-sm font-medium rounded-lg shadow-sm transition-colors">
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                Matriks Ekskul
            </a>
            <a href="{{ route('admin.kriteria.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow-sm transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Kriteria
            </a>
        </div>
    </div>

    <!-- Notice Banner: Data Status Classification -->
    <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 flex items-start gap-3 text-amber-900 text-xs leading-relaxed">
        <svg class="w-5 h-5 text-amber-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
        <div class="space-y-1">
            <p class="font-bold uppercase tracking-wider text-amber-800">Status Data: Proposed / Needs Validation</p>
            <p class="text-amber-700">
                Kriteria, bobot, dan skala indikator di bawah merupakan <strong>usulan rancangan penelitian</strong> awal dan belum ditetapkan secara resmi oleh pihak SMK Negeri 3 Payakumbuh. Algoritma perhitungan matematis SAW baru akan diaktifkan pada <strong>Phase 5</strong> setelah seluruh data terverifikasi.
            </p>
        </div>
    </div>

    <!-- Stat Cards Row -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Card 1: Total Kriteria -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5">
            <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Total Kriteria</p>
            <div class="mt-2 flex items-baseline justify-between">
                <span class="text-2xl font-bold text-slate-900">{{ $criteria->count() }} Kriteria</span>
                <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-blue-100 text-blue-700">Aktif</span>
            </div>
            <p class="mt-2 text-xs text-slate-400">C1 s/d C5 (Usulan Penelitian)</p>
        </div>

        <!-- Card 2: Total Bobot -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5">
            <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Total Bobot</p>
            <div class="mt-2 flex items-baseline justify-between">
                <span class="text-2xl font-bold {{ $isWeightValid ? 'text-emerald-600' : 'text-red-600' }}">
                    {{ round($totalWeight * 100, 2) }}%
                </span>
                <span class="text-xs font-semibold px-2 py-0.5 rounded-full {{ $isWeightValid ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                    {{ $isWeightValid ? 'Valid (1.00)' : 'Tidak Valid' }}
                </span>
            </div>
            <p class="mt-2 text-xs text-slate-400">Target bobot normalisasi: 100%</p>
        </div>

        <!-- Card 3: Pertanyaan Terpetakan -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5">
            <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Pemetaan Kuesioner</p>
            <div class="mt-2 flex items-baseline justify-between">
                <span class="text-2xl font-bold text-slate-900">{{ $completeness['mapped_questions_count'] }} / {{ $completeness['total_active_questions'] }}</span>
                <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-slate-100 text-slate-700">Pertanyaan</span>
            </div>
            <p class="mt-2 text-xs text-slate-400">1 kualitatif (textarea) unmapped</p>
        </div>

        <!-- Card 4: Kesiapan SAW -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5">
            <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Kesiapan SAW</p>
            <div class="mt-2 flex items-baseline justify-between">
                <span class="text-base font-bold {{ $completeness['status'] === 'READY_FOR_SAW' ? 'text-emerald-600' : 'text-amber-600' }}">
                    {{ $completeness['status'] === 'READY_FOR_SAW' ? 'READY FOR SAW' : 'NOT READY' }}
                </span>
                <span class="text-xs font-semibold px-2 py-0.5 rounded-full {{ $completeness['status'] === 'READY_FOR_SAW' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                    Phase 4 Conf
                </span>
            </div>
            <p class="mt-2 text-xs text-slate-400">Menunggu validasi matriks ekskul</p>
        </div>
    </div>

    <!-- Configuration Issues Banner if NOT_READY -->
    @if($completeness['status'] !== 'READY_FOR_SAW' && !empty($completeness['issues']))
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 space-y-3">
        <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2">
            <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>
            Catatan Kelengkapan Konfigurasi Rekomendasi:
        </h3>
        <ul class="space-y-1.5 text-xs text-slate-600 pl-5 list-disc">
            @foreach($completeness['issues'] as $issue)
                <li>{{ $issue }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Criteria Table -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <h2 class="text-base font-bold text-slate-900">Daftar Kriteria & Bobot (5 Kriteria Awal)</h2>
            <span class="text-xs text-slate-500 font-medium">Σ Bobot: {{ round($totalWeight * 100, 2) }}%</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-50 border-b border-slate-200 text-xs font-semibold text-slate-600 uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-3.5">Kode</th>
                        <th class="px-6 py-3.5">Nama Kriteria</th>
                        <th class="px-6 py-3.5">Bobot (W)</th>
                        <th class="px-6 py-3.5">Atribut</th>
                        <th class="px-6 py-3.5">Skala Nilai</th>
                        <th class="px-6 py-3.5">Pertanyaan</th>
                        <th class="px-6 py-3.5">Status Validasi</th>
                        <th class="px-6 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($criteria as $criterion)
                    <tr class="hover:bg-slate-50/70 transition-colors">
                        <td class="px-6 py-4 font-bold text-blue-600">
                            {{ $criterion->code }}
                        </td>
                        <td class="px-6 py-4">
                            <p class="font-semibold text-slate-900">{{ $criterion->name }}</p>
                            @if($criterion->description)
                                <p class="text-xs text-slate-500 mt-0.5 line-clamp-1 max-w-sm">{{ $criterion->description }}</p>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-slate-100 text-slate-800">
                                {{ round($criterion->weight * 100, 2) }}% ({{ number_format($criterion->weight, 2) }})
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $criterion->isBenefit() ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-amber-50 text-amber-700 border border-amber-200' }}">
                                {{ ucfirst($criterion->type) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-xs text-slate-600">
                            {{ $criterion->values->count() }} Tingkat (1–5)
                        </td>
                        <td class="px-6 py-4 text-xs text-slate-600">
                            {{ $criterion->questions->count() }} Butir
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-medium bg-amber-100 text-amber-800">
                                {{ $criterion->status_label }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2 text-xs">
                                <a href="{{ route('admin.kriteria.show', $criterion->id) }}" class="text-blue-600 hover:text-blue-800 font-medium">
                                    Detail
                                </a>
                                <span class="text-slate-300">|</span>
                                <a href="{{ route('admin.kriteria.edit', $criterion->id) }}" class="text-slate-600 hover:text-slate-800 font-medium">
                                    Edit
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-8 text-center text-sm text-slate-400">
                            Belum ada kriteria yang dikonfigurasi.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
                @if($criteria->isNotEmpty())
                <tfoot class="bg-slate-50 border-t border-slate-200 font-semibold text-xs text-slate-700">
                    <tr>
                        <td colspan="2" class="px-6 py-3 uppercase">Total Bobot</td>
                        <td class="px-6 py-3 font-bold {{ $isWeightValid ? 'text-emerald-600' : 'text-red-600' }}">
                            {{ round($totalWeight * 100, 2) }}% ({{ number_format($totalWeight, 2) }})
                        </td>
                        <td colspan="5" class="px-6 py-3 text-right text-slate-500">
                            {{ $isWeightValid ? '✓ Total bobot memenuhi syarat normalisasi 100%' : '⚠ Total bobot belum sama dengan 100%' }}
                        </td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>

</div>
@endsection
