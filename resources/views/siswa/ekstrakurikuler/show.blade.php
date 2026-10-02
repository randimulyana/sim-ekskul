@extends('layouts.student')

@section('title', 'Detail ' . $extracurricular->name)

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Back button & Breadcrumb -->
    <div>
        <a href="{{ route('siswa.ekstrakurikuler.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-slate-800 transition-colors mb-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Katalog
        </a>
    </div>

    <!-- Banner Unconfirmed info notice -->
    <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 flex items-start gap-3 text-amber-800">
        <svg class="w-5 h-5 text-amber-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
        <div class="text-xs">
            <span class="font-bold">[PERLU KONFIRMASI]</span> Rincian jadwal kegiatan, nama pembina, lokasi tepat, dan batas kuota merupakan data simulasi/placeholder dan akan diperbarui setelah keputusan resmi pihak SMK Negeri 3 Payakumbuh ditetapkan.
        </div>
    </div>

    <!-- Main Card -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <!-- Header Banner -->
        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 p-6 sm:p-8 text-white">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <span class="inline-block px-3 py-1 bg-white/20 backdrop-blur-sm rounded-full text-xs font-semibold uppercase tracking-wider text-blue-100 mb-2">
                        {{ $extracurricular->category ?? 'Umum' }}
                    </span>
                    <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">{{ $extracurricular->name }}</h1>
                    <p class="text-blue-100 text-sm mt-1">Ekstrakurikuler Resmi SMKN 3 Payakumbuh</p>
                </div>
                <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl px-4 py-3 text-center">
                    <p class="text-xs text-blue-200 uppercase font-medium">Status Pendaftaran</p>
                    <p class="text-base font-bold text-white mt-0.5">{{ $extracurricular->is_active ? 'Dibuka' : 'Ditutup' }}</p>
                </div>
            </div>
        </div>

        <div class="p-6 sm:p-8 space-y-8">
            <!-- Deskripsi -->
            <div>
                <h2 class="text-base font-bold text-slate-900 mb-2">Tentang Ekstrakurikuler</h2>
                <p class="text-sm text-slate-600 leading-relaxed">{{ $extracurricular->description ?? 'Deskripsi belum tersedia.' }}</p>
            </div>

            <!-- Program & Tujuan -->
            <div>
                <h2 class="text-base font-bold text-slate-900 mb-2">Tujuan & Manfaat</h2>
                <ul class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-sm text-slate-600">
                    <li class="flex items-start gap-2">
                        <svg class="w-4 h-4 text-emerald-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Meningkatkan keterampilan khusus siswa di bidang {{ strtolower($extracurricular->category ?? 'ekstrakurikuler') }}</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-4 h-4 text-emerald-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Membina kerja sama tim, kedisiplinan, dan rasa tanggung jawab</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-4 h-4 text-emerald-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Menyalurkan minat dan bakat positif di luar jam pelajaran sekolah</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-4 h-4 text-emerald-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Mempersiapkan perwakilan sekolah untuk kegiatan dan kompetisi</span>
                    </li>
                </ul>
            </div>

            <!-- Info Grid -->
            <div>
                <h2 class="text-base font-bold text-slate-900 mb-3">Informasi Kegiatan</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="bg-slate-50 border border-slate-200/70 rounded-xl p-4">
                        <div class="flex items-center gap-2.5 text-slate-500 mb-1">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span class="text-xs font-semibold uppercase">Jadwal Latihan</span>
                        </div>
                        <p class="text-sm font-semibold text-slate-800">{{ $extracurricular->schedule_info ?: 'Jadwal belum ditetapkan [PERLU KONFIRMASI]' }}</p>
                    </div>

                    <div class="bg-slate-50 border border-slate-200/70 rounded-xl p-4">
                        <div class="flex items-center gap-2.5 text-slate-500 mb-1">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span class="text-xs font-semibold uppercase">Lokasi Kegiatan</span>
                        </div>
                        <p class="text-sm font-semibold text-slate-800">{{ $extracurricular->location_info ?: 'Lokasi belum ditentukan [PERLU KONFIRMASI]' }}</p>
                    </div>

                    <div class="bg-slate-50 border border-slate-200/70 rounded-xl p-4">
                        <div class="flex items-center gap-2.5 text-slate-500 mb-1">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            <span class="text-xs font-semibold uppercase">Pembina Ekskul</span>
                        </div>
                        <p class="text-sm font-semibold text-slate-800">{{ $extracurricular->coach_name ?: 'Pembina belum ditentukan [PERLU KONFIRMASI]' }}</p>
                    </div>

                    <div class="bg-slate-50 border border-slate-200/70 rounded-xl p-4">
                        <div class="flex items-center gap-2.5 text-slate-500 mb-1">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span class="text-xs font-semibold uppercase">Pendaftar / Kuota</span>
                        </div>
                        <p class="text-sm font-semibold text-slate-800">
                            {{ $extracurricular->registrations_count ?? 0 }} / {{ $extracurricular->quota ? $extracurricular->quota . ' siswa' : 'Tidak dibatasi' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Action Section -->
            <div class="pt-4 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div>
                    <p class="text-xs font-semibold text-slate-700">Tertarik bergabung dengan {{ $extracurricular->name }}?</p>
                    <p class="text-xs text-slate-500">Pendaftaran dibuka untuk seluruh siswa baru TP 2026/2027.</p>
                </div>
                <a href="{{ url('/siswa/pendaftaran') }}?ekskul_id={{ $extracurricular->id }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-sm transition-colors text-sm">
                    <span>Pilih Ekstrakurikuler Ini</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
