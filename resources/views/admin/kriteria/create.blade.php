@extends('layouts.admin')

@section('page-title', 'Tambah Kriteria')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    <!-- Back button & Breadcrumb -->
    <div>
        <a href="{{ route('admin.kriteria.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-slate-800 transition-colors mb-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Daftar Kriteria
        </a>
        <h1 class="text-2xl font-bold text-slate-900">Tambah Kriteria Baru</h1>
        <p class="mt-1 text-sm text-slate-500">Definisikan kode, nama, jenis atribut, dan bobot preferensi kriteria.</p>
    </div>

    <!-- Notice -->
    <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 text-xs text-amber-900 leading-relaxed">
        <strong>Pemberitahuan:</strong> Seluruh kriteria baru secara baku diberi status <em>Proposed / Needs Validation</em>. Sistem akan secara otomatis menginisiasi skala penilaian 1-5 untuk kriteria baru ini.
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 sm:p-8">
        <form method="POST" action="{{ route('admin.kriteria.store') }}" class="space-y-5">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Kode Kriteria -->
                <div>
                    <label for="code" class="block text-sm font-semibold text-slate-700 mb-1">Kode Kriteria <span class="text-red-500">*</span></label>
                    <input
                        type="text"
                        name="code"
                        id="code"
                        value="{{ old('code') }}"
                        class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 uppercase font-mono"
                        placeholder="Cth: C6"
                        required
                    >
                    @error('code')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tipe Atribut -->
                <div>
                    <label for="type" class="block text-sm font-semibold text-slate-700 mb-1">Tipe Atribut <span class="text-red-500">*</span></label>
                    <select
                        name="type"
                        id="type"
                        class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required
                    >
                        <option value="benefit" {{ old('type', 'benefit') === 'benefit' ? 'selected' : '' }}>Benefit (Semakin tinggi semakin baik)</option>
                        <option value="cost" {{ old('type') === 'cost' ? 'selected' : '' }}>Cost (Semakin rendah semakin baik)</option>
                    </select>
                    @error('type')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Nama Kriteria -->
            <div>
                <label for="name" class="block text-sm font-semibold text-slate-700 mb-1">Nama Kriteria <span class="text-red-500">*</span></label>
                <input
                    type="text"
                    name="name"
                    id="name"
                    value="{{ old('name') }}"
                    class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Cth: Kedisiplinan & Sikap"
                    required
                >
                @error('name')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Bobot Kriteria -->
            <div>
                <label for="weight" class="block text-sm font-semibold text-slate-700 mb-1">Bobot Kriteria (Persentase atau Desimal) <span class="text-red-500">*</span></label>
                <input
                    type="number"
                    step="0.01"
                    name="weight"
                    id="weight"
                    value="{{ old('weight') }}"
                    class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Cth: 20 (untuk 20%) atau 0.20"
                    required
                >
                <p class="text-xs text-slate-400 mt-1">Masukkan angka persentase (1–100) atau desimal (0.01–1.00).</p>
                @error('weight')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Deskripsi -->
            <div>
                <label for="description" class="block text-sm font-semibold text-slate-700 mb-1">Deskripsi Kriteria</label>
                <textarea
                    name="description"
                    id="description"
                    rows="3"
                    class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none"
                    placeholder="Jelaskan aspek yang diukur oleh kriteria ini..."
                >{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.kriteria.index') }}" class="px-4 py-2 border border-slate-200 text-slate-700 hover:bg-slate-50 text-sm font-medium rounded-lg transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow-sm transition-colors">
                    Simpan Kriteria
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
