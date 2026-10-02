@extends('layouts.admin')

@section('page-title', 'Kelola Kuesioner')

@section('content')
<!-- DATA DEMO: kelola pertanyaan kuesioner admin prototype UI -->
<div class="space-y-6">

    <!-- Header & Action -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Kelola Instrumen Kuesioner</h1>
            <p class="text-xs text-slate-500 mt-1">Daftar butir pertanyaan minat dan karakteristik siswa untuk mesin rekomendasi</p>
        </div>
        <a href="/admin/kuesioner/create" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-lg shadow-sm transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Pertanyaan
        </a>
    </div>

    <!-- Alert Instrument notice -->
    <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 flex items-start gap-3 text-xs text-amber-800">
        <svg class="w-5 h-5 text-amber-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <div>
            <span class="font-bold">[PERLU KONFIRMASI] Validitas Instrumen:</span> Butir pertanyaan berikut merupakan draft simulasi untuk kebutuhan prototipe. Butir final dan skala pembobotan rekomendasi harus divalidasi oleh pembimbing penelitian atau ahli sebelum dipakai dalam riset final.
        </div>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <h3 class="text-sm font-bold text-slate-900">Daftar Pertanyaan Aktif (10 Butir)</h3>
            <span class="text-xs text-slate-400">5 Kategori Penilaian</span>
        </div>

        @php
        // DATA DEMO: butir kuesioner
        $questions = [
            ['id' => 1, 'urutan' => 1, 'teks' => 'Bagaimana cara kamu belajar hal baru yang paling menyenangkan?', 'kategori' => 'Minat Awal', 'tipe' => 'Pilihan Tunggal (Radio)', 'status' => 'Aktif'],
            ['id' => 2, 'urutan' => 2, 'teks' => 'Seberapa sering kamu menyukai aktivitas yang menuntut ketahanan fisik di luar ruangan?', 'kategori' => 'Minat Awal', 'tipe' => 'Skala Likert (1-5)', 'status' => 'Aktif'],
            ['id' => 3, 'urutan' => 3, 'teks' => 'Bidang kegiatan mana saja yang menarik perhatianmu? (Pilih satu atau lebih)', 'kategori' => 'Minat & Ketertarikan', 'tipe' => 'Pilihan Ganda (Checkbox)', 'status' => 'Aktif'],
            ['id' => 4, 'urutan' => 4, 'teks' => 'Apakah kamu senang tampil di depan umum atau audiens ramai?', 'kategori' => 'Minat & Ketertarikan', 'tipe' => 'Pilihan Tunggal (Radio)', 'status' => 'Aktif'],
            ['id' => 5, 'urutan' => 5, 'teks' => 'Dalam mengerjakan suatu target, suasana mana yang membuatmu paling produktif?', 'kategori' => 'Karakteristik Diri', 'tipe' => 'Pilihan Tunggal (Radio)', 'status' => 'Aktif'],
            ['id' => 6, 'urutan' => 6, 'teks' => 'Seberapa patuh kamu terhadap aturan waktu dan ketepatan kehadiran (Disiplin)?', 'kategori' => 'Karakteristik Diri', 'tipe' => 'Skala Likert (1-5)', 'status' => 'Aktif'],
            ['id' => 7, 'urutan' => 7, 'teks' => 'Pernahkah kamu aktif mengikuti ekstrakurikuler saat SMP/MTs?', 'kategori' => 'Pengalaman', 'tipe' => 'Pilihan Tunggal (Radio)', 'status' => 'Aktif'],
            ['id' => 8, 'urutan' => 8, 'teks' => 'Ceritakan singkat pengalaman kegiatan atau bakat yang ingin kamu kembangkan:', 'kategori' => 'Pengalaman', 'tipe' => 'Esai Singkat (Textarea)', 'status' => 'Aktif'],
            ['id' => 9, 'urutan' => 9, 'teks' => 'Kemampuan Fisik & Stamina (Daya tahan lari, berdiri tegak, olahraga berulang):', 'kategori' => 'Kemampuan', 'tipe' => 'Skala Likert (1-5)', 'status' => 'Aktif'],
            ['id' => 10, 'urutan' => 10, 'teks' => 'Kemampuan Kerja Sama & Kepemimpinan Tim:', 'kategori' => 'Kemampuan', 'tipe' => 'Skala Likert (1-5)', 'status' => 'Aktif'],
        ];
        @endphp

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase tracking-wider font-semibold">
                    <tr>
                        <th class="px-6 py-3.5 w-16">Urutan</th>
                        <th class="px-6 py-3.5">Butir Pertanyaan</th>
                        <th class="px-6 py-3.5">Kategori</th>
                        <th class="px-6 py-3.5">Tipe Jawaban</th>
                        <th class="px-6 py-3.5">Status</th>
                        <th class="px-6 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($questions as $q)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-3.5 font-mono font-bold text-slate-400 text-center">{{ $q['urutan'] }}</td>
                        <td class="px-6 py-3.5">
                            <span class="font-bold text-slate-800 block text-xs">{{ $q['teks'] }}</span>
                        </td>
                        <td class="px-6 py-3.5">
                            <span class="inline-block px-2 py-0.5 rounded bg-slate-100 text-slate-700 font-medium text-[11px]">
                                {{ $q['kategori'] }}
                            </span>
                        </td>
                        <td class="px-6 py-3.5 text-slate-600 font-medium">{{ $q['tipe'] }}</td>
                        <td class="px-6 py-3.5">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                {{ $q['status'] }}
                            </span>
                        </td>
                        <td class="px-6 py-3.5 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="/admin/kuesioner/{{ $q['id'] }}/edit" class="text-blue-600 hover:text-blue-800 font-semibold">
                                    Edit
                                </a>
                                <span class="text-slate-300">|</span>
                                <button type="button" onclick="alert('Status diubah')" class="text-slate-500 hover:text-slate-800 font-medium">
                                    Nonaktifkan
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
