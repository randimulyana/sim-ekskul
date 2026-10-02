@extends('layouts.student')

@section('title', 'Formulir Pendaftaran Ekstrakurikuler')

@section('content')
{{-- DATA DEMO: formulir pendaftaran prototype UI --}}

<div class="max-w-2xl mx-auto space-y-6">

    <!-- Header -->
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Formulir Pendaftaran Ekstrakurikuler</h1>
        <p class="text-sm text-slate-500 mt-1">Konfirmasi pilihan ekstrakurikuler dan kirim pengajuan ke pihak sekolah</p>
    </div>

    <!-- Active Period Badge -->
    <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-4 flex items-center justify-between text-xs text-emerald-900">
        <div class="flex items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
            <span><strong>Periode Aktif:</strong> Tahun Pelajaran 2026/2027 &mdash; Gelombang 1</span>
        </div>
        <span class="px-2 py-0.5 rounded bg-emerald-100 text-emerald-800 font-bold uppercase text-[10px]">Pendaftaran Dibuka</span>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 sm:p-8">
        <form method="POST" action="/siswa/pendaftaran" class="space-y-6">
            @csrf

            <!-- Section 1: Ekskul Pilihan -->
            <div>
                <label class="block text-sm font-bold text-slate-900 mb-2">1. Ekstrakurikuler Pilihan</label>
                <div class="p-4 rounded-xl border border-blue-200 bg-blue-50/50 flex items-start justify-between gap-4">
                    <div class="flex items-start gap-3">
                        <span class="text-2xl p-2 bg-white rounded-lg border border-blue-100 shadow-xs">🚩</span>
                        <div>
                            <div class="flex items-center gap-2">
                                <h3 class="text-base font-bold text-slate-900">PASKIBRAKA</h3>
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-red-100 text-red-700">Organisasi</span>
                            </div>
                            <p class="text-xs text-slate-600 mt-1">Pasukan Pengibar Bendera Pusaka SMKN 3 Payakumbuh</p>
                            <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-blue-700 mt-2">
                                <svg class="w-3.5 h-3.5 text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                Rekomendasi Teratas Sistem (Skor: 92/100)
                            </span>
                        </div>
                    </div>
                    <a href="/siswa/ekstrakurikuler" class="text-xs font-semibold text-blue-600 hover:text-blue-800 underline flex-shrink-0">
                        Ubah Pilihan
                    </a>
                </div>
            </div>

            <!-- Section 2: Ringkasan Identitas Siswa -->
            <div>
                <label class="block text-sm font-bold text-slate-900 mb-2">2. Identitas Pendaftar</label>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs bg-slate-50 p-4 rounded-xl border border-slate-200">
                    <div>
                        <span class="text-slate-500 block">Nama Lengkap</span>
                        <span class="text-slate-900 font-bold mt-0.5 block text-sm">Andi Saputra</span>
                    </div>
                    <div>
                        <span class="text-slate-500 block">Nomor Induk Siswa (NIS)</span>
                        <span class="text-slate-900 font-bold mt-0.5 block text-sm">2026001</span>
                    </div>
                    <div>
                        <span class="text-slate-500 block">Kelas</span>
                        <span class="text-slate-900 font-bold mt-0.5 block text-sm">KULINER 1</span>
                    </div>
                    <div>
                        <span class="text-slate-500 block">Nomor WhatsApp Aktif</span>
                        <span class="text-slate-900 font-bold mt-0.5 block text-sm">08123456789</span>
                    </div>
                </div>
                <p class="text-[11px] text-slate-400 mt-1.5">*Data diambil otomatis dari profil akun siswa kamu.</p>
            </div>

            <!-- Section 3: Catatan / Alasan Memilih -->
            <div>
                <label class="block text-sm font-bold text-slate-900 mb-2">3. Alasan atau Motivasi Bergabung (Opsional)</label>
                <textarea
                    rows="3"
                    name="alasan"
                    class="w-full rounded-lg border border-slate-200 p-3 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none"
                    placeholder="Tuliskan motivasi singkat atau harapan kamu mengikuti kegiatan ekstrakurikuler ini..."
                >Saya ingin melatih kedisiplinan dan bercita-cita menjadi anggota Paskibraka Kota Payakumbuh.</textarea>
            </div>

            <!-- Section 4: Persetujuan & Pernyataan -->
            <div class="space-y-3 pt-2">
                <label class="block text-sm font-bold text-slate-900">4. Lembar Persetujuan Siswa</label>

                <label class="flex items-start gap-3 p-3 rounded-lg border border-slate-200 hover:bg-slate-50 cursor-pointer">
                    <input type="checkbox" required checked class="mt-0.5 rounded text-blue-600 focus:ring-blue-500">
                    <span class="text-xs text-slate-700 leading-relaxed">
                        Saya memilih ekstrakurikuler ini secara <strong>sadar dan sukarela</strong> berdasarkan pertimbangan pribadi serta arahan orang tua/wali.
                    </span>
                </label>

                <label class="flex items-start gap-3 p-3 rounded-lg border border-slate-200 hover:bg-slate-50 cursor-pointer">
                    <input type="checkbox" required checked class="mt-0.5 rounded text-blue-600 focus:ring-blue-500">
                    <span class="text-xs text-slate-700 leading-relaxed">
                        Saya memahami bahwa hasil rekomendasi kuesioner adalah <strong>alat bantu pertimbangan</strong>, dan saya bersedia mematuhi aturan serta tata tertib ekstrakurikuler di SMKN 3 Payakumbuh.
                    </span>
                </label>

                <label class="flex items-start gap-3 p-3 rounded-lg border border-slate-200 hover:bg-slate-50 cursor-pointer">
                    <input type="checkbox" required checked class="mt-0.5 rounded text-blue-600 focus:ring-blue-500">
                    <span class="text-xs text-slate-700 leading-relaxed">
                        Data identitas dan informasi yang saya sampaikan adalah benar dan dapat dipertanggungjawabkan.
                    </span>
                </label>
            </div>

            <!-- Submit Button -->
            <div class="pt-4 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                <a href="/siswa/rekomendasi" class="text-xs font-semibold text-slate-500 hover:text-slate-800">
                    &larr; Kembali
                </a>
                <button
                    type="submit"
                    class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow-sm transition-colors"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>Konfirmasi &amp; Kirim Pendaftaran</span>
                </button>
            </div>

        </form>
    </div>

</div>
@endsection
