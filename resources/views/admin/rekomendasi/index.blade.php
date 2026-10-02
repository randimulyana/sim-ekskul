@extends('layouts.admin')

@section('page-title', 'Hasil Rekomendasi Siswa')

@section('content')
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

    <!-- Table Card -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <h3 class="text-sm font-bold text-slate-900">Rekap Analisis Rekomendasi ({{ isset($recommendations) ? $recommendations->total() : 0 }} Data)</h3>
        </div>

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
                    @forelse($recommendations ?? [] as $i => $row)
                    @php
                    $topItem = $row->items->sortBy('rank')->first();
                    @endphp
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-3.5 text-slate-400 font-mono">{{ ($recommendations->firstItem() ?? 1) + $i }}</td>
                        <td class="px-6 py-3.5">
                            <span class="font-bold text-slate-900 block text-xs">{{ $row->student->user->name ?? '-' }}</span>
                            <span class="text-slate-400 font-mono text-[11px]">NIS: {{ $row->student->nis ?? '-' }}</span>
                        </td>
                        <td class="px-6 py-3.5 text-slate-700 font-medium">{{ $row->student->class_name ?? '-' }}</td>
                        <td class="px-6 py-3.5">
                            <span class="font-bold text-slate-800 block text-xs">{{ $topItem->extracurricular->name ?? '-' }}</span>
                            <span class="text-[10px] text-slate-400">{{ $topItem->extracurricular->category ?? 'Umum' }}</span>
                        </td>
                        <td class="px-6 py-3.5">
                            <div class="flex items-center gap-2">
                                <span class="font-extrabold text-blue-600 text-sm font-mono">{{ $topItem ? round($topItem->score * 100) : '-' }}</span>
                                <span class="text-[10px] text-slate-400">/ 100</span>
                            </div>
                        </td>
                        <td class="px-6 py-3.5 text-slate-500">{{ $row->created_at->translatedFormat('d M Y') }}</td>
                        <td class="px-6 py-3.5 text-right">
                            <a href="{{ route('admin.rekomendasi.show', $row->id) }}" class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-800 font-bold">
                                Detail &rarr;
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-slate-400">
                            Belum ada hasil rekomendasi yang tersimpan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(isset($recommendations) && $recommendations->hasPages())
        <div class="px-6 py-4 border-t border-slate-100">
            {{ $recommendations->links() }}
        </div>
        @endif
    </div>

</div>
@endsection
