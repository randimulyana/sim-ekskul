@extends('layouts.admin')

@section('page-title', 'Detail Kriteria ' . $criterion->code)

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Back button & Breadcrumb -->
    <div>
        <a href="{{ route('admin.kriteria.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-slate-800 transition-colors mb-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Daftar Kriteria
        </a>
    </div>

    <!-- Header Card -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 sm:p-7">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <span class="px-2.5 py-0.5 rounded text-xs font-bold bg-blue-100 text-blue-700">
                        {{ $criterion->code }}
                    </span>
                    <span class="px-2.5 py-0.5 rounded text-xs font-medium bg-amber-100 text-amber-800">
                        {{ $criterion->status_label }}
                    </span>
                    <span class="px-2.5 py-0.5 rounded text-xs font-medium {{ $criterion->isBenefit() ? 'bg-emerald-50 text-emerald-700' : 'bg-rose-50 text-rose-700' }}">
                        Atribut: {{ ucfirst($criterion->type) }}
                    </span>
                </div>
                <h1 class="text-2xl font-bold text-slate-900">{{ $criterion->name }}</h1>
                <p class="text-sm text-slate-500 mt-1">{{ $criterion->description ?? 'Tidak ada deskripsi tambahan.' }}</p>
            </div>
            <div class="text-left sm:text-right bg-slate-50 p-4 rounded-xl border border-slate-100 min-w-[160px]">
                <p class="text-xs uppercase font-medium text-slate-400">Bobot Preferensi</p>
                <p class="text-3xl font-extrabold text-blue-600 mt-0.5">{{ round($criterion->weight * 100, 2) }}%</p>
                <p class="text-[11px] text-slate-500 mt-0.5">Nilai desimal: {{ number_format($criterion->weight, 4) }}</p>
            </div>
        </div>
    </div>

    <!-- Scale Indicator Table (1-5) -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <h2 class="text-sm font-bold text-slate-900">Skala Penilaian Indikator (1 – 5)</h2>
            <span class="text-xs text-amber-700 font-medium bg-amber-50 px-2.5 py-1 rounded-md">Status: Proposed Scale</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-50 border-b border-slate-200 text-xs font-semibold text-slate-600 uppercase">
                    <tr>
                        <th class="px-6 py-3 w-20">Nilai</th>
                        <th class="px-6 py-3">Label Tingkat</th>
                        <th class="px-6 py-3">Keterangan Indikator</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($criterion->values as $val)
                    <tr>
                        <td class="px-6 py-3 font-bold text-slate-900">
                            {{ (int) $val->value }}
                        </td>
                        <td class="px-6 py-3 font-semibold text-slate-700">
                            {{ $val->label }}
                        </td>
                        <td class="px-6 py-3 text-xs text-slate-500">
                            {{ $val->description ?? '-' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-center text-sm text-slate-400">Belum ada indikator skala untuk kriteria ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pertanyaan Terpetakan -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <h2 class="text-sm font-bold text-slate-900">Pertanyaan Kuesioner Terpetakan ({{ $criterion->questions->count() }} Butir)</h2>
            <a href="{{ route('admin.kuesioner.index') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-700">Kelola di Kuesioner &rarr;</a>
        </div>

        <div class="divide-y divide-slate-100">
            @forelse($criterion->questions as $q)
            <div class="p-6 space-y-2">
                <div class="flex items-center gap-2">
                    <span class="px-2 py-0.5 rounded text-[11px] font-semibold bg-slate-100 text-slate-700 uppercase">
                        {{ $q->category }}
                    </span>
                    <span class="px-2 py-0.5 rounded text-[11px] font-medium bg-blue-50 text-blue-700 uppercase">
                        Tipe: {{ $q->type }}
                    </span>
                </div>
                <p class="text-sm font-semibold text-slate-800">{{ $q->question }}</p>
                @if($q->options->isNotEmpty())
                <div class="flex flex-wrap gap-1.5 pt-1">
                    @foreach($q->options as $opt)
                    <span class="inline-flex items-center gap-1 text-[11px] px-2.5 py-1 rounded bg-slate-50 border border-slate-200 text-slate-600">
                        {{ $opt->label }}
                        @if($opt->value !== null)
                            <strong class="text-blue-600">({{ $opt->value }})</strong>
                        @endif
                    </span>
                    @endforeach
                </div>
                @endif
            </div>
            @empty
            <div class="p-6 text-center text-sm text-slate-400">
                Belum ada pertanyaan kuesioner yang dipetakan ke kriteria ini.
            </div>
            @endforelse
        </div>
    </div>

</div>
@endsection
