@extends('layouts.admin')
@section('page-title', 'Laporan & Rekap')
@section('content')
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
                title="Fitur export file spreadsheet dalam pengembangan"
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
        <form method="GET" action="{{ route('admin.laporan') }}" class="flex flex-col sm:flex-row gap-3 items-end">
            <div class="flex-1">
                <label class="block text-xs font-medium text-slate-500 mb-1">Pilih Periode Pendaftaran</label>
                <select name="period_id" class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 bg-white">
                    <option value="">Semua Periode</option>
                    @foreach($periods ?? [] as $per)
                        <option value="{{ $per->id }}" {{ ($selectedPeriodId ?? null) == $per->id ? 'selected' : '' }}>
                            {{ $per->name }} ({{ $per->school_year }}) {{ $per->is_active ? '— Aktif' : '' }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <button type="submit" class="px-5 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                    Terapkan
                </button>
            </div>
        </form>
    </div>

    <!-- Summary Stats -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5">
            <p class="text-xs font-medium text-slate-500 mb-1">Total Pendaftar</p>
            <p class="text-2xl font-bold text-blue-600">{{ $totalRegistrations ?? 0 }}</p>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5">
            <p class="text-xs font-medium text-slate-500 mb-1">Diterima</p>
            <p class="text-2xl font-bold text-emerald-600">{{ $totalAccepted ?? 0 }}</p>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5">
            <p class="text-xs font-medium text-slate-500 mb-1">Menunggu / Ditinjau</p>
            <p class="text-2xl font-bold text-amber-600">{{ $totalReviewed ?? 0 }}</p>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5">
            <p class="text-xs font-medium text-slate-500 mb-1">Ditolak</p>
            <p class="text-2xl font-bold text-red-600">{{ $totalRejected ?? 0 }}</p>
        </div>
    </div>

    <!-- Rekap Table -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm">
        <div class="px-6 py-4 border-b border-slate-100">
            <h3 class="text-base font-semibold text-slate-900">Rekap per Ekstrakurikuler</h3>
            <p class="text-xs text-slate-500 mt-0.5">Rincian sebaran status pendaftaran per ekstrakurikuler</p>
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
                    @forelse($ekskuls ?? [] as $i => $e)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 text-slate-500">{{ $i + 1 }}</td>
                        <td class="px-6 py-4 font-semibold text-slate-900">{{ $e->name }}</td>
                        <td class="px-6 py-4 text-slate-600">{{ $e->category ?: '-' }}</td>
                        <td class="px-6 py-4 text-right font-bold text-slate-900">{{ $e->total_pendaftar ?? 0 }}</td>
                        <td class="px-6 py-4 text-right text-emerald-600 font-semibold">{{ $e->diterima_count ?? 0 }}</td>
                        <td class="px-6 py-4 text-right text-amber-600 font-semibold">{{ $e->menunggu_count ?? 0 }}</td>
                        <td class="px-6 py-4 text-right text-red-600 font-semibold">{{ $e->ditolak_count ?? 0 }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-10 text-center text-slate-400">
                            Tidak ada data rekap ekstrakurikuler.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
