@extends('layouts.student')

@section('title', 'Hasil Rekomendasi Ekstrakurikuler')

@section('content')
{{-- DATA DEMO: hasil skor kecocokan ini adalah data simulasi prototype UI --}}

<div class="max-w-4xl mx-auto space-y-6">

    <!-- Header Section -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 sm:p-8">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold {{ ($progress['is_complete'] ?? false) ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }} mb-2">
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    {{ ($progress['is_complete'] ?? false) ? 'Kuesioner Selesai (100%)' : 'Progress: ' . ($progress['percentage'] ?? 0) . '%' }}
                </span>
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-900">Hasil Rekomendasi Ekstrakurikuler</h1>
                <p class="text-sm text-slate-500 mt-1">Jawaban kuesioner periode {{ $activePeriod?->name ?? 'aktif' }} telah tersimpan dengan aman di database.</p>
            </div>
            <a href="{{ route('siswa.kuesioner.index') }}" class="self-start sm:self-auto inline-flex items-center gap-1.5 px-4 py-2 border border-slate-200 text-slate-700 hover:bg-slate-50 text-xs font-semibold rounded-lg transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                Perbarui Jawaban
            </a>
        </div>

        <!-- Information & Phase 5 Notice Banner -->
        <div class="mt-6 space-y-3">
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 flex items-start gap-3 text-blue-900 text-xs leading-relaxed">
                <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <div>
                    <span class="font-bold">Informasi:</span> Angka di bawah ini merupakan <strong>Skor Kecocokan</strong> simulasi berdasarkan preferensi jawaban kuesionermu, <em>bukan</em> penilaian mutlak bakat atau kemampuan psikometrik. Rekomendasi ini berfungsi sebagai alat bantu pertimbangan bagi siswa dalam mengambil keputusan.
                </div>
            </div>

            <div class="bg-amber-50 border border-amber-200 rounded-xl p-3 flex items-center gap-2 text-amber-800 text-xs">
                <svg class="w-4 h-4 text-amber-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                <span><strong>Catatan Pengembangan:</strong> Algoritma perhitungan matematis SAW (Simple Additive Weighting) akan aktif pada Phase 5 setelah seluruh bobot kriteria divalidasi.</span>
            </div>
        </div>
    </div>

    <!-- Recommendations Cards List -->
    <div class="space-y-4">
        @php
        // DATA DEMO: Rekomendasi sesuai instruksi prompt
        $rekomendasi = [
            [
                'id' => 1,
                'rank' => 1,
                'nama' => 'PASKIBRAKA',
                'kategori' => 'Organisasi',
                'skor' => 92,
                'is_top' => true,
                'alasan' => 'Jawabanmu menunjukkan kecocokan sangat tinggi pada kedisiplinan baris-berbaris, ketahanan fisik di luar ruangan, serta preferensi bekerja sama dalam regu berstruktur jelas.',
                'faktor' => ['Ketahanan fisik tinggi', 'Gaya belajar kinestetik', 'Minat kepemimpinan & disiplin'],
                'peserta' => 48,
            ],
            [
                'id' => 2,
                'rank' => 2,
                'nama' => 'PRAMUKA',
                'kategori' => 'Organisasi',
                'skor' => 87,
                'is_top' => false,
                'alasan' => 'Kecocokan tinggi pada aktivitas alam terbuka, kemandirian pemuda, serta kesiapan bekerja dalam tim kepanduan.',
                'faktor' => ['Aktivitas outdoor', 'Kerja sama regu', 'Kemandirian sosial'],
                'peserta' => 62,
            ],
            [
                'id' => 3,
                'rank' => 3,
                'nama' => 'MARCHING BAND',
                'kategori' => 'Seni & Budaya',
                'skor' => 81,
                'is_top' => false,
                'alasan' => 'Memiliki ketertarikan pada unjuk performa di depan publik ramai yang dipadukan dengan keselarasan gerak fisik tim.',
                'faktor' => ['Kepercayaan diri tampil', 'Koordinasi gerak', 'Harmonisasi tim besar'],
                'peserta' => 38,
            ],
        ];
        @endphp

        @foreach($rekomendasi as $item)
        <div class="bg-white rounded-xl border {{ $item['is_top'] ? 'border-blue-300 ring-2 ring-blue-500/10' : 'border-slate-200' }} shadow-sm p-6 sm:p-7 relative transition-all hover:shadow-md">
            @if($item['is_top'])
            <div class="absolute -top-3 left-6 bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-[11px] font-bold px-3 py-0.5 rounded-full uppercase tracking-wider shadow-sm flex items-center gap-1">
                <svg class="w-3 h-3 text-amber-300" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                Pilihan Paling Sesuai
            </div>
            @endif

            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                <!-- Info Left -->
                <div class="flex-1">
                    <div class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-full {{ $item['is_top'] ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-700' }} flex items-center justify-center font-bold text-sm">
                            #{{ $item['rank'] }}
                        </span>
                        <div>
                            <h2 class="text-xl font-bold text-slate-900">{{ $item['nama'] }}</h2>
                            <span class="inline-block text-xs font-semibold text-slate-500 uppercase tracking-wider">{{ $item['kategori'] }}</span>
                        </div>
                    </div>

                    <p class="text-xs text-slate-600 mt-3 leading-relaxed">{{ $item['alasan'] }}</p>

                    <!-- Supporting factors -->
                    <div class="mt-3 flex flex-wrap gap-1.5">
                        @foreach($item['faktor'] as $f)
                        <span class="inline-flex items-center gap-1 text-[11px] font-medium bg-slate-100 text-slate-700 px-2.5 py-1 rounded-md">
                            <svg class="w-3 h-3 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            {{ $f }}
                        </span>
                        @endforeach
                    </div>
                </div>

                <!-- Score & Action Right -->
                <div class="flex flex-row md:flex-col items-center md:items-end justify-between md:justify-center border-t md:border-t-0 md:border-l border-slate-100 pt-4 md:pt-0 md:pl-6 min-w-[200px] gap-3">
                    <div class="text-left md:text-right">
                        <p class="text-[11px] text-slate-500 uppercase font-semibold">Skor Kecocokan</p>
                        <div class="flex items-baseline md:justify-end gap-1">
                            <span class="text-3xl font-extrabold {{ $item['is_top'] ? 'text-blue-600' : 'text-slate-900' }}">{{ $item['skor'] }}</span>
                            <span class="text-xs font-bold text-slate-400">/ 100</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        <a href="/siswa/rekomendasi/{{ $item['id'] }}" class="px-3.5 py-2 border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-semibold rounded-lg transition-colors">
                            Lihat Detail
                        </a>
                        <a href="/siswa/pendaftaran" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-lg shadow-sm transition-colors">
                            Pilih Ekskul
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Bottom Actions -->
    <div class="bg-white rounded-xl border border-slate-200 p-6 flex flex-col sm:flex-row items-center justify-between gap-4">
        <div>
            <h3 class="text-sm font-bold text-slate-900">Sudah yakin dengan pilihanmu?</h3>
            <p class="text-xs text-slate-500">Lanjutkan pendaftaran daring sekarang selagi periode pendaftaran aktif masih dibuka.</p>
        </div>
        <a href="/siswa/pendaftaran" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-lg shadow-sm transition-colors">
            <span>Lanjut ke Formulir Pendaftaran</span>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
        </a>
    </div>

</div>
@endsection
