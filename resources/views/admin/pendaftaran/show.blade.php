@extends('layouts.admin')

@section('page-title', 'Detail Pendaftaran Siswa')

@section('content')
<!-- DATA DEMO: detail pendaftaran siswa admin prototype UI -->
<div class="max-w-4xl space-y-6">

    <!-- Breadcrumb & Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <nav class="flex items-center gap-1 text-xs text-slate-500 mb-2">
                <a href="/admin/dashboard" class="hover:text-slate-700">Dashboard</a>
                <svg class="w-3.5 h-3.5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <a href="/admin/pendaftaran" class="hover:text-slate-700">Pendaftaran</a>
                <svg class="w-3.5 h-3.5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <span class="text-slate-800 font-semibold">REG-2026-001</span>
            </nav>
            <div class="flex items-center gap-3">
                <h1 class="text-2xl font-bold text-slate-900">Pendaftaran: Andi Saputra</h1>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-800">
                    Ditinjau
                </span>
            </div>
            <p class="text-xs text-slate-500 mt-1">Nomor Registrasi: <span class="font-mono font-bold text-slate-700">REG-2026-001</span> &middot; Masuk pada 1 Okt 2026, 14:35 WIB</p>
        </div>

        <a href="/admin/pendaftaran" class="self-start sm:self-auto px-4 py-2 border border-slate-200 text-slate-700 hover:bg-slate-50 text-xs font-semibold rounded-lg transition-colors">
            &larr; Kembali ke Daftar
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Left 2 Cols: Main Info -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Card 1: Ekskul Pilihan -->
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-4">Pilihan Ekstrakurikuler</h3>
                <div class="flex items-start gap-4 p-4 rounded-xl border border-blue-200 bg-blue-50/40">
                    <span class="text-3xl p-2 bg-white rounded-xl border border-blue-100 shadow-xs">🚩</span>
                    <div class="flex-1">
                        <div class="flex items-center gap-2">
                            <h4 class="text-base font-bold text-slate-900">PASKIBRAKA</h4>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-red-100 text-red-700">Organisasi</span>
                        </div>
                        <p class="text-xs text-slate-600 mt-1">Pasukan Pengibar Bendera Pusaka SMKN 3 Payakumbuh</p>
                        <p class="text-xs text-blue-700 font-semibold mt-2">✓ Cocok dengan Rekomendasi Teratas Kuesioner Siswa (Skor: 92/100)</p>
                    </div>
                </div>

                <!-- Motivasi Siswa -->
                <div class="mt-4 pt-4 border-t border-slate-100">
                    <span class="text-[11px] font-semibold text-slate-500 block uppercase">Motivasi Siswa:</span>
                    <p class="text-xs text-slate-700 italic mt-1 bg-slate-50 p-3 rounded-lg border border-slate-200/70">
                        "Saya ingin melatih kedisiplinan dan bercita-cita menjadi anggota Paskibraka Kota Payakumbuh."
                    </p>
                </div>
            </div>

            <!-- Card 2: Identitas Siswa -->
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-4">Informasi Siswa</h3>
                <div class="grid grid-cols-2 gap-4 text-xs">
                    <div>
                        <span class="text-slate-400 block font-semibold">Nama Lengkap</span>
                        <span class="text-slate-900 font-bold text-sm block mt-0.5">Andi Saputra</span>
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
                        <span class="text-slate-400 block font-semibold">Nomor WhatsApp</span>
                        <span class="text-slate-900 font-mono font-bold block mt-0.5">08123456789</span>
                    </div>
                    <div class="col-span-2">
                        <span class="text-slate-400 block font-semibold">Email Siswa</span>
                        <span class="text-slate-900 block mt-0.5">andi.saputra@smkn3payakumbuh.sch.id</span>
                    </div>
                </div>
            </div>

            <!-- Card 3: Action Form (UI Only) -->
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-4">Tindakan Admin</h3>

                <form onsubmit="event.preventDefault(); alert('Perubahan status simulasi prototype UI!');" class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Catatan Verifikasi Admin (Opsional)</label>
                        <textarea
                            rows="3"
                            class="block w-full rounded-lg border border-slate-200 p-3 text-xs text-slate-900 focus:outline-none focus:ring-1 focus:ring-blue-500 resize-none"
                            placeholder="Tuliskan catatan tindak lanjut atau alasan penolakan jika ada..."
                        >Berkas identitas lengkap. Tinggi badan memenuhi kualifikasi awal Paskibraka.</textarea>
                    </div>

                    <div class="flex flex-wrap items-center gap-3 pt-2">
                        <button type="button" onclick="alert('Status diubah: Diterima');" class="px-5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-lg shadow-sm transition-colors">
                            ✓ Terima Pendaftaran
                        </button>
                        <button type="button" onclick="alert('Status diubah: Ditolak');" class="px-5 py-2 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-lg shadow-sm transition-colors">
                            ✕ Tolak Pengajuan
                        </button>
                        <button type="button" onclick="alert('Status diatur: Ditinjau');" class="px-4 py-2 border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-semibold rounded-lg transition-colors">
                            Reset ke Status Ditinjau
                        </button>
                    </div>
                </form>
            </div>

        </div>

        <!-- Right 1 Col: Status & Timeline -->
        <div class="space-y-6">

            <!-- Status Card -->
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-4">Timeline Verifikasi</h3>

                <div class="space-y-5 relative pl-6 before:content-[''] before:absolute before:left-2.5 before:top-2 before:bottom-2 before:w-0.5 before:bg-slate-200">
                    <!-- 1. Terkirim -->
                    <div class="relative">
                        <span class="absolute -left-6 top-0.5 w-5 h-5 rounded-full bg-emerald-500 text-white flex items-center justify-center text-[10px] ring-4 ring-white">
                            ✓
                        </span>
                        <div>
                            <p class="text-xs font-bold text-slate-800">Terkirim oleh Siswa</p>
                            <p class="text-[11px] text-slate-400">1 Okt 2026, 14:35 WIB</p>
                        </div>
                    </div>

                    <!-- 2. Ditinjau -->
                    <div class="relative">
                        <span class="absolute -left-6 top-0.5 w-5 h-5 rounded-full bg-amber-500 text-white flex items-center justify-center text-[10px] ring-4 ring-white animate-pulse">
                            ●
                        </span>
                        <div>
                            <p class="text-xs font-bold text-amber-800">Sedang Ditinjau Admin</p>
                            <p class="text-[11px] text-slate-400">2 Okt 2026, 09:15 WIB</p>
                        </div>
                    </div>

                    <!-- 3. Penetapan Akhir -->
                    <div class="relative">
                        <span class="absolute -left-6 top-0.5 w-5 h-5 rounded-full bg-slate-200 text-slate-400 flex items-center justify-center text-[10px] ring-4 ring-white">
                            ○
                        </span>
                        <div>
                            <p class="text-xs font-semibold text-slate-400">Keputusan Akhir</p>
                            <p class="text-[11px] text-slate-400">Menunggu persetujuan admin</p>
                        </div>
                    </div>
                </div>

                <!-- Info Period Box -->
                <div class="mt-6 pt-5 border-t border-slate-100 text-xs text-slate-500 space-y-1.5">
                    <div class="flex justify-between">
                        <span>Periode:</span>
                        <span class="font-bold text-slate-800">TP 2026/2027</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Status Periode:</span>
                        <span class="text-emerald-700 font-semibold">Dibuka</span>
                    </div>
                </div>
            </div>

            <!-- Supporting info -->
            <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 text-xs text-slate-600">
                <p class="font-bold text-slate-800 mb-1">Catatan Kebijakan:</p>
                <p class="leading-relaxed">Aturan kuota resmi dan seleksi khusus antar ekskul belum difinalisasi pihak sekolah. Keputusan penerimaan saat ini dilakukan secara administratif.</p>
            </div>

        </div>

    </div>

</div>
@endsection
