@extends('layouts.admin')

@section('page-title', 'Edit Ekstrakurikuler')

@section('content')
<!-- DATA DEMO: data form edit ekstrakurikuler prototype UI -->
<div class="max-w-3xl space-y-6">

    <!-- Breadcrumb & Header -->
    <div>
        <nav class="flex items-center gap-1 text-xs text-slate-500 mb-2">
            <a href="/admin/dashboard" class="hover:text-slate-700">Dashboard</a>
            <svg class="w-3.5 h-3.5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <a href="/admin/ekstrakurikuler" class="hover:text-slate-700">Ekstrakurikuler</a>
            <svg class="w-3.5 h-3.5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-slate-800 font-semibold">Edit</span>
        </nav>
        <h1 class="text-2xl font-bold text-slate-900">Edit Ekstrakurikuler: PASKIBRAKA</h1>
        <p class="text-xs text-slate-500 mt-1">Perbarui data informasi ekstrakurikuler yang ditampilkan ke siswa.</p>
    </div>

    <!-- Alert placeholder info -->
    <div class="bg-amber-50 border border-amber-200 rounded-xl p-3.5 flex items-start gap-2.5 text-xs text-amber-800">
        <svg class="w-4 h-4 text-amber-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <span>Bidang informasi yang belum dikonfirmasi oleh pembina atau manajemen sekolah dapat disesuaikan kembali sewaktu-waktu.</span>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 sm:p-7">
        <form class="space-y-5" method="POST" action="#">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Ekstrakurikuler <span class="text-red-500">*</span></label>
                <input
                    type="text"
                    name="nama"
                    value="PASKIBRAKA"
                    class="block w-full rounded-lg border border-slate-200 px-3.5 py-2.5 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
                    required
                />
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Kategori</label>
                <select name="kategori" class="block w-full rounded-lg border border-slate-200 px-3.5 py-2.5 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                    <option selected>Organisasi</option>
                    <option>Seni &amp; Budaya</option>
                    <option>Bela Diri</option>
                    <option>Akademik</option>
                    <option>Keagamaan</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Deskripsi Singkat</label>
                <textarea name="deskripsi" rows="4" class="block w-full rounded-lg border border-slate-200 p-3 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 resize-none">Pasukan Pengibar Bendera Pusaka yang melatih kedisiplinan tingkat tinggi, ketahanan fisik, kepemimpinan, dan rasa cinta tanah air.</textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Jadwal Rutin (Placeholder)</label>
                    <input type="text" name="jadwal" value="Rabu &amp; Sabtu, 15.30 - 17.30 WIB" class="block w-full rounded-lg border border-slate-200 px-3.5 py-2.5 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500" />
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Lokasi Kegiatan (Placeholder)</label>
                    <input type="text" name="lokasi" value="Lapangan Utama Kampus SMKN 3 Payakumbuh" class="block w-full rounded-lg border border-slate-200 px-3.5 py-2.5 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500" />
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Pembina (Placeholder)</label>
                    <input type="text" name="pembina" value="Drs. Hendri Syahputra, M.Pd." class="block w-full rounded-lg border border-slate-200 px-3.5 py-2.5 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500" />
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Estimasi Kuota</label>
                    <input type="number" name="kuota" value="60" class="block w-full rounded-lg border border-slate-200 px-3.5 py-2.5 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500" />
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Status Aktif</label>
                <select name="status" class="block w-full rounded-lg border border-slate-200 px-3.5 py-2.5 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                    <option value="aktif" selected>Aktif (Tampil di Katalog &amp; Rekomendasi)</option>
                    <option value="nonaktif">Nonaktif (Diarsipkan)</option>
                </select>
                <p class="text-[11px] text-slate-400 mt-1">Ekstrakurikuler yang memiliki riwayat pendaftaran tidak dihapus permanen, melainkan dinonaktifkan.</p>
            </div>

            <div class="pt-3 border-t border-slate-100 flex items-center gap-3">
                <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow-sm transition-colors">
                    Simpan Perubahan
                </button>
                <a href="/admin/ekstrakurikuler" class="px-5 py-2.5 border border-slate-200 text-slate-700 text-sm font-semibold rounded-lg hover:bg-slate-50 transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>

</div>
@endsection
