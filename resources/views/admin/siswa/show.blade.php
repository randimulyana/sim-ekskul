@extends('layouts.admin')
@section('page-title', 'Detail Siswa')
@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.siswa.index') }}" class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-slate-700 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Kembali
            </a>
            <span class="text-slate-300">/</span>
            <span class="text-sm text-slate-500">{{ $student->user->name ?? $student->nis }}</span>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.siswa.edit', $student->id) }}"
               class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2.5 rounded-lg transition-colors shadow-sm self-start">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Edit Data Siswa
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Student Info Card --}}
        <div class="lg:col-span-1 space-y-4">
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                <div class="flex flex-col items-center text-center mb-6">
                    <div class="w-20 h-20 bg-blue-600 text-white rounded-full flex items-center justify-center text-2xl font-bold mb-3">
                        {{ strtoupper(substr($student->user->name ?? 'S', 0, 2)) }}
                    </div>
                    <h2 class="text-lg font-bold text-slate-900">{{ $student->user->name ?? '-' }}</h2>
                    <p class="text-sm text-slate-500">{{ $student->class_name }}</p>
                    <span class="mt-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $student->status === 'active' ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                        {{ $student->status === 'active' ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </div>
                <div class="space-y-3 text-sm">
                    <div class="flex items-start gap-3">
                        <span class="text-slate-400 w-5 flex-shrink-0 mt-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/></svg>
                        </span>
                        <div>
                            <p class="text-xs text-slate-400 mb-0.5">NIS</p>
                            <p class="font-mono font-medium text-slate-900">{{ $student->nis }}</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <span class="text-slate-400 w-5 flex-shrink-0 mt-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        </span>
                        <div>
                            <p class="text-xs text-slate-400 mb-0.5">Kelas</p>
                            <p class="font-medium text-slate-900">{{ $student->class_name }}</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <span class="text-slate-400 w-5 flex-shrink-0 mt-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        </span>
                        <div>
                            <p class="text-xs text-slate-400 mb-0.5">WhatsApp</p>
                            <p class="font-medium text-slate-900">{{ $student->whatsapp ?: '-' }}</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <span class="text-slate-400 w-5 flex-shrink-0 mt-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </span>
                        <div>
                            <p class="text-xs text-slate-400 mb-0.5">Email</p>
                            <p class="font-medium text-slate-900 break-all">{{ $student->user->email ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <span class="text-slate-400 w-5 flex-shrink-0 mt-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </span>
                        <div>
                            <p class="text-xs text-slate-400 mb-0.5">Terdaftar Sejak</p>
                            <p class="font-medium text-slate-900">{{ $student->created_at->translatedFormat('d F Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Column --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Registration History --}}
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm">
                <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="text-base font-semibold text-slate-900">Riwayat Pendaftaran Ekskul</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200">
                                <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Ekskul</th>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Periode</th>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Tanggal</th>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                                <th class="text-right px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @php
                            $sc = [
                                'accepted' => ['bg' => 'bg-emerald-100 text-emerald-700', 'label' => 'Diterima'],
                                'rejected' => ['bg' => 'bg-red-100 text-red-700', 'label' => 'Ditolak'],
                                'submitted' => ['bg' => 'bg-blue-100 text-blue-700', 'label' => 'Terkirim'],
                                'reviewed' => ['bg' => 'bg-amber-100 text-amber-700', 'label' => 'Ditinjau'],
                                'cancelled' => ['bg' => 'bg-slate-100 text-slate-700', 'label' => 'Dibatalkan'],
                            ];
                            @endphp
                            @forelse($student->registrations as $r)
                            <tr class="hover:bg-slate-50">
                                <td class="px-6 py-3.5 font-medium text-slate-900">{{ $r->extracurricular->name ?? '-' }}</td>
                                <td class="px-6 py-3.5 text-slate-500 text-xs">{{ $r->period->school_year ?? '-' }}</td>
                                <td class="px-6 py-3.5 text-slate-500">{{ $r->created_at->translatedFormat('d M Y') }}</td>
                                <td class="px-6 py-3.5">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $sc[$r->status]['bg'] ?? 'bg-slate-100 text-slate-700' }}">
                                        {{ $sc[$r->status]['label'] ?? ucfirst($r->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-3.5 text-right">
                                    <a href="{{ route('admin.pendaftaran.show', $r->id) }}" class="text-xs text-blue-600 hover:underline font-medium">Detail</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-slate-400 text-xs">
                                    Belum ada riwayat pendaftaran untuk siswa ini.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Recommendation Preview --}}
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm">
                <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="text-base font-semibold text-slate-900">Hasil Rekomendasi Sistem</h3>
                    @if($student->recommendations->isNotEmpty())
                        <a href="{{ route('admin.rekomendasi.show', $student->recommendations->first()->id) }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">Detail Analisis</a>
                    @endif
                </div>
                <div class="p-6 space-y-3">
                    @php
                    $latestRec = $student->recommendations->first();
                    $barColors = ['bg-blue-600', 'bg-blue-500', 'bg-blue-400'];
                    @endphp
                    @if($latestRec && $latestRec->items->isNotEmpty())
                        @foreach($latestRec->items->take(3) as $i => $item)
                        <div class="flex items-center gap-4">
                            <div class="w-8 h-8 {{ $barColors[$i % count($barColors)] }} text-white rounded-lg flex items-center justify-center text-xs font-bold flex-shrink-0">
                                #{{ $item->rank }}
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between text-sm mb-1">
                                    <span class="font-medium text-slate-900">{{ $item->extracurricular->name ?? '-' }}</span>
                                    <span class="text-slate-500 font-semibold">{{ round($item->score * 100) }}%</span>
                                </div>
                                <div class="w-full bg-slate-100 rounded-full h-1.5">
                                    <div class="{{ $barColors[$i % count($barColors)] }} h-1.5 rounded-full" style="width: {{ min(100, round($item->score * 100)) }}%"></div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        <p class="text-xs text-slate-400 pt-2 border-t border-slate-100 mt-4">Dianalisis pada {{ $latestRec->created_at->translatedFormat('d F Y') }} &middot; Berdasarkan hasil kuesioner</p>
                    @else
                        <div class="py-6 text-center text-slate-400 text-xs">
                            Siswa ini belum memiliki hasil rekomendasi kuesioner.
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>

</div>
@endsection
