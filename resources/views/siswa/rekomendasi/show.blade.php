@extends('layouts.student')

@section('title', 'Detail Rekomendasi Ekstrakurikuler')

@section('content')
{{-- DATA DEMO: detail rekomendasi prototype UI --}}

@php
$id = $id ?? 1;
$rekomendasiData = [
    1 => [
        'nama' => 'PASKIBRAKA',
        'kategori' => 'Organisasi',
        'skor' => 92,
        'ringkasan' => 'Berdasarkan pengisian kuesioner, kamu memiliki preferensi gerak fisik yang prima, orientasi kedisiplinan yang tinggi, serta gaya belajar kinestetik yang sangat sejalan dengan kurikulum latihan baris berbaris Paskibraka.',
        'faktor' => [
            ['title' => 'Tingkat Ketahanan Fisik Prima', 'desc' => 'Skor stamina dan ketahanan fisik kamu berada pada tingkat maksimal (5/5) pada penilaian kuesioner.'],
            ['title' => 'Gaya Belajar Praktik & Kinestetik', 'desc' => 'Kamu lebih menyukai metode belajar demonstrasi dan aksi bergerak secara langsung.'],
            ['title' => 'Kesiapan Bekerja dalam Regu Berstruktur', 'desc' => 'Kamu merasa nyaman menjalankan instruksi formal dalam formasi tim kelompok.'],
            ['title' => 'Komitmen Waktu & Kedisiplinan Tinggi', 'desc' => 'Nilai kepatuhan jadwal kehadiran kamu mendukung intensitas latihan rutin.'],
        ],
        'jadwal' => 'Rabu & Sabtu, 15.30 - 17.30 WIB',
        'lokasi' => 'Lapangan Utama SMKN 3 Payakumbuh',
        'pembina' => 'Drs. Hendri Syahputra, M.Pd.',
    ],
    2 => [
        'nama' => 'PRAMUKA',
        'kategori' => 'Organisasi',
        'skor' => 87,
        'ringkasan' => 'Kamu menyukai petualangan di alam bebas dan memiliki jiwa sosial yang tinggi, sangat cocok dengan kepanduan Pramuka.',
        'faktor' => [
            ['title' => 'Eksplorasi Luar Ruangan', 'desc' => 'Preferensi aktivitas outdoor yang tinggi sejalan dengan kegiatan berkemah dan penjelajahan.'],
            ['title' => 'Kemandirian & Jiwa Sosial', 'desc' => 'Nilai kepedulian sesama mendukung kegiatan bakti karya dan pertolongan pertama.'],
            ['title' => 'Kerja Sama Regu', 'desc' => 'Fleksibilitas komunikasi dalam regu kecil.'],
        ],
        'jadwal' => 'Jumat, 14.00 - 17.00 WIB',
        'lokasi' => 'Bumi Perkemahan / Area Terbuka Sekolah',
        'pembina' => 'Rahmat Hidayat, S.Pd.',
    ],
];

$cur = $rekomendasiData[$id] ?? $rekomendasiData[1];
@endphp

<div class="max-w-4xl mx-auto space-y-6">

    <!-- Back Button -->
    <div>
        <a href="/siswa/rekomendasi" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-slate-800 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Daftar Rekomendasi
        </a>
    </div>

    <!-- Main Card -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <!-- Top Banner -->
        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 p-6 sm:p-8 text-white">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <span class="inline-block px-3 py-1 bg-white/20 backdrop-blur-sm rounded-full text-xs font-semibold uppercase tracking-wider text-blue-100 mb-2">
                        {{ $cur['kategori'] }}
                    </span>
                    <h1 class="text-2xl sm:text-3xl font-extrabold">{{ $cur['nama'] }}</h1>
                    <p class="text-blue-100 text-xs sm:text-sm mt-1">Detail Analisis Kesesuaian Kuesioner Minat Siswa</p>
                </div>
                <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl px-5 py-3 text-center sm:text-right">
                    <p class="text-xs text-blue-200 font-semibold uppercase">Skor Kecocokan</p>
                    <p class="text-3xl font-extrabold text-white mt-0.5">{{ $cur['skor'] }} <span class="text-sm font-normal text-blue-200">/ 100</span></p>
                </div>
            </div>
        </div>

        <div class="p-6 sm:p-8 space-y-8">
            <!-- Penjelasan Mengapa Cocok -->
            <div>
                <h2 class="text-base font-bold text-slate-900 mb-2">Mengapa Ekstrakurikuler Ini Direkomendasikan?</h2>
                <p class="text-sm text-slate-600 leading-relaxed bg-slate-50 p-4 rounded-xl border border-slate-200/70">{{ $cur['ringkasan'] }}</p>
            </div>

            <!-- Faktor Pendukung -->
            <div>
                <h2 class="text-base font-bold text-slate-900 mb-3">Faktor Kunci Pendukung (Analisis Kriteria)</h2>
                <div class="space-y-3">
                    @foreach($cur['faktor'] as $f)
                    <div class="flex items-start gap-3 p-4 rounded-xl border border-slate-100 bg-white shadow-xs">
                        <div class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-800">{{ $f['title'] }}</p>
                            <p class="text-xs text-slate-500 mt-0.5 leading-relaxed">{{ $f['desc'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Ringkasan Kegiatan Ekskul -->
            <div>
                <h2 class="text-base font-bold text-slate-900 mb-3">Informasi Jadwal & Pembina (Placeholder)</h2>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-xs">
                    <div class="p-3.5 bg-slate-50 rounded-lg border border-slate-200/70">
                        <span class="text-slate-400 font-semibold block uppercase">Jadwal Latihan</span>
                        <span class="text-slate-800 font-bold mt-1 block">{{ $cur['jadwal'] }}</span>
                    </div>
                    <div class="p-3.5 bg-slate-50 rounded-lg border border-slate-200/70">
                        <span class="text-slate-400 font-semibold block uppercase">Lokasi</span>
                        <span class="text-slate-800 font-bold mt-1 block">{{ $cur['lokasi'] }}</span>
                    </div>
                    <div class="p-3.5 bg-slate-50 rounded-lg border border-slate-200/70">
                        <span class="text-slate-400 font-semibold block uppercase">Nama Pembina</span>
                        <span class="text-slate-800 font-bold mt-1 block">{{ $cur['pembina'] }}</span>
                    </div>
                </div>
            </div>

            <!-- Catatan Batasan -->
            <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 text-xs text-amber-900">
                <span class="font-bold">Batasan Rekomendasi:</span> Hasil ini adalah instrumen bantu pertimbangan. Pilihan ekstrakurikuler sepenuhnya merupakan hak siswa secara sadar sesuai dengan minat yang ingin dikembangkan di SMK Negeri 3 Payakumbuh.
            </div>

            <!-- Action buttons -->
            <div class="pt-4 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                <a href="/siswa/ekstrakurikuler/{{ $id }}" class="text-xs font-semibold text-slate-600 hover:text-slate-900">
                    &larr; Lihat Selengkapnya di Profil Ekskul
                </a>
                <a href="/siswa/pendaftaran" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow-sm transition-colors">
                    <span>Pilih dan Ajukan Pendaftaran</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            </div>
        </div>
    </div>

</div>
@endsection
