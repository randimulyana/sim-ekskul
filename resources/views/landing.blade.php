<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SRPE — Sistem Rekomendasi Pemilihan Ekstrakurikuler | SMKN 3 Payakumbuh</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white font-sans antialiased text-slate-900">

<!-- ===================== NAVBAR ===================== -->
<header class="sticky top-0 z-50 bg-white/95 backdrop-blur border-b border-slate-200 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <a href="/" class="flex items-center gap-3">
                <div class="w-9 h-9 bg-blue-600 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-slate-900 leading-tight">SRPE</p>
                    <p class="text-xs text-slate-500 leading-tight">SMKN 3 Payakumbuh</p>
                </div>
            </a>

            <!-- Desktop Nav Links -->
            <nav class="hidden md:flex items-center gap-6">
                <a href="/siswa/ekstrakurikuler" class="text-sm font-medium text-slate-600 hover:text-blue-700 transition-colors">Katalog Ekskul</a>
                <a href="/login" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition-colors shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                    Masuk
                </a>
            </nav>

            <!-- Mobile menu button -->
            <button id="mobileMenuBtn" onclick="toggleLandingMenu()" class="md:hidden p-2 rounded-lg text-slate-600 hover:bg-slate-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="landingMobileMenu" class="hidden md:hidden border-t border-slate-100 bg-white px-4 py-3 space-y-1">
        <a href="/siswa/ekstrakurikuler" class="block px-3 py-2 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-50">Katalog Ekskul</a>
        <a href="/login" class="block px-3 py-2 rounded-lg text-sm font-medium text-blue-700 bg-blue-50">Masuk ke Sistem</a>
    </div>
</header>

<!-- ===================== HERO ===================== -->
<section class="relative overflow-hidden bg-gradient-to-br from-blue-700 via-blue-600 to-indigo-700 text-white">
    <!-- Background decorative circles -->
    <div class="absolute -top-32 -right-32 w-96 h-96 bg-blue-500 rounded-full opacity-20 blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-20 -left-20 w-72 h-72 bg-indigo-500 rounded-full opacity-20 blur-3xl pointer-events-none"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 md:py-28 lg:py-32">
        <div class="max-w-3xl mx-auto text-center">
            <!-- Badge -->
            <div class="inline-flex items-center gap-2 bg-white/10 border border-white/20 rounded-full px-4 py-1.5 text-sm font-medium text-blue-100 mb-6">
                <span class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></span>
                SMK Negeri 3 Payakumbuh — Tahun Pelajaran 2026/2027
            </div>

            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold leading-tight tracking-tight mb-6">
                Temukan Ekskul
                <span class="text-blue-200"> Terbaik</span>
                <br>untuk Kamu
            </h1>
            <p class="text-lg sm:text-xl text-blue-100 leading-relaxed mb-10 max-w-2xl mx-auto">
                Sistem rekomendasi cerdas yang membantu siswa menemukan ekstrakurikuler yang paling sesuai dengan minat, karakteristik, dan preferensi belajar masing-masing.
            </p>

            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <a href="/login" class="inline-flex items-center justify-center gap-2 px-7 py-3.5 bg-white text-blue-700 font-bold text-base rounded-xl shadow-lg hover:bg-blue-50 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                    Mulai Rekomendasi
                </a>
                <a href="/siswa/ekstrakurikuler" class="inline-flex items-center justify-center gap-2 px-7 py-3.5 bg-white/10 border border-white/30 text-white font-semibold text-base rounded-xl hover:bg-white/20 transition-colors backdrop-blur">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    Lihat Ekskul
                </a>
            </div>

            <!-- Stats bar -->
            <div class="mt-14 grid grid-cols-3 gap-6 border-t border-white/20 pt-10">
                <!-- DATA DEMO -->
                <div>
                    <p class="text-3xl font-extrabold text-white">12</p>
                    <p class="text-sm text-blue-200 mt-1">Ekstrakurikuler Aktif</p>
                </div>
                <div>
                    <p class="text-3xl font-extrabold text-white">3</p>
                    <p class="text-sm text-blue-200 mt-1">Jurusan</p>
                </div>
                <div>
                    <p class="text-3xl font-extrabold text-white">98%</p>
                    <p class="text-sm text-blue-200 mt-1">Kecocokan Akurasi</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===================== HOW IT WORKS ===================== -->
