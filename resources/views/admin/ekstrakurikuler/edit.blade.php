@extends('layouts.admin')

@section('page-title', 'Edit Ekstrakurikuler')

@section('content')
<div class="max-w-3xl space-y-6">

    <!-- Breadcrumb & Header -->
    <div>
        <nav class="flex items-center gap-1 text-xs text-slate-500 mb-2">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-slate-700">Dashboard</a>
            <svg class="w-3.5 h-3.5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <a href="{{ route('admin.ekstrakurikuler.index') }}" class="hover:text-slate-700">Ekstrakurikuler</a>
            <svg class="w-3.5 h-3.5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-slate-800 font-semibold">Edit</span>
        </nav>
        <h1 class="text-2xl font-bold text-slate-900">Edit Ekstrakurikuler: {{ $extracurricular->name }}</h1>
        <p class="text-xs text-slate-500 mt-1">Perbarui data informasi ekstrakurikuler yang ditampilkan ke siswa.</p>
    </div>

    <!-- Alert placeholder info -->
    <div class="bg-amber-50 border border-amber-200 rounded-xl p-3.5 flex items-start gap-2.5 text-xs text-amber-800">
        <svg class="w-4 h-4 text-amber-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <span>Bidang informasi yang belum dikonfirmasi oleh pembina atau manajemen sekolah dapat disesuaikan kembali sewaktu-waktu.</span>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 sm:p-7">
        <form class="space-y-5" method="POST" action="{{ route('admin.ekstrakurikuler.update', $extracurricular->id) }}">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Ekstrakurikuler <span class="text-red-500">*</span></label>
                <input
                    type="text"
                    name="name"
                    value="{{ old('name', $extracurricular->name) }}"
                    class="block w-full rounded-lg border @error('name') border-red-500 bg-red-50 @else border-slate-200 @enderror px-3.5 py-2.5 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
                    required
                />
                @error('name')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Kategori</label>
                <select name="category" class="block w-full rounded-lg border @error('category') border-red-500 bg-red-50 @else border-slate-200 @enderror px-3.5 py-2.5 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 bg-white">
                    @php
                    $selCat = old('category', $extracurricular->category);
                    @endphp
                    @foreach(['Organisasi', 'Seni & Budaya', 'Bela Diri', 'Akademik', 'Keagamaan'] as $cat)
                        <option value="{{ $cat }}" {{ $selCat === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
                @error('category')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Deskripsi Singkat</label>
                <textarea name="description" rows="4" class="block w-full rounded-lg border @error('description') border-red-500 bg-red-50 @else border-slate-200 @enderror p-3 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 resize-none">{{ old('description', $extracurricular->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Jadwal Rutin</label>
                    <input type="text" name="schedule" value="{{ old('schedule', $extracurricular->schedule) }}" class="block w-full rounded-lg border border-slate-200 px-3.5 py-2.5 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500" placeholder="cth: Sabtu, 08.00–10.00 WIB" />
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Lokasi Kegiatan</label>
                    <input type="text" name="location" value="{{ old('location', $extracurricular->location) }}" class="block w-full rounded-lg border border-slate-200 px-3.5 py-2.5 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500" placeholder="cth: Lapangan utama" />
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Pembina</label>
                    <input type="text" name="coach_name" value="{{ old('coach_name', $extracurricular->coach_name) }}" class="block w-full rounded-lg border border-slate-200 px-3.5 py-2.5 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500" placeholder="Nama pembina" />
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Estimasi Kuota</label>
                    <input type="number" name="quota" value="{{ old('quota', $extracurricular->quota) }}" class="block w-full rounded-lg border border-slate-200 px-3.5 py-2.5 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500" placeholder="Kapasitas kuota siswa" />
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Status Aktif</label>
                <select name="is_active" class="block w-full rounded-lg border border-slate-200 px-3.5 py-2.5 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 bg-white">
                    <option value="1" {{ old('is_active', $extracurricular->is_active ? '1' : '0') == '1' ? 'selected' : '' }}>Aktif (Tampil di Katalog &amp; Rekomendasi)</option>
                    <option value="0" {{ old('is_active', $extracurricular->is_active ? '1' : '0') == '0' ? 'selected' : '' }}>Nonaktif (Diarsipkan)</option>
                </select>
                <p class="text-[11px] text-slate-400 mt-1">Ekstrakurikuler yang dinonaktifkan tidak akan muncul pada rekomendasi siswa.</p>
            </div>

            <div class="pt-3 border-t border-slate-100 flex items-center gap-3">
                <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow-sm transition-colors">
                    Simpan Perubahan
                </button>
                <a href="{{ route('admin.ekstrakurikuler.index') }}" class="px-5 py-2.5 border border-slate-200 text-slate-700 text-sm font-semibold rounded-lg hover:bg-slate-50 transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>

</div>
@endsection
