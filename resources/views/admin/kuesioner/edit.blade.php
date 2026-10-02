@extends('layouts.admin')

@section('page-title', 'Edit Pertanyaan Kuesioner')

@section('content')
<div class="max-w-3xl space-y-6">

    <!-- Breadcrumb & Header -->
    <div>
        <nav class="flex items-center gap-1 text-xs text-slate-500 mb-2">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-slate-700">Dashboard</a>
            <svg class="w-3.5 h-3.5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <a href="{{ route('admin.kuesioner.index') }}" class="hover:text-slate-700">Kuesioner</a>
            <svg class="w-3.5 h-3.5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-slate-800 font-semibold">Edit Butir #{{ $question->order }}</span>
        </nav>
        <h1 class="text-2xl font-bold text-slate-900">Edit Pertanyaan Kuesioner</h1>
        <p class="text-xs text-slate-500 mt-1">Perbarui redaksi butir atau tipe skala jawaban</p>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 sm:p-7">
        <form class="space-y-5" method="POST" action="{{ route('admin.kuesioner.update', $question->id) }}">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Teks Butir Pertanyaan <span class="text-red-500">*</span></label>
                <textarea
                    name="question_text"
                    rows="3"
                    class="block w-full rounded-lg border @error('question_text') border-red-500 bg-red-50 @else border-slate-200 @enderror p-3 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 resize-none"
                    required
                >{{ old('question_text', $question->question_text) }}</textarea>
                @error('question_text')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Kategori Pertanyaan <span class="text-red-500">*</span></label>
                    <select name="category" class="block w-full rounded-lg border @error('category') border-red-500 bg-red-50 @else border-slate-200 @enderror px-3.5 py-2.5 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 bg-white" required>
                        @php
                        $selCat = old('category', $question->category);
                        @endphp
                        @foreach(['Minat Awal', 'Minat & Ketertarikan', 'Karakteristik Diri', 'Pengalaman', 'Kemampuan'] as $cat)
                            <option value="{{ $cat }}" {{ $selCat === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Tipe Skala Jawaban <span class="text-red-500">*</span></label>
                    <select id="tipeJawaban" name="type" onchange="toggleOptionBox()" class="block w-full rounded-lg border @error('type') border-red-500 bg-red-50 @else border-slate-200 @enderror px-3.5 py-2.5 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 bg-white" required>
                        @php
                        $selType = old('type', $question->type);
                        @endphp
                        <option value="likert" {{ $selType === 'likert' ? 'selected' : '' }}>Skala Likert (1-5)</option>
                        <option value="radio" {{ $selType === 'radio' ? 'selected' : '' }}>Pilihan Tunggal (Radio)</option>
                        <option value="checkbox" {{ $selType === 'checkbox' ? 'selected' : '' }}>Pilihan Ganda (Checkbox)</option>
                        <option value="textarea" {{ $selType === 'textarea' ? 'selected' : '' }}>Esai Singkat (Textarea)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nomor Urutan Tampil</label>
                    <input type="number" name="order" value="{{ old('order', $question->order) }}" min="1" class="block w-full rounded-lg border border-slate-200 px-3.5 py-2.5 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500" />
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Pemetaan Kriteria (Phase 4)</label>
                    <select name="criterion_id" class="block w-full rounded-lg border border-slate-200 px-3.5 py-2.5 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 bg-white">
                        <option value="">-- Belum Dipetakan (Kualitatif / Needs Validation) --</option>
                        @isset($criteria)
                            @foreach($criteria as $crit)
                                <option value="{{ $crit->id }}" {{ old('criterion_id', $question->criterion_id) == $crit->id ? 'selected' : '' }}>
                                    {{ $crit->code }} - {{ $crit->name }} ({{ round($crit->weight * 100) }}%)
                                </option>
                            @endforeach
                        @endisset
                    </select>
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Status Pertanyaan</label>
                    <select name="is_active" class="block w-full rounded-lg border border-slate-200 px-3.5 py-2.5 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 bg-white">
                        <option value="1" {{ old('is_active', $question->is_active ? '1' : '0') == '1' ? 'selected' : '' }}>Aktif (Tampil di Kuesioner Siswa)</option>
                        <option value="0" {{ old('is_active', $question->is_active ? '1' : '0') == '0' ? 'selected' : '' }}>Draft / Nonaktif</option>
                    </select>
                </div>
            </div>

            <!-- Opsi Jawaban Container Pre-filled -->
            <div id="optionBox" class="{{ in_array(old('type', $question->type), ['radio', 'checkbox'], true) ? '' : 'hidden' }} p-4 bg-slate-50 rounded-xl border border-slate-200 space-y-3">
                <span class="text-xs font-bold text-slate-700 uppercase block">Daftar Pilihan Opsi:</span>
                <div class="space-y-2" id="optionList">
                    @forelse($question->options as $opt)
                        <input type="text" name="options[]" value="{{ $opt->option_text }}" class="block w-full rounded-lg border border-slate-200 px-3 py-2 text-xs bg-white text-slate-900">
                    @empty
                        <input type="text" name="options[]" placeholder="Pilihan 1..." class="block w-full rounded-lg border border-slate-200 px-3 py-2 text-xs bg-white text-slate-900">
                        <input type="text" name="options[]" placeholder="Pilihan 2..." class="block w-full rounded-lg border border-slate-200 px-3 py-2 text-xs bg-white text-slate-900">
                    @endforelse
                </div>
                <button type="button" onclick="addOptionRow()" class="text-xs font-bold text-blue-600 hover:text-blue-800">
                    + Tambah Opsi Jawaban
                </button>
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center gap-3">
                <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow-sm transition-colors">
                    Simpan Perubahan
                </button>
                <a href="{{ route('admin.kuesioner.index') }}" class="px-5 py-2.5 border border-slate-200 text-slate-700 text-sm font-semibold rounded-lg hover:bg-slate-50 transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>

</div>

@push('scripts')
<script>
function toggleOptionBox() {
    const val = document.getElementById('tipeJawaban').value;
    const box = document.getElementById('optionBox');
    if (val === 'radio' || val === 'checkbox') {
        box.classList.remove('hidden');
    } else {
        box.classList.add('hidden');
    }
}

function addOptionRow() {
    const container = document.getElementById('optionList');
    const input = document.createElement('input');
    input.type = 'text';
    input.name = 'options[]';
    input.placeholder = 'Pilihan baru...';
    input.className = 'block w-full rounded-lg border border-slate-200 px-3 py-2 text-xs bg-white text-slate-900';
    container.appendChild(input);
}
</script>
@endpush
@endsection
