@extends('layouts.admin')

@section('page-title', 'Edit Kriteria ' . $criterion->code)

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    <!-- Back button & Breadcrumb -->
    <div>
        <a href="{{ route('admin.kriteria.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-slate-800 transition-colors mb-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Daftar Kriteria
        </a>
        <h1 class="text-2xl font-bold text-slate-900">Edit Kriteria {{ $criterion->code }}</h1>
        <p class="mt-1 text-sm text-slate-500">Perbarui informasi kriteria, tipe atribut, bobot, atau status validasi.</p>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 sm:p-8">
        <form method="POST" action="{{ route('admin.kriteria.update', $criterion->id) }}" class="space-y-5">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Kode Kriteria -->
                <div>
                    <label for="code" class="block text-sm font-semibold text-slate-700 mb-1">Kode Kriteria <span class="text-red-500">*</span></label>
                    <input
                        type="text"
                        name="code"
                        id="code"
                        value="{{ old('code', $criterion->code) }}"
                        class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 uppercase font-mono"
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
                        <option value="benefit" {{ old('type', $criterion->type) === 'benefit' ? 'selected' : '' }}>Benefit (Semakin tinggi semakin baik)</option>
                        <option value="cost" {{ old('type', $criterion->type) === 'cost' ? 'selected' : '' }}>Cost (Semakin rendah semakin baik)</option>
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
                    value="{{ old('name', $criterion->name) }}"
                    class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required
                >
                @error('name')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Bobot Kriteria -->
                <div>
                    <label for="weight" class="block text-sm font-semibold text-slate-700 mb-1">Bobot Kriteria <span class="text-red-500">*</span></label>
                    <input
                        type="number"
                        step="0.01"
                        name="weight"
                        id="weight"
                        value="{{ old('weight', $criterion->weight) }}"
                        class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required
                    >
                    <p class="text-xs text-slate-400 mt-1">Format persentase (e.g. 30) atau desimal (0.30).</p>
                    @error('weight')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status Validasi -->
                <div>
                    <label for="status" class="block text-sm font-semibold text-slate-700 mb-1">Status Data</label>
                    <select
                        name="status"
                        id="status"
                        class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                        <option value="proposed" {{ old('status', $criterion->status) === 'proposed' ? 'selected' : '' }}>Proposed / Needs Validation</option>
                        <option value="needs_validation" {{ old('status', $criterion->status) === 'needs_validation' ? 'selected' : '' }}>Needs Validation</option>
                        <option value="validated" {{ old('status', $criterion->status) === 'validated' ? 'selected' : '' }}>Validated (Resmi Sekolah)</option>
                    </select>
                </div>
            </div>

            <!-- Deskripsi -->
            <div>
                <label for="description" class="block text-sm font-semibold text-slate-700 mb-1">Deskripsi Kriteria</label>
                <textarea
                    name="description"
                    id="description"
                    rows="3"
                    class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none"
                >{{ old('description', $criterion->description) }}</textarea>
                @error('description')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.kriteria.index') }}" class="px-4 py-2 border border-slate-200 text-slate-700 hover:bg-slate-50 text-sm font-medium rounded-lg transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow-sm transition-colors">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
