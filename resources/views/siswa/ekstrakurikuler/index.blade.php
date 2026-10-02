@extends('layouts.student')

@section('title', 'Katalog Ekstrakurikuler')

@section('content')
{{-- DATA DEMO: data di halaman ini adalah contoh berdasarkan observasi awal, bukan daftar resmi final sekolah --}}

<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Katalog Ekstrakurikuler</h1>
            <p class="text-sm text-slate-500 mt-1">Eksplorasi kegiatan ekstrakurikuler di SMK Negeri 3 Payakumbuh</p>
        </div>
        <div class="inline-flex items-center gap-2 bg-amber-50 border border-amber-200 px-3 py-1.5 rounded-lg text-xs text-amber-800">
            <svg class="w-4 h-4 text-amber-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>Daftar ekskul demo berdasarkan observasi awal</span>
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
            <button onclick="setCategory('Organisasi')" class="cat-btn px-3.5 py-1.5 rounded-lg text-xs font-semibold bg-slate-100 text-slate-700 hover:bg-slate-200 transition-colors">Organisasi</button>
            <button onclick="setCategory('Seni & Budaya')" class="cat-btn px-3.5 py-1.5 rounded-lg text-xs font-semibold bg-slate-100 text-slate-700 hover:bg-slate-200 transition-colors">Seni & Budaya</button>
            <button onclick="setCategory('Bela Diri')" class="cat-btn px-3.5 py-1.5 rounded-lg text-xs font-semibold bg-slate-100 text-slate-700 hover:bg-slate-200 transition-colors">Bela Diri</button>
            <button onclick="setCategory('Akademik')" class="cat-btn px-3.5 py-1.5 rounded-lg text-xs font-semibold bg-slate-100 text-slate-700 hover:bg-slate-200 transition-colors">Akademik</button>
            <button onclick="setCategory('Keagamaan')" class="cat-btn px-3.5 py-1.5 rounded-lg text-xs font-semibold bg-slate-100 text-slate-700 hover:bg-slate-200 transition-colors">Keagamaan</button>
        </div>
    </div>

    <!-- Ekskul Cards Grid -->
    @php
    // DATA DEMO: data observasi awal
    $ekskuls = [
        [
            'id' => 1,
            'nama' => 'PASKIBRAKA',
            'kategori' => 'Organisasi',
            'deskripsi' => 'Pasukan Pengibar Bendera Pusaka yang melatih kedisiplinan tingkat tinggi, ketahanan fisik, kepemimpinan, dan rasa cinta tanah air.',
            'peserta' => 48,
            'badge' => 'bg-red-50 text-red-700 border-red-200',
            'icon' => '🚩'
        ],
        [
            'id' => 2,
            'nama' => 'PRAMUKA',
            'kategori' => 'Organisasi',
            'deskripsi' => 'Gerakan kepanduan yang menumbuhkan kemandirian, ketrampilan hidup di alam bebas, jiwa sosial, kepemimpinan, dan kerja sama tim.',
            'peserta' => 62,
            'badge' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
            'icon' => '⚜️'
        ],
        [
            'id' => 3,
            'nama' => 'PIK-R',
            'kategori' => 'Organisasi',
            'deskripsi' => 'Pusat Informasi dan Konseling Remaja untuk pendampingan konseling sebaya, pembinaan kesehatan reproduksi, dan keterampilan hidup remaja.',
            'peserta' => 25,
            'badge' => 'bg-blue-50 text-blue-700 border-blue-200',
            'icon' => '🤝'
        ],
        [
            'id' => 4,
            'nama' => 'SILAT TRADISI',
            'kategori' => 'Bela Diri',
            'deskripsi' => 'Pelestarian seni bela diri silat Minangkabau yang memadukan olah fisik ketangkasan, pembentukan karakter sopan santun, dan pertahanan diri.',
            'peserta' => 30,
            'badge' => 'bg-amber-50 text-amber-700 border-amber-200',
            'icon' => '🥋'
        ],
        [
            'id' => 5,
            'nama' => 'RANDAI',
            'kategori' => 'Seni & Budaya',
            'deskripsi' => 'Kesenian teater tradisional khas Minangkabau yang memadukan gerakan tari silat, dendang pantun, dan dialog lakon cerita rakyat.',
            'peserta' => 22,
            'badge' => 'bg-purple-50 text-purple-700 border-purple-200',
            'icon' => '🎭'
        ],
        [
            'id' => 6,
            'nama' => 'MARCHING BAND',
            'kategori' => 'Seni & Budaya',
            'deskripsi' => 'Korps musik dinamis yang menggabungkan instrumen tiup, perkusi, dan aksi formasi visual koreografi spektakuler dalam pertunjukan akbar.',
            'peserta' => 38,
            'badge' => 'bg-purple-50 text-purple-700 border-purple-200',
            'icon' => '🎺'
        ],
        [
            'id' => 7,
            'nama' => 'MODELLING',
            'kategori' => 'Seni & Budaya',
            'deskripsi' => 'Pelatihan tata busana, peragaan busana catwalk, pengembangan postur tubuh, serta kepercayaan diri tampil di ruang publik.',
            'peserta' => 24,
            'badge' => 'bg-pink-50 text-pink-700 border-pink-200',
            'icon' => '✨'
        ],
        [
            'id' => 8,
            'nama' => 'KESENIAN',
            'kategori' => 'Seni & Budaya',
            'deskripsi' => 'Wadah eksplorasi seni rupa, seni tari kreasi daerah, dan kriya kreatif untuk mengembangkan ekspresi estetika siswa SMK.',
            'peserta' => 19,
            'badge' => 'bg-purple-50 text-purple-700 border-purple-200',
            'icon' => '🎨'
        ],
        [
            'id' => 9,
            'nama' => 'PADUAN SUARA',
            'kategori' => 'Seni & Budaya',
            'deskripsi' => 'Pelatihan teknik vokal kelompok, harmonisasi nada lagu nasional, daerah, maupun kontemporer untuk pengisi upacara dan lomba.',
            'peserta' => 32,
            'badge' => 'bg-purple-50 text-purple-700 border-purple-200',
            'icon' => '🎵'
        ],
        [
            'id' => 10,
            'nama' => 'ENGLISH CLUB',
            'kategori' => 'Akademik',
            'deskripsi' => 'Klub percakapan aktif bahasa Inggris, debat, story telling, dan penyiapan kompetisi bahasa asing di tingkat daerah maupun nasional.',
            'peserta' => 28,
            'badge' => 'bg-indigo-50 text-indigo-700 border-indigo-200',
            'icon' => '🌐'
        ],
        [
            'id' => 11,
            'nama' => 'JAPANESE CLUB',
            'kategori' => 'Akademik',
            'deskripsi' => 'Pengenalan bahasa Jepang dasar (Hiragana/Katakana), kaiwa (percakapan), dan pengenalan kebudayaan populer serta etos kerja Jepang.',
            'peserta' => 18,
            'badge' => 'bg-indigo-50 text-indigo-700 border-indigo-200',
            'icon' => '🌸'
        ],
        [
            'id' => 12,
            'nama' => 'TAHFIDZ',
            'kategori' => 'Keagamaan',
            'deskripsi' => 'Program hafalan Al-Qur\'an intensif, bimbingan tajwid makhraj, dan pembinaan akhlak mulia kepribadian islami sehari-hari.',
            'peserta' => 26,
            'badge' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
            'icon' => '📖'
        ],
    ];
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5" id="ekskulGrid">
        @foreach($ekskuls as $item)
        <div class="ekskul-card bg-white rounded-xl border border-slate-200 shadow-sm hover:shadow-md hover:border-blue-200 transition-all p-5 flex flex-col justify-between"
             data-name="{{ strtolower($item['nama']) }}"
             data-category="{{ $item['kategori'] }}">
            <div>
                <div class="flex items-start justify-between gap-3 mb-3">
                    <span class="text-2xl p-2 bg-slate-50 rounded-lg">{{ $item['icon'] }}</span>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $item['badge'] }}">
                        {{ $item['kategori'] }}
                    </span>
                </div>
                <h3 class="text-base font-bold text-slate-900 group-hover:text-blue-600 transition-colors">{{ $item['nama'] }}</h3>
                <p class="text-xs text-slate-500 mt-2 leading-relaxed line-clamp-3">{{ $item['deskripsi'] }}</p>
            </div>

            <div class="mt-5 pt-4 border-t border-slate-100 flex items-center justify-between">
                <div class="flex items-center gap-1.5 text-xs text-slate-500">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span>{{ $item['peserta'] }} peserta</span>
                </div>
                <a href="/siswa/ekstrakurikuler/{{ $item['id'] }}" class="inline-flex items-center gap-1 text-xs font-semibold text-blue-600 hover:text-blue-800">
                    Lihat Detail
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>
        @endforeach
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
