@extends('layouts.admin')

@section('page-title', 'Detail Pendaftaran Siswa')

@section('content')
<div class="max-w-4xl space-y-6">

    <!-- Breadcrumb & Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <nav class="flex items-center gap-1 text-xs text-slate-500 mb-2">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-slate-700">Dashboard</a>
                <svg class="w-3.5 h-3.5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <a href="{{ route('admin.pendaftaran.index') }}" class="hover:text-slate-700">Pendaftaran</a>
                <svg class="w-3.5 h-3.5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <span class="text-slate-800 font-semibold">REG-{{ str_pad($registration->id, 4, '0', STR_PAD_LEFT) }}</span>
            </nav>
            <div class="flex items-center gap-3">
                <h1 class="text-2xl font-bold text-slate-900">Pendaftaran: {{ $registration->student->user->name ?? 'Siswa' }}</h1>
                @php
                $statusBadges = [
                    'accepted'  => ['bg' => 'bg-emerald-100 text-emerald-800', 'label' => 'Diterima'],
                    'reviewed'  => ['bg' => 'bg-amber-100 text-amber-800',     'label' => 'Ditinjau'],
                    'submitted' => ['bg' => 'bg-blue-100 text-blue-800',       'label' => 'Terkirim'],
                    'rejected'  => ['bg' => 'bg-red-100 text-red-800',         'label' => 'Ditolak'],
                    'cancelled' => ['bg' => 'bg-slate-100 text-slate-800',     'label' => 'Dibatalkan'],
                ];
                $sb = $statusBadges[$registration->status] ?? ['bg' => 'bg-slate-100 text-slate-700', 'label' => ucfirst($registration->status)];
                @endphp
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $sb['bg'] }}">
                    {{ $sb['label'] }}
                </span>
            </div>
            <p class="text-xs text-slate-500 mt-1">
                Nomor Registrasi: <span class="font-mono font-bold text-slate-700">REG-{{ str_pad($registration->id, 4, '0', STR_PAD_LEFT) }}</span> &middot; Masuk pada {{ $registration->created_at->translatedFormat('d M Y, H:i') }} WIB
            </p>
        </div>

        <a href="{{ route('admin.pendaftaran.index') }}" class="self-start sm:self-auto px-4 py-2 border border-slate-200 text-slate-700 hover:bg-slate-50 text-xs font-semibold rounded-lg transition-colors">
            &larr; Kembali ke Daftar
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Left 2 Cols: Main Info -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Card 1: Ekskul Pilihan -->
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-4">Pilihan Ekstrakurikuler</h3>
                <div class="flex items-start gap-4 p-4 rounded-xl border border-blue-200 bg-blue-50/40">
                    <span class="text-3xl p-2 bg-white rounded-xl border border-blue-100 shadow-xs">🚩</span>
                    <div class="flex-1">
                        <div class="flex items-center gap-2">
                            <h4 class="text-base font-bold text-slate-900">{{ $registration->extracurricular->name ?? '-' }}</h4>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-blue-100 text-blue-700">
                                {{ $registration->extracurricular->category ?? 'Umum' }}
                            </span>
                        </div>
                        <p class="text-xs text-slate-600 mt-1">{{ $registration->extracurricular->description ?: 'Tidak ada deskripsi.' }}</p>

                        @php
                        $recItem = $registration->student?->recommendations?->first()?->items?->firstWhere('extracurricular_id', $registration->extracurricular_id);
                        @endphp
                        @if($recItem)
                            <p class="text-xs text-blue-700 font-semibold mt-2">
                                ✓ Sesuai Rekomendasi Kuesioner (Peringkat #{{ $recItem->rank }} &middot; Skor Kecocokan: {{ round($recItem->score * 100) }}%)
                            </p>
                        @endif
                    </div>
                </div>

                <!-- Catatan / Motivasi Siswa -->
                <div class="mt-4 pt-4 border-t border-slate-100">
                    <span class="text-[11px] font-semibold text-slate-500 block uppercase">Catatan / Motivasi:</span>
                    <p class="text-xs text-slate-700 italic mt-1 bg-slate-50 p-3 rounded-lg border border-slate-200/70">
                        {{ $registration->notes ?: 'Pendaftaran diajukan oleh siswa sesuai minat dan pertimbangan mandiri.' }}
                    </p>
                </div>
            </div>

            <!-- Card 2: Identitas Siswa -->
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-4">Informasi Siswa</h3>
                <div class="grid grid-cols-2 gap-4 text-xs">
                    <div>
                        <span class="text-slate-400 block font-semibold">Nama Lengkap</span>
                        <span class="text-slate-900 font-bold text-sm block mt-0.5">{{ $registration->student->user->name ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block font-semibold">NIS</span>
                        <span class="text-slate-900 font-mono font-bold block mt-0.5">{{ $registration->student->nis ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block font-semibold">Kelas</span>
                        <span class="text-slate-900 font-bold block mt-0.5">{{ $registration->student->class_name ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block font-semibold">Nomor WhatsApp</span>
                        <span class="text-slate-900 font-mono font-bold block mt-0.5">{{ $registration->student->whatsapp ?: '-' }}</span>
                    </div>
                    <div class="col-span-2">
                        <span class="text-slate-400 block font-semibold">Email Siswa</span>
                        <span class="text-slate-900 block mt-0.5">{{ $registration->student->user->email ?? '-' }}</span>
                    </div>
                </div>
            </div>

            <!-- Card 3: Action Form -->
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-4">Tindakan Admin</h3>

                <form method="POST" action="{{ route('admin.pendaftaran.update-status', $registration->id) }}" class="space-y-4">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Catatan Verifikasi Admin (Opsional)</label>
                        <textarea
                            name="notes"
                            rows="3"
                            class="block w-full rounded-lg border border-slate-200 p-3 text-xs text-slate-900 focus:outline-none focus:ring-1 focus:ring-blue-500 resize-none"
                            placeholder="Tuliskan catatan tindak lanjut atau alasan persetujuan/penolakan..."
                        >{{ old('notes', $registration->notes) }}</textarea>
                    </div>

                    <div class="flex flex-wrap items-center gap-3 pt-2">
                        <button type="submit" name="status" value="accepted" class="px-5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-lg shadow-sm transition-colors">
                            ✓ Terima Pendaftaran
                        </button>
                        <button type="submit" name="status" value="rejected" class="px-5 py-2 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-lg shadow-sm transition-colors">
                            ✕ Tolak Pengajuan
                        </button>
                        <button type="submit" name="status" value="reviewed" class="px-4 py-2 border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-semibold rounded-lg transition-colors">
                            Atur ke Status Ditinjau
                        </button>
                    </div>
                </form>
            </div>

        </div>

        <!-- Right 1 Col: Status & Timeline -->
        <div class="space-y-6">

            <!-- Status Card -->
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-4">Timeline Verifikasi</h3>

                <div class="space-y-5 relative pl-6 before:content-[''] before:absolute before:left-2.5 before:top-2 before:bottom-2 before:w-0.5 before:bg-slate-200">
                    <!-- 1. Terkirim -->
                    <div class="relative">
                        <span class="absolute -left-6 top-0.5 w-5 h-5 rounded-full bg-emerald-500 text-white flex items-center justify-center text-[10px] ring-4 ring-white">
                            ✓
                        </span>
                        <div>
                            <p class="text-xs font-bold text-slate-800">Terkirim oleh Siswa</p>
                            <p class="text-[11px] text-slate-400">{{ $registration->created_at->translatedFormat('d M Y, H:i') }} WIB</p>
                        </div>
                    </div>

                    <!-- 2. Ditinjau -->
                    <div class="relative">
                        @if(in_array($registration->status, ['reviewed', 'accepted', 'rejected'], true))
                            <span class="absolute -left-6 top-0.5 w-5 h-5 rounded-full bg-amber-500 text-white flex items-center justify-center text-[10px] ring-4 ring-white">
                                ●
                            </span>
                            <div>
                                <p class="text-xs font-bold text-amber-800">Ditinjau Admin</p>
                                <p class="text-[11px] text-slate-400">Dalam proses pemeriksaan</p>
                            </div>
                        @else
                            <span class="absolute -left-6 top-0.5 w-5 h-5 rounded-full bg-slate-200 text-slate-400 flex items-center justify-center text-[10px] ring-4 ring-white">
                                ○
                            </span>
                            <div>
                                <p class="text-xs font-semibold text-slate-400">Pemeriksaan Dokumen</p>
                                <p class="text-[11px] text-slate-400">Menunggu tinjauan</p>
                            </div>
                        @endif
                    </div>

                    <!-- 3. Penetapan Akhir -->
                    <div class="relative">
                        @if($registration->status === 'accepted')
                            <span class="absolute -left-6 top-0.5 w-5 h-5 rounded-full bg-emerald-500 text-white flex items-center justify-center text-[10px] ring-4 ring-white">
                                ✓
                            </span>
                            <div>
                                <p class="text-xs font-bold text-emerald-800">Diterima</p>
                                <p class="text-[11px] text-slate-400">Pendaftaran disetujui</p>
                            </div>
                        @elseif($registration->status === 'rejected')
                            <span class="absolute -left-6 top-0.5 w-5 h-5 rounded-full bg-red-500 text-white flex items-center justify-center text-[10px] ring-4 ring-white">
                                ✕
                            </span>
                            <div>
                                <p class="text-xs font-bold text-red-800">Ditolak</p>
                                <p class="text-[11px] text-slate-400">Pengajuan ditolak</p>
                            </div>
                        @else
                            <span class="absolute -left-6 top-0.5 w-5 h-5 rounded-full bg-slate-200 text-slate-400 flex items-center justify-center text-[10px] ring-4 ring-white">
                                ○
                            </span>
                            <div>
                                <p class="text-xs font-semibold text-slate-400">Keputusan Akhir</p>
                                <p class="text-[11px] text-slate-400">Menunggu persetujuan admin</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Info Period Box -->
                <div class="mt-6 pt-5 border-t border-slate-100 text-xs text-slate-500 space-y-1.5">
                    <div class="flex justify-between">
                        <span>Periode:</span>
                        <span class="font-bold text-slate-800">{{ $registration->period->school_year ?? 'Aktif' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Status Periode:</span>
                        <span class="text-emerald-700 font-semibold">{{ $registration->period?->is_active ? 'Dibuka' : 'Ditutup' }}</span>
                    </div>
                </div>
            </div>

            <!-- Supporting info -->
            <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 text-xs text-slate-600">
                <p class="font-bold text-slate-800 mb-1">Catatan Kebijakan:</p>
                <p class="leading-relaxed">Keputusan persetujuan dan verifikasi administrasi ekstrakurikuler dikelola oleh pihak pengelola sekolah.</p>
            </div>

        </div>

    </div>

</div>
@endsection
