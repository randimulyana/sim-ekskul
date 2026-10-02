@extends('layouts.admin')
@section('page-title', 'Matriks Keputusan & SAW Engine (Preview & Debug)')

@section('content')
<!-- DATA PROTOTYPE / NEEDS VALIDATION: Phase 5B Implementation Preview -->
<div class="space-y-6">
    <!-- Breadcrumb & Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <nav class="flex items-center gap-1 text-sm text-slate-500 mb-2">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-slate-700">Dashboard</a>
                <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <a href="{{ route('admin.rekomendasi.index') }}" class="hover:text-slate-700">Rekomendasi</a>
                <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <span class="text-slate-700 font-medium">Matriks Keputusan &amp; SAW Engine</span>
            </nav>
            <h1 class="text-2xl font-bold text-slate-900">Matriks Keputusan &amp; Engine SAW (Preview &amp; Debug)</h1>
            <p class="mt-1 text-sm text-slate-500">
                Transparansi audit pipeline Simple Additive Weighting (SAW): Matriks $X$ &rarr; Normalisasi $R$ &rarr; Pembobotan $V$ &rarr; Preferensi &rarr; Ranking.
            </p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.kriteria.mapping') }}" class="inline-flex items-center gap-1.5 px-3 py-2 bg-white text-slate-700 text-sm font-medium rounded-lg border border-slate-200 hover:bg-slate-50">
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Matriks Nilai Ideal Ekskul
            </a>
            <a href="{{ route('admin.rekomendasi.index') }}" class="inline-flex items-center gap-1.5 px-3 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700">
                Daftar Rekomendasi
            </a>
        </div>
    </div>

    <!-- Transparency Metadata Card (Section 22) -->
    <div class="bg-slate-900 text-white rounded-xl p-5 shadow-sm">
        <div class="flex items-center justify-between mb-3 border-b border-slate-800 pb-3">
            <div class="flex items-center gap-2">
                <span class="px-2 py-0.5 rounded text-xs font-bold bg-blue-500 text-white">METODOLOGI SAW</span>
                <span class="text-xs text-slate-400">Parameter Penelitian &amp; Disclosure Metodologis</span>
            </div>
            <div>
                @if(isset($sawResult) && $sawResult['status'] === 'READY')
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                        STATUS: READY FOR SAW
                    </span>
                @else
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-500/20 text-amber-300 border border-amber-500/30">
                        STATUS: NOT READY (Menunggu Validasi)
                    </span>
                @endif
            </div>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 text-xs">
            <div>
                <span class="text-slate-400 block text-[11px]">Metode:</span>
                <span class="font-bold text-slate-200">SAW (Simple Additive Weighting)</span>
            </div>
            <div>
                <span class="text-slate-400 block text-[11px]">Kriteria:</span>
                <span class="font-bold text-slate-200">C1, C2, C3, C4, C5</span>
            </div>
            <div>
                <span class="text-slate-400 block text-[11px]">Bobot Kriteria:</span>
                <span class="font-bold text-slate-200">30%, 25%, 20%, 15%, 10% [PROPOSED]</span>
            </div>
            <div>
                <span class="text-slate-400 block text-[11px]">Tipe Kriteria:</span>
                <span class="font-bold text-emerald-400">Benefit (Semua C1-C5)</span>
            </div>
            <div>
                <span class="text-slate-400 block text-[11px]">Formula Kesesuaian:</span>
                <span class="font-bold text-amber-300">Linear [PROTOTYPE]</span>
            </div>
            <div>
                <span class="text-slate-400 block text-[11px]">Target Nilai Ekskul:</span>
                <span class="font-bold text-amber-300">NEEDS_VALIDATION</span>
            </div>
        </div>
        <p class="text-[11px] text-slate-400 mt-3 pt-2 border-t border-slate-800 leading-relaxed">
            * Bobot kriteria dan formula kesesuaian merupakan usulan penelitian yang memerlukan validasi resmi pihak SMK Negeri 3 Payakumbuh. Sistem tidak menetapkan nilai sepihak.
        </p>
    </div>

    <!-- Student Selector & Period Card -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
        <form method="GET" action="{{ route('admin.rekomendasi.matrix') }}" class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex-1 max-w-md">
                <label for="student_id" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">
                    Pilih Siswa untuk Evaluasi Matriks &amp; SAW:
                </label>
                <select id="student_id" name="student_id" onchange="this.form.submit()" class="block w-full rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                    @forelse($students as $s)
                        <option value="{{ $s->id }}" {{ $selectedStudent && $selectedStudent->id === $s->id ? 'selected' : '' }}>
                            {{ $s->name }} (NIS: {{ $s->nis ?? '-' }} &middot; {{ $s->class_name ?? 'Kelas -' }})
                        </option>
                    @empty
                        <option value="">Belum ada data siswa</option>
                    @endforelse
                </select>
            </div>

            <div class="flex items-center gap-4 text-sm text-slate-600">
                <div class="border-l border-slate-200 pl-4">
                    <span class="text-xs text-slate-400 block">Periode Aktif:</span>
                    <span class="font-semibold text-slate-800">{{ $activePeriod ? $activePeriod->name : 'Tidak Ada' }}</span>
                </div>
                <div class="border-l border-slate-200 pl-4">
                    <span class="text-xs text-slate-400 block">Readiness Guard:</span>
                    @if(isset($sawResult) && $sawResult['status'] === 'READY')
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                            CALCULATION READY
                        </span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-800">
                            BLOCKED BY READINESS GUARD
                        </span>
                    @endif
                </div>
            </div>
        </form>
    </div>

    @if($matrixData)
        <!-- Reasons / Readiness Notice -->
        @if(!empty($matrixData['reasons']) || (isset($sawResult) && !empty($sawResult['reasons'])))
            @php
                $allReasons = array_unique(array_merge($matrixData['reasons'] ?? [], $sawResult['reasons'] ?? []));
            @endphp
            <div class="bg-amber-50 border border-amber-200 rounded-xl p-4">
                <h3 class="text-sm font-semibold text-amber-900 flex items-center gap-2 mb-2">
                    <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    Catatan Kesiapan Eksekusi Algoritma SAW:
                </h3>
                <ul class="list-disc list-inside text-xs text-amber-800 space-y-1">
                    @foreach($allReasons as $reason)
                        <li>{{ $reason }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- 1. Profil Kriteria Siswa (C1 - C5) -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="text-base font-bold text-slate-900">1. Profil Kriteria Siswa (Input Skor Kuesioner)</h2>
                    <p class="text-xs text-slate-500 mt-0.5">
                        Agregasi jawaban kuesioner siswa pada skala 1–5 untuk kriteria aktif C1 s/d C5.
                    </p>
                </div>
                <div class="text-right">
                    <span class="text-xs text-slate-400 block">Siswa:</span>
                    <span class="text-sm font-semibold text-slate-800">{{ $matrixData['student']['name'] }}</span>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                @foreach($matrixData['criteria'] as $code => $c)
                    <div class="p-4 rounded-xl border border-slate-200 bg-slate-50 flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between">
                                <span class="px-2 py-0.5 rounded text-xs font-bold bg-blue-100 text-blue-800">{{ $code }}</span>
                                <span class="text-xs text-slate-500 font-medium">{{ round($c['weight'] * 100) }}% Bobot</span>
                            </div>
                            <h3 class="text-sm font-bold text-slate-800 mt-2">{{ $c['name'] }}</h3>
                            <p class="text-xs text-slate-400 capitalize">Tipe: {{ $c['type'] }}</p>
                        </div>
                        <div class="mt-4 pt-3 border-t border-slate-200">
                            <span class="text-xs text-slate-500 block">Skor Siswa:</span>
                            @if($c['student_score'] !== null)
                                <p class="text-2xl font-black text-blue-700">
                                    {{ number_format($c['student_score'], 2) }}
                                    <span class="text-xs font-normal text-slate-500">/ 5.00</span>
                                </p>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-700 mt-1">
                                    Belum Diisi
                                </span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- 2. Matriks Keputusan X (Preview x_ij) -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                <div>
                    <h2 class="text-base font-bold text-slate-900">2. Matriks Keputusan $X = [x_{ij}]$</h2>
                    <p class="text-xs text-slate-500 mt-0.5">
                        Nilai kesesuaian $x_{ij} \in [0.00, 1.00]$ dari formula kesesuaian linear prototipe: $1 - \frac{|skor\_siswa - target|}{4}$.
                    </p>
                </div>
                <div class="text-xs text-slate-500 font-mono">
                    Total Alternatif: {{ count($matrixData['alternatives']) }}
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider w-12">No</th>
                            <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider min-w-[180px]">Alternatif</th>
                            @foreach($matrixData['criteria'] as $code => $c)
                                <th class="text-center px-3 py-3 text-xs font-semibold text-slate-700 uppercase tracking-wider">
                                    {{ $code }} ({{ round($c['weight'] * 100) }}%)
                                </th>
                            @endforeach
                            <th class="text-center px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($matrixData['alternatives'] as $idx => $alt)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-4 py-3 text-xs text-slate-400 text-center">{{ $idx + 1 }}</td>
                                <td class="px-4 py-3 font-semibold text-slate-900">
                                    {{ $alt['name'] }}
                                    <span class="block text-[10px] text-slate-400 font-normal">{{ $alt['category'] }}</span>
                                </td>
                                @foreach($matrixData['criteria'] as $code => $c)
                                    @php
                                        $cell = $alt['criteria'][$code] ?? null;
                                    @endphp
                                    <td class="px-3 py-3 text-center">
                                        @if($cell && $cell['status'] === 'READY' && $cell['compatibility'] !== null)
                                            <span class="font-mono font-bold text-slate-900">{{ number_format($cell['compatibility'], 2) }}</span>
                                        @elseif($cell && $cell['status'] === 'NEEDS_VALIDATION')
                                            <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-medium bg-amber-50 text-amber-700 border border-amber-200">
                                                NEEDS VALIDATION
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-medium bg-slate-100 text-slate-500">
                                                NOT READY
                                            </span>
                                        @endif
                                    </td>
                                @endforeach
                                <td class="px-4 py-3 text-center">
                                    @if($alt['status'] === 'READY')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-emerald-100 text-emerald-800">Ready</span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-amber-100 text-amber-800">Needs Validation</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @if(isset($sawResult) && $sawResult['status'] === 'READY')
            <!-- 3. Matriks Ternormalisasi R (Section 21) -->
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-slate-100">
                    <h2 class="text-base font-bold text-slate-900">3. Matriks Ternormalisasi $R = [r_{ij}]$</h2>
                    <p class="text-xs text-slate-500 mt-0.5">
                        Formula Benefit: $r_{ij} = \frac{x_{ij}}{\max_i(x_{ij})}$. Nilai ternormalisasi berada pada skala 0.00 – 1.00.
                    </p>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-slate-50 border-b border-slate-200">
                            <tr>
                                <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider w-12">No</th>
                                <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider min-w-[180px]">Alternatif</th>
                                @foreach($matrixData['criteria'] as $code => $c)
                                    <th class="text-center px-3 py-3 text-xs font-semibold text-slate-700 uppercase tracking-wider">
                                        r_{{ $code }}
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($matrixData['alternatives'] as $idx => $alt)
                                @php
                                    $altId = $alt['extracurricular_id'];
                                    $rowR = $sawResult['matrix_r'][$altId] ?? [];
                                @endphp
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-4 py-3 text-xs text-slate-400 text-center">{{ $idx + 1 }}</td>
                                    <td class="px-4 py-3 font-semibold text-slate-900">{{ $alt['name'] }}</td>
                                    @foreach($matrixData['criteria'] as $code => $c)
                                        <td class="px-3 py-3 text-center font-mono font-medium text-slate-800">
                                            {{ isset($rowR[$code]) ? number_format($rowR[$code], 4) : '-' }}
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- 4. Matriks Terbobot V & Skor Preferensi (Section 21) -->
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-slate-100">
                    <h2 class="text-base font-bold text-slate-900">4. Matriks Terbobot $V = [v_{ij}]$ dan Nilai Preferensi $V_i$</h2>
                    <p class="text-xs text-slate-500 mt-0.5">
                        Formula Terbobot: $v_{ij} = r_{ij} \times w_j$. Skor Preferensi Akhir: $V_i = \sum_{j=1}^m v_{ij}$.
                    </p>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-slate-50 border-b border-slate-200">
                            <tr>
                                <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider w-12">No</th>
                                <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider min-w-[180px]">Alternatif</th>
                                @foreach($matrixData['criteria'] as $code => $c)
                                    <th class="text-center px-3 py-3 text-xs font-semibold text-slate-700 uppercase tracking-wider">
                                        v_{{ $code }} ({{ round($c['weight'] * 100) }}%)
                                    </th>
                                @endforeach
                                <th class="text-center px-4 py-3 text-xs font-bold text-blue-700 uppercase tracking-wider bg-blue-50/50">
                                    Skor Preferensi (V_i)
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($matrixData['alternatives'] as $idx => $alt)
                                @php
                                    $altId = $alt['extracurricular_id'];
                                    $rowV = $sawResult['matrix_v'][$altId] ?? [];
                                    $pref = array_sum($rowV);
                                @endphp
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-4 py-3 text-xs text-slate-400 text-center">{{ $idx + 1 }}</td>
                                    <td class="px-4 py-3 font-semibold text-slate-900">{{ $alt['name'] }}</td>
                                    @foreach($matrixData['criteria'] as $code => $c)
                                        <td class="px-3 py-3 text-center font-mono text-xs text-slate-700">
                                            {{ isset($rowV[$code]) ? number_format($rowV[$code], 4) : '-' }}
                                        </td>
                                    @endforeach
                                    <td class="px-4 py-3 text-center font-mono font-bold text-blue-700 bg-blue-50/30">
                                        {{ number_format($pref, 4) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- 5. Tabel Hasil Perangkingan SAW (Section 21) -->
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                    <div>
                        <h2 class="text-base font-bold text-slate-900">5. Hasil Pemeringkatan SAW (Final Ranking)</h2>
                        <p class="text-xs text-slate-500 mt-0.5">
                            Alternatif diurutkan menurun (*descending*) berdasarkan Skor Preferensi $V_i$. Tie-break deterministik menggunakan ID alternatif.
                        </p>
                    </div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                        Hasil Dihitung Berhasil
                    </span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-slate-50 border-b border-slate-200">
                            <tr>
                                <th class="text-center px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider w-16">Peringkat</th>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Ekstrakurikuler</th>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Kategori</th>
                                <th class="text-center px-6 py-3 text-xs font-bold text-blue-700 uppercase tracking-wider">Skor Preferensi (V_i)</th>
                                <th class="text-center px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Persentase</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($sawResult['ranking'] as $item)
                                <tr class="hover:bg-slate-50 transition-colors {{ $item['rank'] === 1 ? 'bg-blue-50/20' : '' }}">
                                    <td class="px-4 py-3 text-center">
                                        <span class="inline-flex items-center justify-center w-7 h-7 rounded-full text-xs font-bold {{ $item['rank'] === 1 ? 'bg-blue-600 text-white' : ($item['rank'] <= 3 ? 'bg-blue-100 text-blue-800' : 'bg-slate-100 text-slate-700') }}">
                                            #{{ $item['rank'] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-3 font-bold text-slate-900">
                                        {{ $item['name'] }}
                                    </td>
                                    <td class="px-6 py-3 text-slate-600 text-xs">
                                        {{ $item['category'] }}
                                    </td>
                                    <td class="px-6 py-3 text-center font-mono font-bold text-blue-700 text-base">
                                        {{ number_format($item['preference_score'], 4) }}
                                    </td>
                                    <td class="px-6 py-3 text-center font-semibold text-slate-700">
                                        {{ $item['percentage_score'] }}%
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <!-- Notice: Perangkingan Tidak Dijalankan (Readiness Guard Active) -->
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 text-center">
                <div class="w-12 h-12 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <h3 class="text-base font-bold text-slate-900">Kalkulasi Perangkingan SAW Ditahan (*Readiness Guard*)</h3>
                <p class="text-xs text-slate-500 max-w-xl mx-auto mt-1 leading-relaxed">
                    Sesuai prinsip integritas penelitian, tahapan <strong>Normalisasi $R$</strong>, <strong>Matriks Terbobot $V$</strong>, dan <strong>Perangkingan Akhir</strong> sengaja tidak dijalankan apabila matriks target ekstrakurikuler masih berstatus <span class="font-semibold text-amber-700">NEEDS VALIDATION</span>. Sistem tidak mengarang nilai target fiktif.
                </p>
                <div class="mt-4">
                    <a href="{{ route('admin.kriteria.mapping') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-lg transition-colors">
                        Lihat Status Matriks Nilai Ideal &rarr;
                    </a>
                </div>
            </div>
        @endif
    @endif
</div>
@endsection
