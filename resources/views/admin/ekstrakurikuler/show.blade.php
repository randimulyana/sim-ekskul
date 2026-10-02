@extends('layouts.admin')

@section('page-title', 'Detail Ekstrakurikuler')

@section('content')
<div class="space-y-6">

    <!-- Breadcrumb & Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <nav class="flex items-center gap-1 text-xs text-slate-500 mb-2">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-slate-700">Dashboard</a>
                <svg class="w-3.5 h-3.5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <a href="{{ route('admin.ekstrakurikuler.index') }}" class="hover:text-slate-700">Ekstrakurikuler</a>
                <svg class="w-3.5 h-3.5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <span class="text-slate-800 font-semibold">{{ $extracurricular->name }}</span>
            </nav>
            <div class="flex items-center gap-3">
                <h1 class="text-2xl font-bold text-slate-900">{{ $extracurricular->name }}</h1>
                @if($extracurricular->is_active)
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                        Aktif
                    </span>
                @else
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-600">
                        Nonaktif
                    </span>
                @endif
            </div>
            <p class="text-xs text-slate-500 mt-1">Kategori: {{ $extracurricular->category ?: 'Umum' }}</p>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('admin.ekstrakurikuler.index') }}" class="px-4 py-2 border border-slate-200 text-slate-700 hover:bg-slate-50 text-xs font-semibold rounded-lg transition-colors">
                &larr; Kembali
            </a>
            <a href="{{ route('admin.ekstrakurikuler.edit', $extracurricular->id) }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-lg shadow-sm transition-colors">
                Edit Ekskul
            </a>
        </div>
    </div>

    <!-- Stats Row -->
    @php
    $regCount = $extracurricular->registrations->count();
    $acceptedCount = $extracurricular->registrations->where('status', 'accepted')->count();
    $pendingCount = $extracurricular->registrations->whereIn('status', ['submitted', 'reviewed'])->count();
    $rejectedCount = $extracurricular->registrations->whereIn('status', ['rejected', 'cancelled'])->count();
    $acceptedPct = $regCount > 0 ? round(($acceptedCount / $regCount) * 100) : 0;
    @endphp

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl border border-slate-200 p-4 shadow-sm">
            <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Total Pendaftar</span>
            <p class="text-2xl font-bold text-slate-900 mt-1">{{ $regCount }}</p>
            <span class="text-[11px] text-blue-600 font-medium">Kapasitas: {{ $extracurricular->quota ?: '-' }}</span>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 p-4 shadow-sm">
            <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Diterima</span>
            <p class="text-2xl font-bold text-emerald-600 mt-1">{{ $acceptedCount }}</p>
            <span class="text-[11px] text-emerald-700 font-medium">{{ $acceptedPct }}% dari pendaftar</span>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 p-4 shadow-sm">
            <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Menunggu Tinjauan</span>
            <p class="text-2xl font-bold text-amber-600 mt-1">{{ $pendingCount }}</p>
            <span class="text-[11px] text-amber-700 font-medium">Perlu verifikasi</span>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 p-4 shadow-sm">
            <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Ditolak / Batal</span>
            <p class="text-2xl font-bold text-red-600 mt-1">{{ $rejectedCount }}</p>
            <span class="text-[11px] text-slate-400 font-medium">Tidak terdaftar</span>
        </div>
    </div>

    <!-- Info Detail Card -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 space-y-4">
        <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Informasi Kegiatan</h3>
        <p class="text-xs text-slate-600 leading-relaxed">
            {{ $extracurricular->description ?: 'Belum ada deskripsi untuk ekstrakurikuler ini.' }}
        </p>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-2 text-xs">
            <div class="bg-slate-50 p-3 rounded-lg border border-slate-200/70">
                <span class="text-slate-400 block font-semibold uppercase text-[10px]">Jadwal Kegiatan</span>
                <span class="text-slate-800 font-bold mt-0.5 block">{{ $extracurricular->schedule ?: '-' }}</span>
            </div>
            <div class="bg-slate-50 p-3 rounded-lg border border-slate-200/70">
                <span class="text-slate-400 block font-semibold uppercase text-[10px]">Lokasi Latihan</span>
                <span class="text-slate-800 font-bold mt-0.5 block">{{ $extracurricular->location ?: '-' }}</span>
            </div>
            <div class="bg-slate-50 p-3 rounded-lg border border-slate-200/70">
                <span class="text-slate-400 block font-semibold uppercase text-[10px]">Pembina</span>
                <span class="text-slate-800 font-bold mt-0.5 block">{{ $extracurricular->coach_name ?: '-' }}</span>
            </div>
        </div>
    </div>

    <!-- Pendaftar List Table -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="text-sm font-bold text-slate-900">Daftar Pendaftar Ekskul Ini ({{ $regCount }})</h3>
                <p class="text-xs text-slate-500 mt-0.5">Siswa yang mengajukan pilihan pada ekstrakurikuler ini</p>
            </div>
            <a href="{{ route('admin.pendaftaran.index', ['ekskul' => $extracurricular->id]) }}" class="text-xs font-semibold text-blue-600 hover:text-blue-800">
                Buka Kelola Pendaftaran &rarr;
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-xs">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase tracking-wider text-[11px]">
                    <tr>
                        <th class="px-6 py-3 text-left font-semibold">Nama Siswa</th>
                        <th class="px-6 py-3 text-left font-semibold">NIS</th>
                        <th class="px-6 py-3 text-left font-semibold">Kelas</th>
                        <th class="px-6 py-3 text-left font-semibold">WhatsApp</th>
                        <th class="px-6 py-3 text-left font-semibold">Tanggal Daftar</th>
                        <th class="px-6 py-3 text-left font-semibold">Status</th>
                        <th class="px-6 py-3 text-right font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @php
                    $sc = [
                        'accepted'  => ['bg' => 'bg-emerald-100 text-emerald-800', 'label' => 'Diterima'],
                        'reviewed'  => ['bg' => 'bg-amber-100 text-amber-800',     'label' => 'Ditinjau'],
                        'submitted' => ['bg' => 'bg-blue-100 text-blue-800',       'label' => 'Terkirim'],
                        'rejected'  => ['bg' => 'bg-red-100 text-red-800',         'label' => 'Ditolak'],
                        'cancelled' => ['bg' => 'bg-slate-100 text-slate-800',     'label' => 'Dibatalkan'],
                    ];
                    @endphp
                    @forelse($extracurricular->registrations as $reg)
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="px-6 py-3.5 font-bold text-slate-900">{{ $reg->student->user->name ?? '-' }}</td>
                        <td class="px-6 py-3.5 font-mono text-slate-600">{{ $reg->student->nis ?? '-' }}</td>
                        <td class="px-6 py-3.5 text-slate-600">{{ $reg->student->class_name ?? '-' }}</td>
                        <td class="px-6 py-3.5 font-mono text-slate-600">{{ $reg->student->whatsapp ?: '-' }}</td>
                        <td class="px-6 py-3.5 text-slate-500">{{ $reg->created_at->translatedFormat('d M Y') }}</td>
                        <td class="px-6 py-3.5">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold {{ $sc[$reg->status]['bg'] ?? 'bg-slate-100 text-slate-800' }}">
                                {{ $sc[$reg->status]['label'] ?? ucfirst($reg->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-3.5 text-right">
                            <a href="{{ route('admin.pendaftaran.show', $reg->id) }}" class="text-blue-600 hover:text-blue-800 font-semibold hover:underline">
                                Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-slate-400">
                            Belum ada siswa yang mendaftar pada ekstrakurikuler ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
