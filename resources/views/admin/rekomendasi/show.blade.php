@extends('layouts.admin')

@section('page-title', 'Detail Rekomendasi Siswa')

@section('content')
<!-- DATA DEMO: detail hasil rekomendasi siswa admin prototype UI -->
<div class="max-w-4xl space-y-6">

    <!-- Header & Breadcrumb -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <nav class="flex items-center gap-1 text-xs text-slate-500 mb-2">
                <a href="/admin/dashboard" class="hover:text-slate-700">Dashboard</a>
                <svg class="w-3.5 h-3.5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <a href="/admin/rekomendasi" class="hover:text-slate-700">Rekomendasi</a>
                <svg class="w-3.5 h-3.5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <span class="text-slate-800 font-semibold">Andi Saputra</span>
            </nav>
            <h1 class="text-2xl font-bold text-slate-900">Hasil Rekomendasi: Andi Saputra</h1>
            <p class="text-xs text-slate-500 mt-1">NIS: 2026001 &middot; Kelas: KULINER 1 &middot; Waktu Analisis: 1 Okt 2026</p>
        </div>

        <a href="/admin/rekomendasi" class="self-start sm:self-auto px-4 py-2 border border-slate-200 text-slate-700 hover:bg-slate-50 text-xs font-semibold rounded-lg transition-colors">
            &larr; Kembali ke Daftar
        </a>
    </div>

    <!-- Student Info Summary Card -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
        <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-3">Ringkasan Data Siswa</h3>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-xs">
            <div>
                <span class="text-slate-400 block font-semibold">Nama Siswa</span>
                <span class="text-slate-900 font-bold block mt-0.5">Andi Saputra</span>
            </div>
            <div>
                <span class="text-slate-400 block font-semibold">NIS</span>
                <span class="text-slate-900 font-mono font-bold block mt-0.5">2026001</span>
            </div>
            <div>
                <span class="text-slate-400 block font-semibold">Kelas</span>
                <span class="text-slate-900 font-bold block mt-0.5">KULINER 1</span>
            </div>
            <div>
                <span class="text-slate-400 block font-semibold">WhatsApp Aktif</span>
                <span class="text-slate-900 font-mono font-bold block mt-0.5">08123456789</span>
            </div>
        </div>
    </div>

    <!-- Ranking Rekomendasi Cards -->
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Hasil Pemeringkatan (Ranking 1 - 3)</h3>
            <span class="text-xs text-slate-400">Model: Rule-based / Multi-Criteria Prototype</span>
        </div>

        @php
        // DATA DEMO: data ranking rekomendasi admin
        $ranks = [
            [
                'rank' => 1,
                'nama' => 'PASKIBRAKA',
                'kategori' => 'Organisasi',
                'skor' => 92,
                'alasan' => 'Skor ketahanan fisik sangat tinggi (5/5), preferensi belajar kinestetik, dan kesiapan bekerja dalam struktur regu komando formal.',
                'faktor' => ['Fisik & Stamina (Tinggi)', 'Gaya Belajar (Kinestetik)', 'Kedisiplinan (Sangat Tinggi)'],
                'top' => true,
            ],
            [
                'rank' => 2,
                'nama' => 'PRAMUKA',
                'kategori' => 'Organisasi',
                'skor' => 87,
                'alasan' => 'Minat kuat pada kegiatan penjelajahan alam bebas, kemandirian sosial, dan keterampilan survival kepanduan.',
                'faktor' => ['Aktivitas Luar Ruang', 'Kemandirian Regu', 'Jiwa Sosial'],
                'top' => false,
            ],
            [
                'rank' => 3,
                'nama' => 'MARCHING BAND',
                'kategori' => 'Seni & Budaya',
                'skor' => 81,
                'alasan' => 'Kepercayaan diri tampil di muka umum dipadukan dengan keselarasan gerak fisik ensemble musik.',
                'faktor' => ['Tampil di Muka Umum', 'Keharmonisan Tim', 'Sensitivitas Musik'],
                'top' => false,
            ],
        ];
        @endphp

        @foreach($ranks as $r)
        <div class="bg-white rounded-xl border {{ $r['top'] ? 'border-blue-300 ring-2 ring-blue-500/10' : 'border-slate-200' }} shadow-sm p-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-start gap-3">
                    <span class="w-8 h-8 rounded-full {{ $r['top'] ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-700' }} flex items-center justify-center font-bold text-sm flex-shrink-0 mt-0.5">
                        #{{ $r['rank'] }}
                    </span>
                    <div>
                        <div class="flex items-center gap-2">
                            <h4 class="text-base font-bold text-slate-900">{{ $r['nama'] }}</h4>
                            <span class="px-2 py-0.5 rounded text-[10px] font-semibold bg-slate-100 text-slate-600 uppercase">{{ $r['kategori'] }}</span>
                        </div>
                        <p class="text-xs text-slate-600 mt-1 leading-relaxed">{{ $r['alasan'] }}</p>

                        <div class="flex flex-wrap gap-1.5 mt-2.5">
                            @foreach($r['faktor'] as $f)
                            <span class="text-[10px] font-medium bg-slate-100 text-slate-700 px-2 py-0.5 rounded">
                                ✓ {{ $f }}
                            </span>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="sm:text-right flex-shrink-0 pt-3 sm:pt-0 border-t sm:border-t-0 border-slate-100">
                    <span class="text-[10px] font-semibold text-slate-400 uppercase block">Skor Kecocokan</span>
                    <span class="text-2xl font-extrabold text-blue-600 font-mono">{{ $r['skor'] }} <span class="text-xs font-normal text-slate-400">/ 100</span></span>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Ringkasan Jawaban Kuesioner Siswa -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
        <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-3">Ringkasan Jawaban Kuesioner Siswa</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
            <div class="p-3 bg-slate-50 rounded-lg border border-slate-200/70">
                <span class="text-slate-400 block font-medium">Gaya Belajar Utama</span>
                <span class="text-slate-800 font-bold mt-0.5 block">Kinestetik (Praktik Langsung)</span>
            </div>
            <div class="p-3 bg-slate-50 rounded-lg border border-slate-200/70">
                <span class="text-slate-400 block font-medium">Ketahanan Fisik Luar Ruangan</span>
                <span class="text-slate-800 font-bold mt-0.5 block">Sangat Sering (Skala: 4/5)</span>
            </div>
            <div class="p-3 bg-slate-50 rounded-lg border border-slate-200/70">
                <span class="text-slate-400 block font-medium">Minat Utama</span>
                <span class="text-slate-800 font-bold mt-0.5 block">Kedisiplinan, Baris-Berbaris, Kepanduan</span>
            </div>
            <div class="p-3 bg-slate-50 rounded-lg border border-slate-200/70">
                <span class="text-slate-400 block font-medium">Gaya Kerja Sama</span>
                <span class="text-slate-800 font-bold mt-0.5 block">Tim Besar dengan Instruksi Terstruktur</span>
            </div>
        </div>
    </div>

    <!-- Metodologi notice -->
    <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 text-xs text-slate-600">
        <span class="font-bold text-slate-800">Catatan Penelitian:</span> Skor kecocokan ini dihasilkan melalui instrumen preferensi kuesioner. Perhitungan SAW/TOPSIS/AHP pada sistem final akan dikonfigurasikan sesuai Bab III metodologi penelitian skripsi yang disetujui.
    </div>

</div>
@endsection
