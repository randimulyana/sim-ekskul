@extends('layouts.student')

@section('title', 'Rekomendasi Ekstrakurikuler')

@section('content')
{{-- DATA DEMO: data rekomendasi hasil kuesioner --}}

<div class="max-w-4xl mx-auto space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Rekomendasi Untukmu</h1>
            <p class="text-sm text-slate-500 mt-1">Dihitung berdasarkan kuesioner yang kamu selesaikan pada 1 Oktober 2026</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="/siswa/kuesioner" class="inline-flex items-center gap-1.5 px-3.5 py-2 border border-slate-200 text-slate-700 hover:bg-slate-50 text-xs font-semibold rounded-lg transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                Isi Ulang Kuesioner
            </a>
            <a href="/siswa/pendaftaran" class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-lg shadow-sm transition-colors">
                Formulir Pendaftaran &rarr;
            </a>
        </div>
    </div>

    <!-- Skor Kecocokan Notice -->
    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 flex items-start gap-3 text-blue-900 text-xs leading-relaxed">
        <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <div>
            <strong>Catatan Penggunaan Rekomendasi:</strong> Skor di bawah adalah <strong>Skor Kecocokan</strong> preferensi kuesioner, bukan tolak ukur bakat atau potensi psikologis mutlak. Siswa tetap berhak memilih ekstrakurikuler mana pun yang diminati sesuai ketentuan sekolah.
        </div>
    </div>

    <!-- Recommendations Grid / List -->
    @php
    $rekomendasi = [
        [
            'id' => 1,
            'rank' => 1,
            'nama' => 'PASKIBRAKA',
            'kategori' => 'Organisasi',
            'skor' => 92,
            'is_top' => true,
            'ringkasan' => 'Tingkat kecocokan 92/100 dengan orientasi kedisiplinan baris-berbaris dan ketahanan fisik.',
            'faktor' => ['Ketahanan fisik prima', 'Pola belajar kinestetik', 'Kerja sama regu berstruktur'],
            'deskripsi' => 'Pasukan Pengibar Bendera Pusaka melatih kepemimpinan, disiplin ketat, dan nasionalisme siswa di sekolah.',
            'peserta' => 48,
        ],
        [
            'id' => 2,
            'rank' => 2,
            'nama' => 'PRAMUKA',
            'kategori' => 'Organisasi',
            'skor' => 87,
            'is_top' => false,
            'ringkasan' => 'Tingkat kecocokan 87/100 untuk kegiatan penjelajahan alam, kemandirian sosial, dan keterampilan survival.',
            'faktor' => ['Eksplorasi luar ruang', 'Jiwa gotong royong', 'Kemampuan survival'],
            'deskripsi' => 'Membangun generasi muda mandiri, tanggap sosial, dan terampil dalam kepanduan.',
            'peserta' => 62,
        ],
        [
            'id' => 3,
            'rank' => 3,
            'nama' => 'MARCHING BAND',
            'kategori' => 'Seni & Budaya',
            'skor' => 81,
            'is_top' => false,
            'ringkasan' => 'Tingkat kecocokan 81/100 pada kolaborasi pertunjukan musik ensemble dan keharmonisan gerak.',
            'faktor' => ['Percaya diri tampil umum', 'Sensitivitas ritme musik', 'Kekompakan koreografi'],
            'deskripsi' => 'Korps musik dinamis yang menggabungkan instrumen tiup, perkusi, dan formasi visual display.',
            'peserta' => 38,
        ],
    ];
    @endphp

    <div class="grid grid-cols-1 gap-4">
        @foreach($rekomendasi as $item)
        <div class="bg-white rounded-xl border {{ $item['is_top'] ? 'border-blue-300 ring-2 ring-blue-500/10' : 'border-slate-200' }} shadow-sm p-6 relative">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="flex-1">
                    <div class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-full {{ $item['is_top'] ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-700' }} flex items-center justify-center font-bold text-sm">
                            #{{ $item['rank'] }}
                        </span>
                        <div>
                            <h2 class="text-lg font-bold text-slate-900">{{ $item['nama'] }}</h2>
                            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">{{ $item['kategori'] }}</span>
                        </div>
                    </div>

                    <p class="text-xs text-slate-600 mt-2.5">{{ $item['ringkasan'] }}</p>

                    <div class="mt-3 flex flex-wrap gap-1.5">
                        @foreach($item['faktor'] as $f)
                        <span class="inline-flex items-center gap-1 text-[11px] font-medium bg-slate-100 text-slate-700 px-2.5 py-1 rounded-md">
                            <svg class="w-3 h-3 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            {{ $f }}
                        </span>
                        @endforeach
                    </div>
                </div>

                <div class="flex flex-row md:flex-col items-center md:items-end justify-between border-t md:border-t-0 md:border-l border-slate-100 pt-4 md:pt-0 md:pl-6 min-w-[200px] gap-3">
                    <div class="text-left md:text-right">
                        <p class="text-[11px] text-slate-500 uppercase font-semibold">Skor Kecocokan</p>
                        <div class="flex items-baseline md:justify-end gap-1">
                            <span class="text-2xl font-extrabold {{ $item['is_top'] ? 'text-blue-600' : 'text-slate-900' }}">{{ $item['skor'] }}</span>
                            <span class="text-xs font-bold text-slate-400">/ 100</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        <a href="/siswa/rekomendasi/{{ $item['id'] }}" class="px-3 py-2 border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-semibold rounded-lg transition-colors">
                            Detail
                        </a>
                        <a href="/siswa/pendaftaran" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-lg shadow-sm transition-colors">
                            Pilih
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

</div>
@endsection
