@extends('layouts.admin')
@section('page-title', 'Tambah Ekstrakurikuler')
@section('content')
<div class="max-w-2xl">
    <div class="mb-6">
        <nav class="flex items-center gap-1 text-sm text-slate-500 mb-2">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-slate-700">Dashboard</a>
            <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <a href="{{ route('admin.ekstrakurikuler.index') }}" class="hover:text-slate-700">Ekstrakurikuler</a>
            <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-slate-700 font-medium">Tambah</span>
        </nav>
        <h1 class="text-2xl font-bold text-slate-900">Tambah Ekstrakurikuler</h1>
        <p class="mt-1 text-sm text-slate-500">Isi informasi dasar. Data yang belum dikonfirmasi pihak sekolah dapat diperbarui nanti.</p>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
        <form class="space-y-5" method="POST" action="{{ route('admin.ekstrakurikuler.store') }}">
            @csrf

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">
                    Nama Ekstrakurikuler <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" value="{{ old('name', old('nama')) }}" required
                    class="block w-full rounded-lg border @error('name') border-red-500 bg-red-50 @else border-slate-200 @enderror px-3 py-2 text-sm text-slate-900 placeholder-slate-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
                    placeholder="Contoh: PASKIBRAKA" />
                @error('name')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Kategori</label>
                <select name="category"
                    class="block w-full rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 bg-white">
                    <option value="">Pilih kategori...</option>
                    @foreach(['Organisasi', 'Seni & Budaya', 'Bela Diri', 'Akademik', 'Keagamaan'] as $cat)
                        <option value="{{ $cat }}" {{ old('category', old('kategori')) === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
                @error('category')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Deskripsi</label>
                <textarea name="description" rows="4"
                    class="block w-full rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-900 placeholder-slate-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 resize-none"
                    placeholder="Deskripsi singkat tentang ekstrakurikuler ini...">{{ old('description', old('deskripsi')) }}</textarea>
                @error('description')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Jadwal</label>
                    <input type="text" name="schedule" value="{{ old('schedule', old('jadwal')) }}"
                        class="block w-full rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-900 placeholder-slate-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
                        placeholder="cth: Sabtu, 08.00–10.00 WIB" />
                    <p class="text-xs text-slate-400 mt-1">ℹ Dapat diperbarui setelah diverifikasi pihak sekolah</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Lokasi / Tempat</label>
                    <input type="text" name="location" value="{{ old('location', old('lokasi')) }}"
                        class="block w-full rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-900 placeholder-slate-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
                        placeholder="cth: Lapangan utama" />
                    <p class="text-xs text-slate-400 mt-1">ℹ Dapat diperbarui setelah diverifikasi pihak sekolah</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Nama Pembina</label>
                    <input type="text" name="coach_name" value="{{ old('coach_name', old('pembina')) }}"
                        class="block w-full rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-900 placeholder-slate-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
                        placeholder="Nama pembina ekskul" />
                    <p class="text-xs text-slate-400 mt-1">ℹ Dapat diperbarui setelah diverifikasi pihak sekolah</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Status</label>
                    <select name="is_active"
                        class="block w-full rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 bg-white">
                        <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit"
                    class="px-6 py-2.5 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1">
                    Simpan
                </button>
                <a href="{{ route('admin.ekstrakurikuler.index') }}"
                    class="px-6 py-2.5 bg-white text-slate-700 text-sm font-medium rounded-lg border border-slate-200 hover:bg-slate-50 transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
