@extends('layouts.student')

@section('title', 'Katalog Ekstrakurikuler')

@section('content')

<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Katalog Ekstrakurikuler</h1>
            <p class="text-sm text-slate-500 mt-1">Eksplorasi kegiatan ekstrakurikuler di SMK Negeri 3 Payakumbuh</p>
        </div>
        <div class="inline-flex items-center gap-2 bg-amber-50 border border-amber-200 px-3 py-1.5 rounded-lg text-xs text-amber-800">
            <svg class="w-4 h-4 text-amber-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>Daftar ekskul aktif semester ini</span>
        </div>
    </div>

    <!-- Search & Filter Bar -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 space-y-3">
        <div class="flex flex-col md:flex-row gap-3">
            <div class="flex-1 relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <input
                    type="text"
                    id="searchInput"
                    onkeyup="filterEkskul()"
                    placeholder="Cari nama ekstrakurikuler..."
                    class="block w-full pl-10 pr-4 py-2 text-sm rounded-lg border border-slate-200 placeholder-slate-400 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                />
            </div>
        </div>

        <!-- Category Pills -->
        <div class="flex items-center gap-2 overflow-x-auto pb-1 text-sm" id="categoryFilter">
            <button onclick="setCategory('all')" class="cat-btn active px-3.5 py-1.5 rounded-lg text-xs font-semibold bg-blue-600 text-white transition-colors">Semua</button>
            @foreach($categories as $cat)
                <button onclick="setCategory('{{ $cat }}')" class="cat-btn px-3.5 py-1.5 rounded-lg text-xs font-semibold bg-slate-100 text-slate-700 hover:bg-slate-200 transition-colors">{{ $cat }}</button>
            @endforeach
        </div>
    </div>

    <!-- Ekskul Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5" id="ekskulGrid">
        @forelse($extracurriculars as $item)
        <div class="ekskul-card bg-white rounded-xl border border-slate-200 shadow-sm hover:shadow-md hover:border-blue-200 transition-all p-5 flex flex-col justify-between"
             data-name="{{ strtolower($item->name) }}"
             data-category="{{ $item->category }}">
            <div>
                <div class="flex items-start justify-between gap-3 mb-3">
                    <span class="w-10 h-10 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center font-bold text-sm">
                        {{ strtoupper(substr($item->name, 0, 2)) }}
                    </span>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border bg-blue-50 text-blue-700 border-blue-200">
                        {{ $item->category ?: 'Umum' }}
                    </span>
                </div>
                <h3 class="text-base font-bold text-slate-900 group-hover:text-blue-600 transition-colors">{{ $item->name }}</h3>
                <p class="text-xs text-slate-500 mt-2 leading-relaxed line-clamp-3">{{ $item->description ?: 'Kegiatan ekstrakurikuler di lingkungan SMKN 3 Payakumbuh.' }}</p>
            </div>

            <div class="mt-5 pt-4 border-t border-slate-100 flex items-center justify-between">
                <div class="flex items-center gap-1.5 text-xs text-slate-500">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span>{{ $item->registrations_count }} peserta</span>
                </div>
                <a href="{{ route('siswa.ekstrakurikuler.show', $item->id) }}" class="inline-flex items-center gap-1 text-xs font-semibold text-blue-600 hover:text-blue-800">
                    Lihat Detail
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>
        @empty
        <div class="col-span-3 text-center py-12 text-sm text-slate-400">
            Belum ada data ekstrakurikuler aktif yang tersedia.
        </div>
        @endforelse
    </div>

    <!-- Empty State for Search (Hidden by default) -->
    <div id="noResults" class="hidden bg-white rounded-xl border border-slate-200 p-12 text-center">
        <div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3">
            <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        </div>
        <h3 class="text-sm font-semibold text-slate-800">Tidak ada ekstrakurikuler yang sesuai</h3>
        <p class="text-xs text-slate-500 mt-1">Coba gunakan kata kunci lain atau pilih kategori "Semua".</p>
    </div>
</div>

@push('scripts')
<script>
let currentCategory = 'all';

function setCategory(cat) {
    currentCategory = cat;
    // Update active button styling
    document.querySelectorAll('.cat-btn').forEach(btn => {
        btn.classList.remove('bg-blue-600', 'text-white');
        btn.classList.add('bg-slate-100', 'text-slate-700');
    });
    event.target.classList.remove('bg-slate-100', 'text-slate-700');
    event.target.classList.add('bg-blue-600', 'text-white');
    filterEkskul();
}

function filterEkskul() {
    const searchVal = document.getElementById('searchInput').value.toLowerCase().trim();
    const cards = document.querySelectorAll('.ekskul-card');
    let visibleCount = 0;

    cards.forEach(card => {
        const name = card.getAttribute('data-name');
        const category = card.getAttribute('data-category');

        const matchesSearch = name.includes(searchVal);
        const matchesCategory = currentCategory === 'all' || category === currentCategory;

        if (matchesSearch && matchesCategory) {
            card.classList.remove('hidden');
            visibleCount++;
        } else {
            card.classList.add('hidden');
        }
    });

    const noResults = document.getElementById('noResults');
    if (visibleCount === 0) {
        noResults.classList.remove('hidden');
    } else {
        noResults.classList.add('hidden');
    }
}
</script>
@endpush
@endsection