<section class="py-20 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14">
            <p class="text-sm font-semibold text-blue-600 uppercase tracking-widest mb-2">Cara Kerja</p>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900">Tiga Langkah Mudah</h2>
            <p class="mt-3 text-slate-500 text-lg max-w-xl mx-auto">Dari kuesioner hingga mendaftar ekskul pilihan — semuanya mudah dan cepat.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative">
            <!-- Connector line (desktop) -->
            <div class="hidden md:block absolute top-12 left-1/4 right-1/4 h-0.5 bg-blue-100 z-0"></div>

            <!-- Step 1 -->
            <div class="relative bg-white rounded-2xl shadow-sm border border-slate-200 p-8 text-center z-10">
                <div class="w-16 h-16 bg-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-5 shadow-md">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <div class="absolute top-6 left-6 w-7 h-7 bg-blue-100 rounded-full flex items-center justify-center">
                    <span class="text-blue-700 text-xs font-bold">1</span>
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-2">Isi Kuesioner</h3>
                <p class="text-slate-500 text-sm leading-relaxed">Jawab pertanyaan singkat tentang minat, gaya belajar, dan karakteristik dirimu. Hanya butuh 5–10 menit.</p>
            </div>

            <!-- Step 2 -->
            <div class="relative bg-white rounded-2xl shadow-sm border border-slate-200 p-8 text-center z-10">
                <div class="w-16 h-16 bg-emerald-500 rounded-2xl flex items-center justify-center mx-auto mb-5 shadow-md">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/>
                    </svg>
                </div>
                <div class="absolute top-6 left-6 w-7 h-7 bg-emerald-100 rounded-full flex items-center justify-center">
                    <span class="text-emerald-700 text-xs font-bold">2</span>
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-2">Dapatkan Rekomendasi</h3>
                <p class="text-slate-500 text-sm leading-relaxed">Sistem menganalisis jawabanmu dan menghasilkan rekomendasi ekskul berdasarkan skor kecocokan.</p>
            </div>

            <!-- Step 3 -->
            <div class="relative bg-white rounded-2xl shadow-sm border border-slate-200 p-8 text-center z-10">
                <div class="w-16 h-16 bg-indigo-500 rounded-2xl flex items-center justify-center mx-auto mb-5 shadow-md">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <div class="absolute top-6 left-6 w-7 h-7 bg-indigo-100 rounded-full flex items-center justify-center">
                    <span class="text-indigo-700 text-xs font-bold">3</span>
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-2">Daftar Ekskul</h3>
                <p class="text-slate-500 text-sm leading-relaxed">Pilih ekskul yang kamu sukai dari daftar rekomendasi dan selesaikan pendaftaran langsung di sistem.</p>
            </div>
        </div>
    </div>
</section>

