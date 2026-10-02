@extends('layouts.admin')
@section('page-title', 'Matriks Keputusan SAW (Preview & Debug)')

@section('content')
<!-- DATA PROTOTYPE / NEEDS VALIDATION: Phase 5A Implementation Preview -->
<div class="space-y-6">
    <!-- Breadcrumb & Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <nav class="flex items-center gap-1 text-sm text-slate-500 mb-2">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-slate-700">Dashboard</a>
                <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <a href="{{ route('admin.rekomendasi.index') }}" class="hover:text-slate-700">Rekomendasi</a>
                <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <span class="text-slate-700 font-medium">Matriks Keputusan (Phase 5A)</span>
            </nav>
            <h1 class="text-2xl font-bold text-slate-900">Matriks Keputusan SAW (Preview &amp; Debug)</h1>
            <p class="mt-1 text-sm text-slate-500">
                Pembentukan nilai kesesuaian siswa terhadap profil ekstrakurikuler sebagai input Matriks Keputusan X untuk SAW.
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

    <!-- Alert Status Metodologi Penelitian -->
    <div class="bg-amber-50 border border-amber-200 rounded-xl p-4">
        <div class="flex items-start gap-3">
            <svg class="w-5 h-5 text-amber-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            <div class="text-sm">
                <p class="font-semibold text-amber-900">INFORMASI METODOLOGIS [PROTOTYPE / NEEDS VALIDATION]</p>
                <p class="mt-1 text-amber-800 leading-relaxed">
                    Halaman ini merupakan implementasi <strong>Phase 5A (Pembentukan Matriks Keputusan)</strong>. Formula kesesuaian dihitung berdasarkan selisih profil kriteria siswa terhadap target ekstrakurikuler:
                    <code class="px-1.5 py-0.5 rounded bg-amber-100 font-mono text-xs text-amber-900">compatibility = 1 - (|skor_siswa - target| / 4)</code>.
                    Tahapan <strong>Normalisasi SAW</strong>, <strong>Perkalian Bobot (Weighted Sum)</strong>, dan <strong>Perangkingan</strong> sengaja <strong>BELUM DIJALANKAN</strong> (dialokasikan untuk Phase 5B).
                </p>
            </div>
        </div>
    </div>

    <!-- Student Selector & Period Card -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
        <form method="GET" action="{{ route('admin.rekomendasi.matrix') }}" class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex-1 max-w-md">
                <label for="student_id" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">
                    Pilih Siswa untuk Evaluasi Matriks Keputusan:
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
                    <span class="text-xs text-slate-400 block">Status Matriks:</span>
                    @if($matrixData && $matrixData['status'] === 'READY_FOR_SAW')
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                            READY FOR SAW
                        </span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-800">
                            NOT READY (Menunggu Validasi)
                        </span>
                    @endif
                </div>
            </div>
        </form>
    </div>

    @if($matrixData)
        <!-- Reasons / Readiness Notice -->
        @if(!empty($matrixData['reasons']))
            <div class="bg-slate-50 border border-slate-200 rounded-xl p-4">
                <h3 class="text-sm font-semibold text-slate-900 flex items-center gap-2 mb-2">
                    <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Catatan Kesiapan Sistem Menuju SAW (Readiness Audit):
                </h3>
                <ul class="list-disc list-inside text-xs text-slate-600 space-y-1">
                    @foreach($matrixData['reasons'] as $reason)
                        <li>{{ $reason }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- 1. Profil Kriteria Siswa (C1 - C5) -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="text-base font-bold text-slate-900">1. Profil Kriteria Siswa (Agregasi Jawaban Kuesioner)</h2>
                    <p class="text-xs text-slate-500 mt-0.5">
                        Nilai profil diperoleh dari rata-rata opsi jawaban terpetakan (skala 1–5). Pertanyaan textarea &amp; checkbox dikecualikan dari penilaian sembarangan.
                    </p>
                </div>
                <div class="text-right">
                    <span class="text-xs text-slate-400 block">Siswa Dievaluasi:</span>
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

        <!-- 2. Matriks Keputusan X (Preview & Debugging) -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                <div>
                    <h2 class="text-base font-bold text-slate-900">2. Preview Matriks Keputusan X (Ekstrakurikuler &times; Kriteria)</h2>
                    <p class="text-xs text-slate-500 mt-0.5">
                        Setiap sel menampilkan nilai kesesuaian <code class="font-mono text-xs">x_ij</code> (0.00 – 1.00). Sel berstatus <span class="font-semibold text-amber-700">NEEDS VALIDATION</span> jika target nilai ideal ekstrakurikuler belum divalidasi resmi.
                    </p>
                </div>
                <div class="text-xs text-slate-500">
                    Total Alternatif Aktif: <span class="font-bold text-slate-800">{{ count($matrixData['alternatives']) }}</span>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider w-12">No</th>
                            <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider min-w-[200px]">Alternatif (Ekstrakurikuler)</th>
                            @foreach($matrixData['criteria'] as $code => $c)
                                <th class="text-center px-3 py-3 text-xs font-semibold text-slate-700 uppercase tracking-wider">
                                    <div>{{ $code }} - {{ $c['name'] }}</div>
                                    <div class="text-[10px] text-slate-400 font-normal">W: {{ round($c['weight'] * 100) }}% | Skor Siswa: {{ $c['student_score'] !== null ? number_format($c['student_score'], 2) : '-' }}</div>
                                </th>
                            @endforeach
                            <th class="text-center px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Status Baris</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($matrixData['alternatives'] as $idx => $alt)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-4 py-3 text-xs text-slate-400 text-center">{{ $idx + 1 }}</td>
                                <td class="px-4 py-3">
                                    <div class="font-semibold text-slate-900">{{ $alt['name'] }}</div>
                                    <span class="inline-block mt-0.5 px-2 py-0.5 rounded text-[10px] font-medium bg-slate-100 text-slate-600">
                                        {{ $alt['category'] }}
                                    </span>
                                </td>
                                @foreach($matrixData['criteria'] as $code => $c)
                                    @php
                                        $cell = $alt['criteria'][$code] ?? null;
                                    @endphp
                                    <td class="px-3 py-3 text-center">
                                        @if($cell && $cell['status'] === 'READY' && $cell['compatibility'] !== null)
                                            <div class="font-mono font-bold text-slate-900 text-sm">
                                                {{ number_format($cell['compatibility'], 2) }}
                                            </div>
                                            <div class="text-[10px] text-slate-400">
                                                Target: {{ number_format($cell['target_score'], 2) }}
                                            </div>
                                        @elseif($cell && $cell['status'] === 'NEEDS_VALIDATION')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-amber-50 text-amber-700 border border-amber-200">
                                                NEEDS VALIDATION
                                            </span>
                                            <div class="text-[10px] text-slate-400 mt-0.5">
                                                Target: {{ $cell['target_score'] !== null ? number_format($cell['target_score'], 1) : 'Belum Ada' }}
                                            </div>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-slate-100 text-slate-500">
                                                NOT READY
                                            </span>
                                        @endif
                                    </td>
                                @endforeach
                                <td class="px-4 py-3 text-center">
                                    @if($alt['status'] === 'READY')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                                            Ready
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                                            Needs Validation
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="p-4 bg-slate-50 border-t border-slate-100 text-xs text-slate-500 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                <div>
                    <strong>Keterangan Matriks X:</strong> Baris tidak diurutkan berdasarkan skor/ranking melainkan nama ekstrakurikuler. Nilai tidak dikarang bebas.
                </div>
                <div class="font-mono text-slate-600">
                    Sel Lengkap: {{ $matrixData['completeness']['ready_cells_count'] }} / {{ $matrixData['completeness']['expected_cells'] }}
                </div>
            </div>
        </div>

        <!-- 3. Status Pipeline Rekomendasi SAW (Audit Metodologi) -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
            <h3 class="text-sm font-bold text-slate-900 mb-4 uppercase tracking-wider text-xs">
                Status Pipeline Sistem Pendukung Keputusan (Simple Additive Weighting)
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="p-4 rounded-xl border border-blue-200 bg-blue-50">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-blue-800">TAHAP 5A</span>
                        <span class="px-2 py-0.5 rounded text-[10px] font-semibold bg-blue-200 text-blue-900">Aktif</span>
                    </div>
                    <h4 class="font-semibold text-slate-900 text-sm mt-2">Matriks Keputusan X</h4>
                    <p class="text-xs text-slate-600 mt-1">Pembentukan nilai kesesuaian siswa vs alternatif ekstrakurikuler.</p>
                </div>

                <div class="p-4 rounded-xl border border-slate-200 bg-slate-50">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-slate-400">TAHAP 5B</span>
                        <span class="px-2 py-0.5 rounded text-[10px] font-semibold bg-slate-200 text-slate-600">Not Implemented</span>
                    </div>
                    <h4 class="font-semibold text-slate-700 text-sm mt-2">Normalisasi SAW</h4>
                    <p class="text-xs text-slate-500 mt-1">Perhitungan matriks ternormalisasi R (benefit/cost).</p>
                </div>

                <div class="p-4 rounded-xl border border-slate-200 bg-slate-50">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-slate-400">TAHAP 5B</span>
                        <span class="px-2 py-0.5 rounded text-[10px] font-semibold bg-slate-200 text-slate-600">Not Implemented</span>
                    </div>
                    <h4 class="font-semibold text-slate-700 text-sm mt-2">Pembobotan V</h4>
                    <p class="text-xs text-slate-500 mt-1">Perkalian nilai ternormalisasi dengan bobot kriteria W.</p>
                </div>

                <div class="p-4 rounded-xl border border-slate-200 bg-slate-50">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-slate-400">TAHAP 5B</span>
                        <span class="px-2 py-0.5 rounded text-[10px] font-semibold bg-slate-200 text-slate-600">Not Implemented</span>
                    </div>
                    <h4 class="font-semibold text-slate-700 text-sm mt-2">Perangkingan Akhir</h4>
                    <p class="text-xs text-slate-500 mt-1">Penyusunan ranking rekomendasi alternatif teratas.</p>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
