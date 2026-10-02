@extends('layouts.student')

@section('title', 'Rekomendasi Ekstrakurikuler')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Rekomendasi Untukmu</h1>
            <p class="text-sm text-slate-500 mt-1">
                Dianalisis menggunakan metode <strong>Simple Additive Weighting (SAW)</strong> untuk periode {{ $activePeriod?->name ?? 'aktif' }}.
            </p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('siswa.kuesioner.index') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 border border-slate-200 text-slate-700 hover:bg-slate-50 text-xs font-semibold rounded-lg transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                Perbarui Kuesioner
            </a>
            <a href="{{ route('siswa.pendaftaran.index') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-lg shadow-sm transition-colors">
                Formulir Pendaftaran &rarr;
            </a>
        </div>
    </div>

    <!-- Skor Kecocokan Notice -->
    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 flex items-start gap-3 text-blue-900 text-xs leading-relaxed">
        <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <div>
            <strong>Catatan Penggunaan Rekomendasi:</strong> Skor di bawah adalah <strong>Skor Kecocokan (Preferensi SAW)</strong> berdasarkan preferensi jawaban kuesionermu, <em>bukan</em> penilaian mutlak bakat atau potensi psikologis. Kamu tetap bebas mendaftar ke ekstrakurikuler mana pun yang diminati sesuai ketentuan sekolah.
        </div>
    </div>

    @if(isset($recommendationResult) && $recommendationResult['status'] === 'READY' && !empty($recommendationResult['ranking']))
        <!-- Recommendations Cards List -->
        <div class="grid grid-cols-1 gap-4">
            @foreach($recommendationResult['ranking'] as $item)
            @php
                $isTop = $item['rank'] === 1;
            @endphp
            <div class="bg-white rounded-xl border {{ $isTop ? 'border-blue-300 ring-2 ring-blue-500/10' : 'border-slate-200' }} shadow-sm p-6 relative">
                @if($isTop)
                <div class="absolute -top-3 left-6 bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-[11px] font-bold px-3 py-0.5 rounded-full uppercase tracking-wider shadow-sm flex items-center gap-1">
                    <svg class="w-3 h-3 text-amber-300" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    Pilihan Paling Sesuai
                </div>
                @endif

                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div class="flex-1">
                        <div class="flex items-center gap-3">
                            <span class="w-8 h-8 rounded-full {{ $isTop ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-700' }} flex items-center justify-center font-bold text-sm">
                                #{{ $item['rank'] }}
                            </span>
                            <div>
                                <h2 class="text-lg font-bold text-slate-900">{{ $item['name'] }}</h2>
                                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">{{ $item['category'] }}</span>
                            </div>
                        </div>

                        <p class="text-xs text-slate-600 mt-2.5">
                            Kecocokan preferensi SAW sebesar <strong>{{ number_format($item['preference_score'], 4) }}</strong> ({{ $item['percentage_score'] }}%).
                        </p>

                        @if(!empty($item['criteria_breakdown']))
                        <div class="mt-3 flex flex-wrap gap-1.5">
                            @foreach($item['criteria_breakdown'] as $code => $bd)
                            <span class="inline-flex items-center gap-1 text-[11px] font-medium bg-slate-100 text-slate-700 px-2.5 py-1 rounded-md">
                                <span class="font-bold text-slate-900">{{ $code }}:</span> v={{ number_format($bd['v'], 3) }}
                            </span>
                            @endforeach
                        </div>
                        @endif
                    </div>

                    <div class="flex flex-row md:flex-col items-center md:items-end justify-between border-t md:border-t-0 md:border-l border-slate-100 pt-4 md:pt-0 md:pl-6 min-w-[200px] gap-3">
                        <div class="text-left md:text-right">
                            <p class="text-[11px] text-slate-500 uppercase font-semibold">Skor Kecocokan</p>
                            <div class="flex items-baseline md:justify-end gap-1">
                                <span class="text-2xl font-extrabold {{ $isTop ? 'text-blue-600' : 'text-slate-900' }}">
                                    {{ round($item['preference_score'] * 100) }}
                                </span>
                                <span class="text-xs font-bold text-slate-400">/ 100</span>
                            </div>
                        </div>

                        <div class="flex items-center gap-2">
                            <a href="{{ route('siswa.rekomendasi.show', $item['extracurricular_id']) }}" class="px-3 py-2 border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-semibold rounded-lg transition-colors">
                                Detail
                            </a>
                            <a href="{{ route('siswa.pendaftaran.index') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-lg shadow-sm transition-colors">
                                Pilih
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <!-- State: Rekomendasi Belum Dapat Dihitung (NOT_READY) -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-8 text-center">
            <div class="w-14 h-14 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
            <h2 class="text-lg font-bold text-slate-900">Rekomendasi Belum Dapat Dihitung</h2>
            <p class="text-sm text-slate-500 max-w-lg mx-auto mt-2 leading-relaxed">
                Hasil rekomendasi matematis SAW saat ini belum dapat diproses secara final karena beberapa prasyarat sistem belum terpenuhi.
            </p>

            @if(isset($recommendationResult) && !empty($recommendationResult['reasons']))
            <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 max-w-lg mx-auto mt-4 text-left">
                <p class="text-xs font-semibold text-amber-900 mb-1">Catatan Kesiapan Sistem:</p>
                <ul class="list-disc list-inside text-xs text-amber-800 space-y-1">
                    @foreach($recommendationResult['reasons'] as $reason)
                        <li>{{ $reason }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="mt-6 flex flex-col sm:flex-row items-center justify-center gap-3">
                <a href="{{ route('siswa.kuesioner.index') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow-sm transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    <span>Lengkapi Kuesioner Sekarang</span>
                </a>
                <a href="{{ route('siswa.ekstrakurikuler.index') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-sm font-semibold rounded-lg transition-colors">
                    <span>Lihat Katalog Ekskul</span>
                </a>
            </div>
        </div>
    @endif

</div>
@endsection