<!-- ===================== EKSKUL GRID ===================== -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14">
            <p class="text-sm font-semibold text-blue-600 uppercase tracking-widest mb-2">Pilihan Ekskul</p>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900">Ekstrakurikuler Unggulan</h2>
            <p class="mt-3 text-slate-500 text-lg max-w-xl mx-auto">Beragam pilihan ekskul untuk mengembangkan potensimu di SMKN 3 Payakumbuh.</p>
        </div>

        <!-- DATA DEMO: ini adalah data contoh untuk keperluan pengembangan -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

            <!-- Card 1: PASKIBRAKA -->
            <div class="bg-slate-50 rounded-2xl border border-slate-200 p-6 hover:shadow-md transition-shadow group">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"/></svg>
                    </div>
                    <span class="px-2.5 py-1 bg-red-50 text-red-700 text-xs font-semibold rounded-full border border-red-100">Organisasi</span>
                </div>
                <h3 class="text-base font-bold text-slate-900 mb-1.5 group-hover:text-blue-700 transition-colors">PASKIBRAKA</h3>
                <p class="text-sm text-slate-500 mb-4 leading-relaxed">Latihan baris-berbaris dan pengibaran bendera. Melatih kedisiplinan, tanggung jawab, dan jiwa nasionalisme.</p>
                <div class="flex items-center gap-2 text-xs text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0"/></svg>
                    <span>38 peserta aktif</span>
                </div>
            </div>

            <!-- Card 2: PRAMUKA -->
            <div class="bg-slate-50 rounded-2xl border border-slate-200 p-6 hover:shadow-md transition-shadow group">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                    </div>
                    <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 text-xs font-semibold rounded-full border border-emerald-100">Organisasi</span>
                </div>
                <h3 class="text-base font-bold text-slate-900 mb-1.5 group-hover:text-blue-700 transition-colors">PRAMUKA</h3>
                <p class="text-sm text-slate-500 mb-4 leading-relaxed">Kegiatan kepanduan yang mengembangkan keterampilan hidup, kepemimpinan, dan kerja sama tim.</p>
                <div class="flex items-center gap-2 text-xs text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0"/></svg>
                    <span>52 peserta aktif</span>
                </div>
            </div>

            <!-- Card 3: MARCHING BAND -->
            <div class="bg-slate-50 rounded-2xl border border-slate-200 p-6 hover:shadow-md transition-shadow group">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
                    </div>
                    <span class="px-2.5 py-1 bg-purple-50 text-purple-700 text-xs font-semibold rounded-full border border-purple-100">Seni & Budaya</span>
                </div>
                <h3 class="text-base font-bold text-slate-900 mb-1.5 group-hover:text-blue-700 transition-colors">MARCHING BAND</h3>
                <p class="text-sm text-slate-500 mb-4 leading-relaxed">Permainan alat musik secara bersama-sama sambil berbaris. Melatih kreativitas, ritme, dan koordinasi.</p>
                <div class="flex items-center gap-2 text-xs text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0"/></svg>
                    <span>29 peserta aktif</span>
                </div>
            </div>

            <!-- Card 4: SILAT TRADISI -->
            <div class="bg-slate-50 rounded-2xl border border-slate-200 p-6 hover:shadow-md transition-shadow group">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <span class="px-2.5 py-1 bg-orange-50 text-orange-700 text-xs font-semibold rounded-full border border-orange-100">Bela Diri</span>
                </div>
                <h3 class="text-base font-bold text-slate-900 mb-1.5 group-hover:text-blue-700 transition-colors">SILAT TRADISI</h3>
                <p class="text-sm text-slate-500 mb-4 leading-relaxed">Seni bela diri tradisional Minangkabau. Membangun kekuatan fisik, mental, dan pelestarian budaya lokal.</p>
                <div class="flex items-center gap-2 text-xs text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0"/></svg>
                    <span>24 peserta aktif</span>
                </div>
            </div>

            <!-- Card 5: ENGLISH CLUB -->
            <div class="bg-slate-50 rounded-2xl border border-slate-200 p-6 hover:shadow-md transition-shadow group">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/></svg>
                    </div>
                    <span class="px-2.5 py-1 bg-blue-50 text-blue-700 text-xs font-semibold rounded-full border border-blue-100">Akademik</span>
                </div>
                <h3 class="text-base font-bold text-slate-900 mb-1.5 group-hover:text-blue-700 transition-colors">ENGLISH CLUB</h3>
                <p class="text-sm text-slate-500 mb-4 leading-relaxed">Komunitas belajar bahasa Inggris melalui percakapan, debat, storytelling, dan aktivitas menyenangkan lainnya.</p>
                <div class="flex items-center gap-2 text-xs text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0"/></svg>
                    <span>31 peserta aktif</span>
                </div>
            </div>

            <!-- Card 6: TAHFIDZ -->
            <div class="bg-slate-50 rounded-2xl border border-slate-200 p-6 hover:shadow-md transition-shadow group">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-12 h-12 bg-teal-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    </div>
                    <span class="px-2.5 py-1 bg-teal-50 text-teal-700 text-xs font-semibold rounded-full border border-teal-100">Keagamaan</span>
                </div>
                <h3 class="text-base font-bold text-slate-900 mb-1.5 group-hover:text-blue-700 transition-colors">TAHFIDZ</h3>
                <p class="text-sm text-slate-500 mb-4 leading-relaxed">Program menghafal Al-Quran dengan bimbingan guru yang berpengalaman. Memperkuat spiritualitas dan karakter.</p>
                <div class="flex items-center gap-2 text-xs text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0"/></svg>
                    <span>27 peserta aktif</span>
                </div>
            </div>
        </div>

        <div class="text-center mt-10">
            <a href="/siswa/ekstrakurikuler" class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white font-semibold text-sm rounded-xl hover:bg-blue-700 transition-colors shadow-sm">
                Lihat Semua Ekskul
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>
    </div>
