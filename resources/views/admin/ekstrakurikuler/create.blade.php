@extends('layouts.admin')
@section('page-title', 'Tambah Ekstrakurikuler')
@section('content')
<!-- DATA DEMO -->
<div class="max-w-2xl">
    <div class="mb-6">
        <nav class="flex items-center gap-1 text-sm text-slate-500 mb-2">
            <a href="/admin/dashboard" class="hover:text-slate-700">Dashboard</a>
            <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <a href="/admin/ekstrakurikuler" class="hover:text-slate-700">Ekstrakurikuler</a>
            <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-slate-700 font-medium">Tambah</span>
        </nav>
        <h1 class="text-2xl font-bold text-slate-900">Tambah Ekstrakurikuler</h1>
        <p class="mt-1 text-sm text-slate-500">Isi informasi dasar. Data yang belum dikonfirmasi pihak sekolah dapat diperbarui nanti.</p>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
        <form class="space-y-5" method="POST" action="#">
            @csrf

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">
                    Nama Ekstrakurikuler <span class="text-red-500">*</span>
                </label>
                <input type="text" name="nama"
                    class="block w-full rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-900 placeholder-slate-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
                    placeholder="Nama ekskul" required />
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Kategori</label>
                <select name="kategori"
                    class="block w-full rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                    <option value="">Pilih kategori...</option>
                    <option>Organisasi</option>
                    <option>Seni &amp; Budaya</option>
                    <option>Bela Diri</option>
                    <option>Akademik</option>
                    <option>Keagamaan</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Deskripsi</label>
                <textarea name="deskripsi" rows="4"
                    class="block w-full rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-900 placeholder-slate-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 resize-none"
                    placeholder="Deskripsi singkat tentang ekstrakurikuler ini..."></textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Jadwal</label>
                    <input type="text" name="jadwal"
                        class="block w-full rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-900 placeholder-slate-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
                        placeholder="cth: Sabtu, 08.00–10.00 WIB" />
                    <p class="text-xs text-slate-400 mt-1">ℹ Dapat diperbarui setelah diverifikasi pihak sekolah</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Lokasi / Tempat</label>
                    <input type="text" name="lokasi"
                        class="block w-full rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-900 placeholder-slate-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
                        placeholder="cth: Lapangan utama" />
                    <p class="text-xs text-slate-400 mt-1">ℹ Dapat diperbarui setelah diverifikasi pihak sekolah</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Nama Pembina</label>
                    <input type="text" name="pembina"
                        class="block w-full rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-900 placeholder-slate-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
                        placeholder="Nama pembina ekskul" />
                    <p class="text-xs text-slate-400 mt-1">ℹ Dapat diperbarui setelah diverifikasi pihak sekolah</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Status</label>
                    <select name="status"
                        class="block w-full rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                        <option value="aktif">Aktif</option>
                        <option value="nonaktif">Nonaktif</option>
                    </select>
                </div>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit"
                    class="px-6 py-2.5 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1">
                    Simpan
                </button>
                <a href="/admin/ekstrakurikuler"
                    class="px-6 py-2.5 bg-white text-slate-700 text-sm font-medium rounded-lg border border-slate-200 hover:bg-slate-50 transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
