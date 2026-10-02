@extends('layouts.admin')

@section('page-title', 'Kelola Kuesioner')

@section('content')
<div class="space-y-6">

    <!-- Header & Action -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Kelola Instrumen Kuesioner</h1>
            <p class="text-xs text-slate-500 mt-1">Daftar butir pertanyaan minat dan karakteristik siswa untuk instrumen kuesioner</p>
        </div>
        <a href="{{ route('admin.kuesioner.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-lg shadow-sm transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Pertanyaan
        </a>
    </div>

    <!-- Alert Instrument notice -->
    <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 flex items-start gap-3 text-xs text-amber-800">
        <svg class="w-5 h-5 text-amber-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <div>
            <span class="font-bold">[PERLU KONFIRMASI] Validitas Instrumen:</span> Butir pertanyaan berikut merupakan draft instrumen kuesioner. Butir pertanyaan dan skala penilaian dapat disesuaikan kembali dengan pihak sekolah.
        </div>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <h3 class="text-sm font-bold text-slate-900">Daftar Pertanyaan (Total: {{ isset($questions) ? $questions->total() : 0 }} Butir)</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase tracking-wider font-semibold">
                    <tr>
                        <th class="px-6 py-3.5 w-16">Urutan</th>
                        <th class="px-6 py-3.5">Butir Pertanyaan</th>
                        <th class="px-6 py-3.5">Kategori</th>
                        <th class="px-6 py-3.5">Kriteria</th>
                        <th class="px-6 py-3.5">Tipe Jawaban</th>
                        <th class="px-6 py-3.5">Opsi</th>
                        <th class="px-6 py-3.5">Status</th>
                        <th class="px-6 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @php
                    $typeLabels = [
                        'radio' => 'Pilihan Tunggal (Radio)',
                        'checkbox' => 'Pilihan Ganda (Checkbox)',
                        'likert' => 'Skala Likert (1-5)',
                        'textarea' => 'Esai Singkat (Textarea)',
                    ];
                    @endphp
                    @forelse($questions ?? [] as $q)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-3.5 font-mono font-bold text-slate-400 text-center">{{ $q->order }}</td>
                        <td class="px-6 py-3.5">
                            <span class="font-bold text-slate-800 block text-xs">{{ $q->question_text }}</span>
                        </td>
                        <td class="px-6 py-3.5">
                            <span class="inline-block px-2 py-0.5 rounded bg-slate-100 text-slate-700 font-medium text-[11px]">
                                {{ $q->category }}
                            </span>
                        </td>
                        <td class="px-6 py-3.5">
                            @if($q->criterion)
                                <span class="inline-block px-2 py-0.5 rounded bg-blue-50 text-blue-700 font-bold text-[11px]" title="{{ $q->criterion->name }}">
                                    {{ $q->criterion->code }}
                                </span>
                            @else
                                <span class="inline-block px-1.5 py-0.5 rounded bg-slate-100 text-slate-400 text-[10px]">
                                    -
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-3.5 text-slate-600 font-medium">{{ $typeLabels[$q->type] ?? ucfirst($q->type) }}</td>
                        <td class="px-6 py-3.5 text-slate-500 font-mono">{{ $q->options->count() }} opsi</td>
                        <td class="px-6 py-3.5">
                            @if($q->is_active)
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                    Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600">
                                    Nonaktif
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-3.5 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.kuesioner.edit', $q->id) }}" class="text-blue-600 hover:text-blue-800 font-semibold">
                                    Edit
                                </a>
                                <span class="text-slate-300">|</span>
                                <form method="POST" action="{{ route('admin.kuesioner.toggle', $q->id) }}" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-slate-500 hover:text-slate-800 font-medium">
                                        {{ $q->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                    </button>
                                </form>
                                <span class="text-slate-300">|</span>
                                <form method="POST" action="{{ route('admin.kuesioner.destroy', $q->id) }}" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pertanyaan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 font-medium">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-slate-400">
                            Belum ada pertanyaan kuesioner.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(isset($questions) && $questions->hasPages())
        <div class="px-6 py-4 border-t border-slate-100">
            {{ $questions->links() }}
        </div>
        @endif
    </div>

</div>
@endsection