</section>

<!-- ===================== CTA BANNER ===================== -->
<section class="py-16 bg-blue-600">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-2xl sm:text-3xl font-extrabold text-white mb-4">Siap Menemukan Ekskul yang Tepat?</h2>
        <p class="text-blue-100 text-base mb-8 max-w-xl mx-auto">Masuk ke sistem dan isi kuesioner singkat untuk mendapatkan rekomendasi ekskul yang personal untukmu.</p>
        <a href="/login" class="inline-flex items-center gap-2 px-8 py-3.5 bg-white text-blue-700 font-bold text-base rounded-xl shadow-lg hover:bg-blue-50 transition-colors">
            Mulai Sekarang — Gratis
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
        </a>
    </div>
</section>

<!-- ===================== FOOTER ===================== -->
<footer class="bg-slate-900 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
            <!-- Brand -->
            <div>
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-9 h-9 bg-blue-600 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    </div>
                    <div>
                        <p class="font-bold text-white text-sm">SRPE</p>
                        <p class="text-xs text-slate-400">Sistem Rekomendasi Pemilihan Ekstrakurikuler</p>
                    </div>
                </div>
                <p class="text-slate-400 text-sm leading-relaxed">Membantu siswa menemukan ekstrakurikuler yang paling sesuai dengan diri mereka melalui pendekatan berbasis data.</p>
            </div>

            <!-- School Info -->
            <div>
                <h4 class="text-sm font-semibold text-white mb-4 uppercase tracking-wider">Informasi Sekolah</h4>
                <ul class="space-y-2.5 text-sm text-slate-400">
                    <li class="flex items-start gap-2">
                        <svg class="w-4 h-4 mt-0.5 flex-shrink-0 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        SMK Negeri 3 Payakumbuh
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-4 h-4 mt-0.5 flex-shrink-0 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Payakumbuh, Sumatera Barat
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-4 h-4 mt-0.5 flex-shrink-0 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Tahun Pelajaran 2026/2027
                    </li>
                </ul>
            </div>

            <!-- Quick Links -->
            <div>
                <h4 class="text-sm font-semibold text-white mb-4 uppercase tracking-wider">Tautan Cepat</h4>
                <ul class="space-y-2.5 text-sm text-slate-400">
                    <li><a href="/siswa/ekstrakurikuler" class="hover:text-white transition-colors">Katalog Ekskul</a></li>
                    <li><a href="/login" class="hover:text-white transition-colors">Login Siswa</a></li>
                    <li><a href="/siswa/kuesioner" class="hover:text-white transition-colors">Kuesioner</a></li>
                </ul>
            </div>
        </div>

        <div class="mt-12 pt-6 border-t border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-500">
            <p>© {{ date('Y') }} SRPE — SMK Negeri 3 Payakumbuh. Hak cipta dilindungi.</p>
            <p class="text-amber-500">⚠ Sistem ini masih dalam tahap pengembangan. Data yang ditampilkan adalah data demo.</p>
        </div>
    </div>
</footer>

<script>
function toggleLandingMenu() {
    document.getElementById('landingMobileMenu').classList.toggle('hidden');
}
</script>
</body>
</html>
