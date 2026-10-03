@extends('layouts.student')

@section('title', 'Riwayat Pendaftaran')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Riwayat Pendaftaran</h1>
            <p class="text-sm text-slate-500 mt-1">Daftar pengajuan pemilihan ekstrakurikuler yang pernah kamu buat</p>
        </div>
        <a href="{{ route('siswa.pendaftaran.index') }}" class="self-start sm:self-auto inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-lg shadow-sm transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Formulir Pendaftaran
        </a>
    </div>

    @if($registrations->isNotEmpty())
        @php
            $latest = $registrations->first();
            $statusLabels = [
                'submitted' => 'Terkirim (Submitted)',
                'reviewed' => 'Ditinjau (Reviewed)',
                'accepted' => 'Diterima (Accepted)',
                'rejected' => 'Ditolak (Rejected)',
                'cancelled' => 'Dibatalkan',
            ];
            $statusBadges = [
                'submitted' => 'bg-blue-100 text-blue-800 border-blue-200',
                'reviewed' => 'bg-amber-100 text-amber-800 border-amber-200',
                'accepted' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                'rejected' => 'bg-red-100 text-red-800 border-red-200',
                'cancelled' => 'bg-slate-100 text-slate-700 border-slate-200',
            ];
        @endphp

        <!-- Notifikasi Pendaftaran Terakhir -->
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 flex items-start sm:items-center justify-between gap-3 text-xs text-blue-900">
            <div class="flex items-center gap-2.5">
                <span class="w-2.5 h-2.5 rounded-full bg-blue-600 animate-pulse"></span>
                <div>
                    <strong>Pendaftaran Terakhir:</strong> {{ $latest->extracurricular?->name }} (No: {{ $latest->registration_number }}) &mdash; Status: <span class="font-bold underline text-blue-800">{{ $statusLabels[$latest->status] ?? ucfirst($latest->status) }}</span>.
                </div>
            </div>
            <span class="text-blue-700 font-semibold text-[11px] whitespace-nowrap">{{ $latest->period?->name ?? 'Periode Aktif' }}</span>
        </div>

        <!-- Table Container for Desktop, Card for Mobile -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <h3 class="text-sm font-bold text-slate-900">Semua Pengajuan ({{ $registrations->count() }})</h3>
                <span class="text-xs text-slate-500">{{ $student->name }} · {{ $student->class_name ?? 'Siswa' }}</span>
            </div>

            <!-- Desktop Table View -->
            <div class="hidden sm:block overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase tracking-wider font-semibold">
                        <tr>
                            <th class="px-6 py-3.5">No. Registrasi</th>
                            <th class="px-6 py-3.5">Ekstrakurikuler</th>
                            <th class="px-6 py-3.5">Periode / Tanggal</th>
                            <th class="px-6 py-3.5">Status</th>
                            <th class="px-6 py-3.5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($registrations as $r)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="px-6 py-4 font-mono font-bold text-slate-800">
                                {{ $r->registration_number }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-bold text-slate-900 block text-sm">{{ $r->extracurricular?->name }}</span>
                                <span class="text-slate-400 text-[11px]">{{ $r->extracurricular?->category }}</span>
                            </td>
                            <td class="px-6 py-4 text-slate-600">
                                <span class="font-medium block text-slate-800">{{ $r->period?->name ?? '-' }}</span>
                                <span class="text-slate-400 text-[11px]">{{ $r->registered_at ? $r->registered_at->format('d M Y') : '-' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold border {{ $statusBadges[$r->status] ?? 'bg-slate-100 text-slate-700 border-slate-200' }}">
                                    {{ $statusLabels[$r->status] ?? ucfirst($r->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('siswa.pendaftaran.sukses') }}" class="text-blue-600 hover:text-blue-800 font-semibold text-xs">
                                    Lihat Detail &rarr;
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Mobile Card View -->
            <div class="sm:hidden divide-y divide-slate-100">
                @foreach($registrations as $r)
                <div class="p-4 space-y-3">
                    <div class="flex items-start justify-between">
                        <div>
                            <span class="font-mono text-xs font-bold text-slate-500">{{ $r->registration_number }}</span>
                            <h4 class="text-base font-bold text-slate-900 mt-0.5">{{ $r->extracurricular?->name }}</h4>
                            <span class="text-[11px] text-slate-400">{{ $r->extracurricular?->category }}</span>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold border {{ $statusBadges[$r->status] ?? 'bg-slate-100 text-slate-700' }}">
                            {{ $statusLabels[$r->status] ?? ucfirst($r->status) }}
                        </span>
                    </div>

                    <div class="bg-slate-50 rounded-lg p-2.5 text-xs text-slate-600 space-y-1">
                        <div class="flex justify-between">
                            <span class="text-slate-400">Periode:</span>
                            <span class="font-medium text-slate-800">{{ $r->period?->name ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-400">Tanggal:</span>
                            <span class="font-medium text-slate-800">{{ $r->registered_at ? $r->registered_at->format('d M Y') : '-' }}</span>
                        </div>
                    </div>

                    <div class="text-right pt-1">
                        <a href="{{ route('siswa.pendaftaran.sukses') }}" class="inline-flex items-center gap-1 text-xs font-bold text-blue-600 hover:text-blue-800">
                            <span>Lihat Detail Status</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>

        </div>
    @else
        <!-- Empty State -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-12 text-center">
            <div class="w-16 h-16 bg-slate-100 text-slate-400 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <h3 class="text-base font-bold text-slate-900">Belum Ada Riwayat Pendaftaran</h3>
            <p class="text-xs text-slate-500 max-w-sm mx-auto mt-1 leading-relaxed">
                Kamu belum pernah mengajukan pendaftaran ekstrakurikuler. Silakan lengkapi kuesioner dan pilih ekstrakurikuler yang kamu minati.
            </p>
            <div class="mt-6 flex flex-col sm:flex-row items-center justify-center gap-3">
                <a href="{{ route('siswa.rekomendasi.index') }}" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-lg shadow-sm transition-colors">
                    Lihat Rekomendasi
                </a>
                <a href="{{ route('siswa.pendaftaran.index') }}" class="px-5 py-2.5 border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-semibold rounded-lg transition-colors">
                    Daftar Langsung
                </a>
            </div>
        </div>
    @endif

</div>
@endsection
