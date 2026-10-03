@extends('layouts.student')

@section('title', 'Formulir Pendaftaran Ekstrakurikuler')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    <!-- Header -->
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Formulir Pendaftaran Ekstrakurikuler</h1>
        <p class="text-sm text-slate-500 mt-1">Konfirmasi pilihan ekstrakurikuler dan kirim pengajuan ke pihak sekolah</p>
    </div>

    <!-- Active Period Badge -->
    @if($activePeriod)
        <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-4 flex items-center justify-between text-xs text-emerald-900">
            <div class="flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span><strong>Periode Aktif:</strong> {{ $activePeriod->name }}</span>
            </div>
            <span class="px-2 py-0.5 rounded bg-emerald-100 text-emerald-800 font-bold uppercase text-[10px]">Pendaftaran Dibuka</span>
        </div>
    @else
        <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 flex items-center gap-3 text-xs text-amber-900">
            <svg class="w-5 h-5 text-amber-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            <div>
                <strong>Pemberitahuan:</strong> Saat ini belum ada periode pendaftaran ekstrakurikuler yang dibuka. Silakan hubungi pihak sekolah.
            </div>
        </div>
    @endif

    @if($existingRegistration)
        <!-- Peringatan Pendaftaran Sudah Ada -->
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-5 text-blue-900 space-y-3">
            <div class="flex items-center gap-2 text-sm font-bold text-blue-950">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>Anda Sudah Mendaftar pada Periode Ini</span>
            </div>
            <p class="text-xs text-blue-800 leading-relaxed">
                Anda telah mengajukan pendaftaran untuk ekstrakurikuler <strong>{{ $existingRegistration->extracurricular?->name }}</strong> dengan nomor registrasi <strong>{{ $existingRegistration->registration_number }}</strong> (Status: <span class="capitalize font-semibold">{{ $existingRegistration->status }}</span>).
            </p>
            <div class="pt-2 flex items-center gap-3">
                <a href="{{ route('siswa.pendaftaran.sukses') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-lg shadow-sm transition-colors">
                    Lihat Bukti Pendaftaran &rarr;
                </a>
                <a href="{{ route('siswa.riwayat') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-semibold rounded-lg transition-colors">
                    Riwayat Pengajuan
                </a>
            </div>
        </div>
    @elseif($activePeriod)
        <!-- Form Card -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 sm:p-8">
            <form method="POST" action="{{ route('siswa.pendaftaran.store') }}" class="space-y-6">
                @csrf

                <!-- Section 1: Ekskul Pilihan -->
                <div>
                    <label for="extracurricular_id" class="block text-sm font-bold text-slate-900 mb-2">1. Pilih Ekstrakurikuler</label>
                    <div class="space-y-3">
                        <select
                            id="extracurricular_id"
                            name="extracurricular_id"
                            onchange="window.location.href='{{ route('siswa.pendaftaran.index') }}?ekskul_id=' + this.value"
                            class="block w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
                        >
                            @foreach($extracurriculars as $ekskul)
                                <option value="{{ $ekskul->id }}" {{ ($selectedExtracurricular && $selectedExtracurricular->id === $ekskul->id) ? 'selected' : '' }}>
                                    {{ $ekskul->name }} ({{ $ekskul->category }})
                                    @if($topRecommendation && $topRecommendation['extracurricular_id'] === $ekskul->id)
                                        ★ Rekomendasi Teratas
                                    @endif
                                </option>
                            @endforeach
                        </select>

                        @if($selectedExtracurricular)
                        <div class="p-4 rounded-xl border border-blue-200 bg-blue-50/50 flex items-start justify-between gap-4">
                            <div class="flex items-start gap-3">
                                <span class="text-2xl p-2 bg-white rounded-lg border border-blue-100 shadow-xs">🚩</span>
                                <div>
                                    <div class="flex items-center gap-2">
                                        <h3 class="text-base font-bold text-slate-900">{{ $selectedExtracurricular->name }}</h3>
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-blue-100 text-blue-700">{{ $selectedExtracurricular->category }}</span>
                                    </div>
                                    <p class="text-xs text-slate-600 mt-1">{{ $selectedExtracurricular->description }}</p>

                                    @if($topRecommendation && $topRecommendation['extracurricular_id'] === $selectedExtracurricular->id)
                                        <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-blue-700 mt-2">
                                            <svg class="w-3.5 h-3.5 text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                            Rekomendasi Teratas Sistem (Skor: {{ round($topRecommendation['preference_score'] * 100) }}/100)
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <a href="{{ route('siswa.ekstrakurikuler.show', $selectedExtracurricular->id) }}" class="text-xs font-semibold text-blue-600 hover:text-blue-800 underline flex-shrink-0">
                                Detail Info
                            </a>
                        </div>
                        @endif

                        @error('extracurricular_id')
                            <p class="text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Section 2: Ringkasan Identitas Siswa -->
                <div>
                    <label class="block text-sm font-bold text-slate-900 mb-2">2. Identitas Pendaftar</label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs bg-slate-50 p-4 rounded-xl border border-slate-200">
                        <div>
                            <span class="text-slate-500 block">Nama Lengkap</span>
                            <span class="text-slate-900 font-bold mt-0.5 block text-sm">{{ $student->name }}</span>
                        </div>
                        <div>
                            <span class="text-slate-500 block">Nomor Induk Siswa (NIS)</span>
                            <span class="text-slate-900 font-bold mt-0.5 block text-sm">{{ $student->nis }}</span>
                        </div>
                        <div>
                            <span class="text-slate-500 block">Kelas</span>
                            <span class="text-slate-900 font-bold mt-0.5 block text-sm">{{ $student->class_name ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="text-slate-500 block">Nomor WhatsApp Aktif</span>
                            <span class="text-slate-900 font-bold mt-0.5 block text-sm">{{ $student->whatsapp ?? '-' }}</span>
                        </div>
                    </div>
                    <p class="text-[11px] text-slate-400 mt-1.5">*Data diambil otomatis dari profil akun siswa kamu.</p>
                </div>

                <!-- Section 3: Catatan / Alasan Memilih -->
                <div>
                    <label for="motivation" class="block text-sm font-bold text-slate-900 mb-2">3. Alasan atau Motivasi Bergabung (Opsional)</label>
                    <textarea
                        id="motivation"
                        name="motivation"
                        rows="3"
                        class="w-full rounded-lg border border-slate-200 p-3 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none"
                        placeholder="Tuliskan motivasi singkat atau harapan kamu mengikuti kegiatan ekstrakurikuler ini..."
                    >{{ old('motivation') }}</textarea>
                    @error('motivation')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Section 4: Persetujuan & Pernyataan -->
                <div class="space-y-3 pt-2">
                    <label class="block text-sm font-bold text-slate-900">4. Lembar Persetujuan Siswa</label>

                    <label class="flex items-start gap-3 p-3 rounded-lg border border-slate-200 hover:bg-slate-50 cursor-pointer">
                        <input type="checkbox" name="agreement" value="1" required checked class="mt-0.5 rounded text-blue-600 focus:ring-blue-500">
                        <span class="text-xs text-slate-700 leading-relaxed">
                            Saya memilih ekstrakurikuler ini secara <strong>sadar dan sukarela</strong> berdasarkan pertimbangan pribadi serta arahan orang tua/wali.
                        </span>
                    </label>

                    <label class="flex items-start gap-3 p-3 rounded-lg border border-slate-200 hover:bg-slate-50 cursor-pointer">
                        <input type="checkbox" name="agreement_rules" value="1" required checked class="mt-0.5 rounded text-blue-600 focus:ring-blue-500">
                        <span class="text-xs text-slate-700 leading-relaxed">
                            Saya memahami bahwa hasil rekomendasi kuesioner adalah <strong>alat bantu pertimbangan</strong>, dan saya bersedia mematuhi aturan serta tata tertib ekstrakurikuler di SMKN 3 Payakumbuh.
                        </span>
                    </label>

                    <label class="flex items-start gap-3 p-3 rounded-lg border border-slate-200 hover:bg-slate-50 cursor-pointer">
                        <input type="checkbox" name="agreement_data" value="1" required checked class="mt-0.5 rounded text-blue-600 focus:ring-blue-500">
                        <span class="text-xs text-slate-700 leading-relaxed">
                            Data identitas dan informasi yang saya sampaikan adalah benar dan dapat dipertanggungjawabkan.
                        </span>
                    </label>

                    @error('agreement')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="pt-4 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <a href="{{ route('siswa.rekomendasi.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800">
                        &larr; Kembali ke Rekomendasi
                    </a>
                    <button
                        type="submit"
                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow-sm transition-colors"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Konfirmasi &amp; Kirim Pendaftaran</span>
                    </button>
                </div>

            </form>
        </div>
    @endif

</div>
@endsection
