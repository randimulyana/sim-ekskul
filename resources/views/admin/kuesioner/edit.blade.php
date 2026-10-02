@extends('layouts.admin')

@section('page-title', 'Edit Pertanyaan Kuesioner')

@section('content')
<!-- DATA DEMO: formulir edit pertanyaan kuesioner prototype UI -->
<div class="max-w-3xl space-y-6">

    <!-- Breadcrumb & Header -->
    <div>
        <nav class="flex items-center gap-1 text-xs text-slate-500 mb-2">
            <a href="/admin/dashboard" class="hover:text-slate-700">Dashboard</a>
            <svg class="w-3.5 h-3.5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <a href="/admin/kuesioner" class="hover:text-slate-700">Kuesioner</a>
            <svg class="w-3.5 h-3.5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-slate-800 font-semibold">Edit Butir #1</span>
        </nav>
        <h1 class="text-2xl font-bold text-slate-900">Edit Pertanyaan Kuesioner</h1>
        <p class="text-xs text-slate-500 mt-1">Perbarui redaksi butir atau tipe skala jawaban</p>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 sm:p-7">
        <form class="space-y-5" method="POST" action="#" onsubmit="event.preventDefault(); alert('Perubahan disimpan (simulasi UI)'); window.location.href='/admin/kuesioner';">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Teks Butir Pertanyaan <span class="text-red-500">*</span></label>
                <textarea
                    name="teks"
                    rows="3"
                    class="block w-full rounded-lg border border-slate-200 p-3 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 resize-none"
                    required
                >Bagaimana cara kamu belajar hal baru yang paling menyenangkan?</textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Kategori Pertanyaan <span class="text-red-500">*</span></label>
                    <select name="kategori" class="block w-full rounded-lg border border-slate-200 px-3.5 py-2.5 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500" required>
                        <option selected>Minat Awal</option>
                        <option>Minat &amp; Ketertarikan</option>
                        <option>Karakteristik Diri</option>
                        <option>Pengalaman</option>
                        <option>Kemampuan</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Tipe Skala Jawaban <span class="text-red-500">*</span></label>
                    <select id="tipeJawaban" name="tipe" class="block w-full rounded-lg border border-slate-200 px-3.5 py-2.5 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500" required>
                        <option value="radio" selected>Pilihan Tunggal (Radio)</option>
                        <option value="likert">Skala Likert (1-5)</option>
                        <option value="checkbox">Pilihan Ganda (Checkbox)</option>
                        <option value="textarea">Esai Singkat (Textarea)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nomor Urutan Tampil</label>
                    <input type="number" name="urutan" value="1" min="1" class="block w-full rounded-lg border border-slate-200 px-3.5 py-2.5 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500" />
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Status Pertanyaan</label>
                    <select name="status" class="block w-full rounded-lg border border-slate-200 px-3.5 py-2.5 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                        <option value="aktif" selected>Aktif (Tampil di Kuesioner Siswa)</option>
                        <option value="nonaktif">Draft / Nonaktif</option>
                    </select>
                </div>
            </div>

            <!-- Opsi Jawaban Container Pre-filled -->
            <div id="optionBox" class="p-4 bg-slate-50 rounded-xl border border-slate-200 space-y-3">
                <span class="text-xs font-bold text-slate-700 uppercase block">Daftar Pilihan Opsi:</span>
                <div class="space-y-2">
                    <input type="text" value="Praktik langsung, bergerak, dan simulasi fisik (Kinestetik)" class="block w-full rounded-lg border border-slate-200 px-3 py-2 text-xs bg-white text-slate-900">
                    <input type="text" value="Melihat gambar, demonstrasi visual, atau video (Visual)" class="block w-full rounded-lg border border-slate-200 px-3 py-2 text-xs bg-white text-slate-900">
                    <input type="text" value="Mendengarkan penjelasan, diskusi, dan irama bunyi (Auditori)" class="block w-full rounded-lg border border-slate-200 px-3 py-2 text-xs bg-white text-slate-900">
                </div>
                <button type="button" onclick="alert('Tambah opsi baru')" class="text-xs font-bold text-blue-600 hover:text-blue-800">
                    + Tambah Opsi Jawaban
                </button>
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center gap-3">
                <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow-sm transition-colors">
                    Simpan Perubahan
                </button>
                <a href="/admin/kuesioner" class="px-5 py-2.5 border border-slate-200 text-slate-700 text-sm font-semibold rounded-lg hover:bg-slate-50 transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>

</div>
@endsection
